@extends('layout')
@section('head')
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/mahasiswa.css') }}">
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">List mahasiswa amik al-muslim</h3>
          <button class="btn btn-sm btn-warning pull-right" id="btn-modal-download">download pdf</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 3%">No.</th>
                <th style="width: 10%">Nim</th>
                <th style="width: 20%">Nama</th>
                <th style="width: 10%">Gender</th>
                <th style="width: 15%">TTl</th>
                <th style="width: 15%">Jurusan</th>
                <th style="width: 10%">Semester</th>
                <th style="width: 10%">Alamat</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row-container">
                <p class="first-column">Nama lengkap : </p>
                <p class="second-column modal-nama"> -- </p>
              </div>
              <div class="row-container">
                <p class="first-column">Nim : </p>
                <p class="second-column modal-nim"> -- </p>
              </div>
              <div class="row-container">
                <p class="first-column">Alamat lengkap : </p>
                <p class="second-column modal-alamat"> -- </p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</button>
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
                <!-- <div id="empty-div"></div> -->
              </div></br>

              <div class="row-container">
                <p style="flex: unset;font-weight:bold">Thn masuk: </p>
                <div style="flex: 1;margin-left:10px">
                  <select id="start" style="border-radius:3px;display: inline-block;">
                    <option selected disabled>pilih</option>                    
                    @for ($i = 2016; $i < 2020; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                  <span style="display: inline-block;font-size:12px"> s/d Tahun </span>
                  <select id="end" style="display: inline-block;border-radius:3px;">
                    <option selected disabled>pilih</option>                    
                    @for ($i = 2016; $i < 2020; $i++)
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
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
  <script>
    $(document).on('click', '.btn-success', function() {
      let selector = $(this).parent();
      let nim = selector.siblings().eq(1).text();
      let nama = selector.siblings().eq(2).text();
      let alamat = $(this).data('alamat');

      $('.modal-nama').text(nama);
      $('.modal-nim').text(nim);
      $('.modal-alamat').text(alamat);
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

      window.location = `/mahasiswa-pdf?start=${start}&end=${end}&jurusan=${jurusan}`;
    });

    $(".table-hover").dataTable({
      stateSave: true,
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: "mahasiswa/datatable",
      columns: [
        { data: 'DT_Row_Index', width: '3%', searchable: false, orderable: false },
        { data: 'nim', name: 'nim' },
        { data: 'nama', name: 'nama' },
        { data: 'gender', name: 'gender' },
        { data: 'ttl', name: 'ttl', searchable: false, orderable: false },    
        { data: 'jurusan', name: 'jurusan' },
        { data: 'semester', name: 'semester' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
      ]
    });
  </script>
  <!-- <script src="{{ asset('js/custom/nilai.js') }}"></script> -->
@endsection
