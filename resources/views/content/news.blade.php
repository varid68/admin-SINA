@extends('layout')
@section('head')
  <meta name="_token" content="{!! csrf_token() !!}">
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/news.css') }}">
@endsection

@section('heading')
  News
@endsection

@section('content')
  <div id="container" data-session="{{ Session::get('dosen') }}">

    <div id="preview-container">
      <img src="{{ asset('images/notch.png') }}">
      <img src="{{ asset('images/notch-bottom.png') }}" id="bottom">
      <div id="preview">
        Klik Content kolom untuk menampilkan preview di sini..
      </div>
    </div> <!-- END PREVIEW DIV -->

    <div id="news-list">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">List news amik al-muslim</h3>
          <button type="button" class="btn btn-sm btn-info pull-right" id="to-form">Tulis</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tr>
              <th style="width: 3%">No.</th>
              <th style="width: 15%">Tanggal</th>
              <th style="width: 50%">Content</th>
              <th style="width: 20%">Author</th>
              <th style="width: 12%">Option</th>
            </tr>
            @php date_default_timezone_set("Asia/Jakarta");
            $no = 7 * $page - (7 - 1) @endphp
            @foreach((array) $list as $item)
            <tr>
              <td>{{ $no++ }}</td>
              @php $date = date('j F Y', $item->created_at); @endphp
              <td>{{ $date }}</td>
              <td class="title" data-preview="{{ $item->content }}">
                <a href="javascript: void(0)" title="klik untuk menampilkan preview">
                  {{ $item->title }}
                </a>
              </td>
              <td>{{ $item->author }}</td>
              <td data-id="{{ $item->id_news }}" data-image="{{ $item->image_name }}">
                <button type="button" class="btn btn-sm btn-danger delete">
                  Hapus
                </button>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
      
      @if ($page > 1)
        @php $prev = $page - 1;
        $style = 'unset'; @endphp
      @else
        @php $prev = 1;
        $style = 'none' @endphp
      @endif

      @if ($page == $total)
        @php $next = $page;
        $style2 = 'none'; @endphp
      @else
        @php $next = $page + 1;
        $style2 = 'unset'; @endphp
      @endif

      <ul class="pagination pagination-sm no-margin">
        <li><a href="{{ url('news/'.$prev) }}" style="pointer-events:{{ $style }}">&laquo;</a></li>
        @for($i=1;$i<=$total;$i++)
        <li><a href="{{ url('news/'.$i) }}">{{ $i }}</a></li>
        @endfor
        <li><a href="{{ url('news/'.$next) }}" style="pointer-events:{{ $style2 }}">&raquo;</a></li>
      </ul>

    </div> <!-- END NEWS-LIST -->

    <form action="#" id="delete-form" method="POST">
      {{ csrf_field() }}
      <input type="hidden" name="_method" value="DELETE">
    </form><!-- FORM DELETE -->

    <form method="POST" id="news-form" style="display: none" enctype="multipart/form-data">
      {{ csrf_field() }}
      <textarea id="summernote" name="editordata"></textarea>
      <input type="file" name="fileToUpload" id="photo">
      <img src="#" id="someImageTagID"/>
      <div class="pull-right">
        <button type="button" class="btn btn-success" id="send">Send</button>
        <button type="button" class="btn btn-danger" id="close">Close</button>
      </div>
    </form><!-- END FORM INPUT NEWS -->

    
  </div><!-- END CONTAINER -->
@endsection

