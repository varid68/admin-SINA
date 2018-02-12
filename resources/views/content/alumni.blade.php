@extends('layout')
@section('head')
  <link rel="stylesheet" href="{{ asset('css/mahasiswa.css') }}">
  <style>
    #modal-edit .form-control {
      border-radius: 3px;
    }
    #modal-edit .row {
      margin-bottom: 10px;
    }
  </style>
@endsection

@section('heading')
  Alumni
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">List alumni mahasiswa amik</h3>
          <button class="btn btn-sm btn-warning pull-right" id="btn-modal-download">download pdf</button>
          @if (Session::get('id') == 'super-admin')
          <button class="btn bg-purple btn-sm pull-right" style="margin-right:5px" id="btn-modal-d">upload excel</button>
          @endif
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tr>
              <th style="width: 3%">#</th>
              <th style="width: 7%">Nim</th>
              <th style="width: 22%">Nama</th>
              <th style="width: 10%">Gender</th>
              <th style="width: 15%">TTl</th>
              <th style="width: 15%">Jurusan</th>
              <th style="width: 11%">Option</th>
            </tr>

            @php $no = 10 * $page - (10 - 1) @endphp
            @foreach((array) $list as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item->nim }}</td>
              <td>{{ $item->nama }}</td>
              <td>{{ $item->gender }}</td>
              <td>{{ $item->ttl }}</td>
              <td>{{ $item->jurusan }}</td>
              <td>
                <button type="button" class="btn btn-sm btn-success btn-modal" data-alamat="{{$item->alamat}}" 
                  data-ta="{{$item->judul_ta}}" data-toggle="modal" data-target="#modal-detail">Detail</button>
                @if (Session::get('id') == 'super-admin')
                <button type="button" class="btn bg-maroon btn-sm btn-modal-edit" data-toggle="modal" data-target="#modal-edit">Edit</button>
                @endif
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
        <li><a href="{{ url('alumni/'.$prev) }}" style="pointer-events:{{ $style }}">&laquo;</a></li>
        @for($i=1;$i<=$total;$i++)
        <li><a href="{{ url('alumni/'.$i) }}">{{ $i }}</a></li>
        @endfor
        <li><a href="{{ url('alumni/'.$next) }}" style="pointer-events:{{ $style2 }}">&raquo;</a></li>
      </ul>

      <div class="modal fade" id="modal-detail">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row-container">
                <p class="first-column">Nama lengkap : </p>
                <p class="second-column modal-nama">Farid tanwir</p>
              </div>
              <div class="row-container">
                <p class="first-column">Nim : </p>
                <p class="second-column modal-nim">216020</p>
              </div>
              <div class="row-container">
                <p class="first-column">Alamat lengkap : </p>
                <p class="second-column modal-alamat">Kampung Tanah Baru Rt 08/09, desa Harja mekar,
                  kec. Cikarang utara, kab. Bekasi
                </p>
              </div>
              <div class="row-container">
                <p class="first-column">Judul tugas akhir : </p>
                <p class="second-column modal-ta">Kampung Tanah Baru Rt 08/09, desa Harja mekar,
                  kec. Cikarang utara, kab. Bekasi
                </p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row-container">
              <p class="first-column">Nim : </p>
              <p class="second-column nim">216020</p>
            </div>

            <div class="row">
              <p class="col-md-3 text-right">Nama lengkap : </p>
              <div class="col-md-3 no-padding">
                <input type="text" name="nama" class="form-control input-sm" required autofocus>
              </div>
              <p class="col-md-3 text-right">Gender : </p>
              <div class="col-md-3">
                <select name="gender" class="form-control input-sm">
                  <option selected disabled>-- Options --</option>
                  <option value="laki-laki">Laki laki</option>
                  <option value="perempuan">Perempuan</option>
                </select>
              </div>
            </div>

            <div class="row">
              <p class="col-md-3 text-right">Tempat, tgl lahir : </p>
              <div class="col-md-3 no-padding">
                <input type="text" name="ttl" class="form-control input-sm" required autofocus>              
              </div>
            </div>

            <div class="row">
              <p class="col-md-3 text-right">Alamat : </p>
              <div class="col-md-6 no-padding">
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
              </div>
            </div>

            <div class="row">
              <p class="col-md-3 text-right">Jurusan : </p>
              <div class="col-md-3 no-padding">
                <select name="jurusan" class="form-control input-sm">
                  <option selected disabled>-- Options --</option>
                  <option value="Manajemen Informatika">Manajemen Informatika</option>
                  <option value="Komputerisasi Akuntansi">Komputerisasi Akuntansi</option>
                </select>
              </div>
              <p class="col-md-3 text-right">Tahun masuk : </p>
              <div class="col-md-3">
                <select name="tahun_masuk" class="form-control input-sm">
                  @for ($i = 2014;$i < 2020;$i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>

            <div class="row">
              <p class="col-md-3 text-right">Judul tugas akhir : </p>
              <div class="col-md-6 no-padding">
                <textarea name="judul_ta" class="form-control" rows="6" required></textarea>              
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger pull-right" style="margin-left:10px" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-sm btn-success pull-right" data-dismiss="modal">Save</button>
          </div>
        </div>
      </div>
    </div>

      <div class="modal fade" id="modal-filter">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modal filter</h4>
            </div>

            <div class="modal-body">

              <div class="row-container">
                <p class="first-column">Jurusan : </p>
                <select id="jurusan-modal">
                  <option selected disabled>pilih</option>
                  <option value="none">Semua jurusan</option>
                  <option value="Manajemen Informatika">Manajemen Informatika</option>
                  <option value="Komputerisasi Akuntansi">Komputerisasi Akuntansi</option>
                </select>
              </div></br>

              <div class="row-container">
                <p style="flex: unset;font-weight:bold">Tahun lulus: </p>
                <div style="flex: 1;margin-left:10px">
                  <select id="start" style="border-radius:3px;display: inline-block;">
                    <option selected disabled>pilih</option>                    
                    @for ($i = 2010; $i < 2017; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                  <span style="display: inline-block;font-size:12px"> s/d Tahun </span>
                  <select id="end" style="display: inline-block;border-radius:3px;">
                    <option selected disabled>pilih</option>                    
                    @for ($i = 2010; $i < 2017; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                </div>
              </div>
                <p style="color: red; font-style:italic;font-size:12px;text-align:center;display: none" id="warning">Silahkan pilih filter terlebih dahulu!</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-success pull-right" id="btn-download">Download PDF</button>
            </div>
          </divx>
        </div>
      </div>
          <!-- /.modal -->
    </div>
  </div>


@endsection

@section('script')
  <script>
    (function addClassActive(){
      const split = location.href.split('/');
      const page = split.length > 4 ? split[4] : 1;
      $('ul.pagination').find('li a').each(function() {
        let parents = $(this).parents('li');
        $(this).text() == page ? parents.addClass('active') : parents.removeClass('active');
      });
    }());

    $('.btn-modal').click(function() {
      const nim = $(this).parent().siblings().eq(1).text();
      const nama = $(this).parent().siblings().eq(2).text()
      const alamat = $(this).data('alamat');
      const ta = $(this).data('ta');

      $('.modal-nama').text(nama);
      $('.modal-nim').text(nim);
      $('.modal-alamat').text(alamat);
      $('.modal-ta').text(ta);
    });

    $('#btn-modal-download').click(function() {
      $('#modal-filter').modal('show');
    });

    $('#btn-download').click(function() {
      const start = $('#start').val();
      const end = $('#end').val();
      const jurusan = $('#jurusan-modal').val();

      if (start == null || end == null || jurusan == null) {
        $('#warning').show();
        return false;
      } else {
        $('#warning').hide();
      }

      window.location = `/alumni-pdf?start=${start}&end=${end}&jurusan=${jurusan}`;
    });

    $('.btn-modal-edit').click(function() {
      const nim = $(this).parent().siblings().eq(1).text();
      const nama = $(this).parent().siblings().eq(2).text();
      const gender = $(this).parent().siblings().eq(3).text();
      const ttl = $(this).parent().siblings().eq(4).text();
      const alamat = $(this).siblings().data('alamat');
      const jurusan = $(this).parent().siblings().eq(5).text();
      const tahun_masuk = 2015;
      const judul_ta = $(this).siblings().data('ta');


      $('#modal-edit .nim').text(nim);
      $('#modal-edit').find('input[name=nama]').val(nama);
      $('#modal-edit').find('select[name=gender]').val(gender);
      $('#modal-edit').find('input[name=ttl]').val(ttl);
      $('#modal-edit').find('textarea[name=alamat]').val(alamat);
      $('#modal-edit').find('select[name=jurusan]').val(jurusan);
      $('#modal-edit').find('select[name=tahun_masuk]').val(tahun_masuk);
      $('#modal-edit').find('textarea[name=judul_ta]').val(judul_ta);
    });
  </script>
  <!-- <script src="{{ asset('js/custom/nilai.js') }}"></script> -->
@endsection
