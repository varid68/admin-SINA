@extends('layout')
@section('head')
  <link rel="stylesheet" href="{{ asset('css/mahasiswa.css') }}">
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Simple Full Width Table</h3>

          <!-- <div class="box-tools">
            
          </div> -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-hover">
            <tr>
              <th style="width: 3%">No.</th>
              <th style="width: 10%">Nim</th>
              <th style="width: 25%">Nama</th>
              <th style="width: 10%">Absensi</th>
              <th style="width: 10%">Tugas</th>
              <th style="width: 10%">Uts</th>
              <th style="width: 10%">Uas</th>
              <th style="width: 10%">Nilai akhir</th>
              <th style="width: 12%">Edit nilai</th>
            </tr>
            @php $no = 1 @endphp
            @foreach((array) $list as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td class="nim">{{ $item->nim }}</td>
              <td class="nama">{{ $item->nama }}</td>
              <td>10</td>
              <td>67</td>
              <td>90</td>
              <td>100</td>
              <td style="color: red">78 B-</td>
              <td data-alamat="{{ $item->alamat }}">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-default">
                  Edit
                </button>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>

      <ul class="pagination pagination-sm no-margin">
        <li><a href="#">&laquo;</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">&raquo;</a></li>
      </ul>

      <div class="modal fade" id="modal-default">
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
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
          <!-- /.modal -->
    </div>
  </div>

@endsection

@section('script')
  <script>
    $('button').click(function() {
      let selector = $(this).parent();
      let nim = $selector.siblings(".nim").text();
      let nama = $selector.siblings(".nama").text();
      let alamat = $selector.data('alamat');

      $('.modal-nama').text(nama);
      $('.modal-nim').text(nim);
      $('.modal-alamat').text(alamat);
    });
  </script>
  <!-- <script src="{{ asset('js/custom/nilai.js') }}"></script> -->
@endsection