@section('script')
  <script src="https://unpkg.com/sweetalert2@7.6.3/dist/sweetalert2.all.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
  <!-- <script src="{{ asset('js/custom/nilai.js') }}"></script> -->
  <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>
  <script>
    let config = {
      apiKey: "AIzaSyCq_UE61FHK6LZysjv4G1XJ9qO3oRfoC4g",
      authDomain: "amik-fdde1.firebaseapp.com",
      databaseURL: "https://amik-fdde1.firebaseio.com",
      projectId: "amik-fdde1",
      storageBucket: "amik-fdde1.appspot.com",
      messagingSenderId: "198277777552",
    };
    firebase.initializeApp(config);

    let title = '';
    let htmlCode = '';
    let width = 10;
    let interval = null;

    (function addClassActive(){
      const split = location.href.split('/');
      const page = split.length > 4 ? split[4] : 1;
      $('ul.pagination').find('li a').each(function() {
        let parents = $(this).parents('li');
        $(this).text() == page ? parents.addClass('active') : parents.removeClass('active');
      });
    }());

    $("#photo").change(function() {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
  
        reader.onload = function(e) {
          $('#someImageTagID').css('visibility', 'unset');
          $('#someImageTagID').attr('src', e.target.result);
        }
  
        reader.readAsDataURL(this.files[0]);
      }
    });
    
    $('.delete').click(function() {
      let id = $(this).parent().data('id');
      let image_name = $(this).parent().data('image');
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $('.progress').css('display', 'block');
          intervalLoading();

          const storage = firebase.storage().ref();
          const ref = storage.child('news/'+image_name);
          ref.delete().then(function() {
            $('#delete-form').attr('action', '/news/'+id).submit();
          }).catch(function(err) {
            console.log(err);
          });
        }
      })
    });

    $('.title a').click(function() {
      const view = $(this).parent().data('preview');
      $('#preview').html(view);
    });

    $('#to-form').click(function() {
      $('#news-list').hide(500);
      $('#news-form').show(500);
      $('#preview').text('Preview akan muncul otomatis setelah anda menulis..')      
    });

    $('#close').click(function() {
      $('#news-form').hide(500);
      $('#news-list').show(500);
      $('#preview').text('Klik Content kolom untuk menampilkan preview di sini..');
      $('#summernote').summernote('reset');
    });

    $('#summernote').summernote({
      placeholder: 'write news here...',
      minHeight: 300,
      callbacks: {
        onKeyup: function(e) {
          const innerText = e.target.innerText.trim();
          if (innerText.length > 0) {
            const dosen = $('#container').data('session');
            const ttd = '</br><p style="text-align:right;margin-right:30px">TTD</p><p style="text-align:right">'+dosen+'</p>';
            $('#preview').html(e.target.innerHTML+ttd);
            title = e.target.innerText.trim();
            htmlCode = e.target.innerHTML+ttd;
          } else {
            $('#preview').text('Preview akan muncul otomatis setelah anda menulis..')      
          }
        }
      },
      toolbar: [
        ['fontstyle', ['fontsize', 'bold', 'italic', 'underline', 'strikethrough', 'clear', 'color',]],
        ['paragraph style', ['style', 'ol', 'ul', 'paragraph', 'height']],
        ['insert', ['link', 'hr']],
        ['misc', ['codeview', 'undo', 'redo']],
      ]
    });

    function intervalLoading () {
      interval = setInterval(function () {
        $('.progress-bar').css('width', width + '%');
        width = width < 100 ? width + 10 : 10;
      }, 1000);
    }

    function onSuccessUpload(url, image_name) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

      const formData = {
        image: url,
        image_name: image_name,
        content: htmlCode,
        title: title,
        author: $('#container').data('session'),
        created_at: Math.round(new Date().getTime() / 1000),
      };

      $.ajax({
        type: 'POST',
        url: '/news/input',
        data: formData,
        success: function (data) {
          onSuccessPost(data);
        },
        error: function (err) {
          alert(err);
        }
      });
    }

    function onSuccessPost(data) {
      clearInterval(interval);
      $('.progress').css('display', 'none');
      window.location = '/news';
    }

    $('#send').click(function() {
      let src = $('#someImageTagID').attr('src');
      if (title.length < 1) {
        swal(
          'Oops...',
          'Field news masih kosong..',
          'error'
        );
        return false;
      }

      if (src == '#') {
        swal(
          'Oops...',
          'Anda belum memilih thumbnail...!',
          'error'
        );
        return false;
      }

      $('.progress').css('display', 'block');
      intervalLoading();

      const ref = firebase.storage().ref();
      const file = document.querySelector('#photo').files[0];
      const name = (+new Date()) + '-' + file.name;
      const metadata = {
        contentType: file.type
      };
      const task = ref.child('news/'+name).put(file, metadata);
      task.then((snapshot) => {
        const url = snapshot.downloadURL;
        onSuccessUpload(url, name);
        document.querySelector('#someImageTagID').src = url;
      }).catch((error) => {
        console.error(error);
      });
    });
  </script>
@include('sweet::alert')
@endsection
