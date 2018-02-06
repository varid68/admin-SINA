@extends('layout')
@section('head')
  <link rel="stylesheet" href="{{ asset('css/mahasiswa.css') }}">
@endsection

@section('heading')
  Remidial
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Simple Full Width Table</h3>
          <button class="btn btn-sm btn-warning pull-right" id="btn-modal-download">download pdf</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tr>
              <th style="width: 3%">No.</th>
              <th style="width: 12%">Nim</th>
              <th style="width: 25%">Nama</th>
              <th style="width: 10%">Absensi</th>
              <th style="width: 10%">Tugas</th>
              <th style="width: 10%">Uts</th>
              <th style="width: 10%">Uas</th>
              <th style="width: 10%">Nilai akhir</th>
              <th style="width: 10%">Option</th>
            </tr>
            @php $no = 1 @endphp
            @foreach((array) $remidial as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item["nim"] }}</td>
              <td>{{ $item["nama"] }}</td>
              <td>{{ $item["absensi"] }}</td>
              <td>{{ $item["tugas"] }}</td>
              <td>{{ $item["uts"] }}</td>
              <td>{{ $item["uas"] }}</td>
              <td>{{ $item["nilai_akhir"] }} <span style="color:red;font-weight:bolder">({{ $item["grade"] }})</span></td>
              <td>
                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default">Edit</button>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>

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
    // $('button').click(function() {
    //   let selector = $(this).parent();
    //   let nim = $selector.siblings(".nim").text();
    //   let nama = $selector.siblings(".nama").text();
    //   let alamat = $selector.data('alamat');

    //   $('.modal-nama').text(nama);
    //   $('.modal-nim').text(nim);
    //   $('.modal-alamat').text(alamat);
    // });

    $('#btn-modal-download').click(function() {
      window.location = '/remidial-pdf';
    });
  </script>
  <!-- <script src="{{ asset('js/custom/nilai.js') }}"></script> -->
@endsection
