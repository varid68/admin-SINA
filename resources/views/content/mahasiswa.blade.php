@extends('layout')
@section('head')
  <meta name="_token" content="{!! csrf_token() !!}">
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/mahasiswa.css') }}">
@endsection

@section('heading')
  Mahasiswa
@endsection

@section('content')
  <form action="#" id="delete-form" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="DELETE">
  </form><!-- FORM DELETE -->

  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">List mahasiswa amik al-muslim</h3>
          @php $id = Session::get('id'); @endphp
          <button class="btn btn-sm btn-warning pull-right" id="btn-modal-filter">download pdf</button>
          @if ($id == 'admin')
          <button class="btn btn-sm btn-success margin pull-right" id="btn-modal-add">tambah</button>
          <a href={{ url('mahasiswa/up-grades') }}>
            <button class="btn btn-sm btn-default margin pull-right"><i class="fa fa-arrow-up"></i></button>
          </a>
          <a href={{ url('mahasiswa/down-grades') }}>
            <button class="btn btn-sm btn-default margin pull-right"><i class="fa fa-arrow-down"></i></button>
          </a>
          @endif
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 1%">No.</th>
                <th style="width: 8%">Nim</th>
                <th style="width: 20%">Nama</th>
                <th style="width: 10%">Gender</th>
                <th style="width: 22%">TTl</th>
                <th style="width: 10%">Jurusan</th>
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


      <div class="modal fade" id="general-modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="#">
            {{ csrf_field() }}
            <div class="modal-body">

              <div class="row form-group">
                <div class="col-md-2">
                  <p>Nim</p>
                </div>
                <div class="col-md-4">
                  <input type="number" name="nim" class="form-control input-sm" placeholder="masukkan nim" required />
                </div>
                <div class="col-md-2">
                  <p>Nama</p>
                </div>
                <div class="col-md-4">                  
                  <input type="text" name="nama" class="form-control input-sm" placeholder="masukkan nama" required />
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-2">
                  <p>gender</p>
                </div>
                <div class="col-md-4">
                  <select name="gender" id="gender" class="form-control input-sm" required>
                    <option selected disabled>pilih gender</option>
                    <option value="laki-laki">Laki Laki</option>
                    <option value="perempuan">Perempuan</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <p>TTL</p>
                </div>
                <div class="col-md-4">                  
                  <input type="text" name="ttl" class="form-control input-sm" placeholder="masukkan TTL" required />
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-2">
                  <p>alamat</p>
                </div>
                <div class="col-md-4">
                  <textarea name="alamat" class="form-control input-sm" rows="7" placeholder="Masukkan alamat lengkap calon mahasiswa" required ></textarea>
                </div>

                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <p>Jurusan</p>
                    </div>
                    <div class="col-md-8">                  
                      <select name="jurusan" id="jurusan" class="form-control input-sm" required >
                        <option selected disabled>pilih jurusan</option>
                        <option value="Manajemen Informatika">Manajemen Informatika</option>
                        <option value="Komputerisasi Akuntansi">Komputerisasi Akuntansi</option>
                      </select>
                    </div>
                  </div></br>
                  <div class="row">
                    <div class="col-md-4">
                      <p>semester</p>
                    </div>
                    <div class="col-md-8">                  
                      <select name="semester" id="semester" class="form-control input-sm" required >
                        <option selected disabled>pilih semester</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="Akselerasi I">Akselerasi I</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="Akselerasi II">Akselerasi II</option>
                      </select>
                    </div>
                  </div></br>
                  <div class="row">
                    <div class="col-md-4">
                      <p class="tm">Tahun masuk</p>
                    </div>
                    <div class="col-md-8">
                      <input type="number" name="tahun_masuk" class="form-control input-sm" placeholder="Masukkan tahun masuk" required />
                    </div>
                  </div>
                </div>

              </div>

              <div class="animate-flicker">Format Penulisan TTL : nama_kota/DD-MM-YYYY || ex : Bekasi/23-09-1992</div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger pull-right" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-sm btn-success btn-submit pull-right">Submit</button>
            </div>
            </form>
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

              <div class="row form-group">
                <div class="col-md-4">
                  <p>Jurusan</p>
                </div>
                <div class="col-md-8">
                  <select id="jurusan-modal" class="form-control input-sm">
                    <option selected disabled>pilih jurusan</option>
                    <option value="none">Semua jurusan</option>
                    <option value="Manajemen Informatika">Manajemen Informatika</option>
                    <option value="Komputerisasi Akuntansi">Komputerisasi Akuntansi</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-4">
                  <p>Semester</p>
                </div>
                <div class="col-md-8">
                  <select id="semester-modal" class="form-control input-sm">
                    <option selected disabled>pilih semester</option>
                    <option value="none">Semua semester</option>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="Akselerasi I">Akselerasi I</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                    <option value="Akselerasi II">Akselerasi II</option>
                  </select>
                </div>
              </div>

              <p style="color: red; font-style:italic;font-size:12px;text-align:center;display: none" id="warning">Silahkan pilih filter terlebih dahulu!</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-success pull-right" id="btn-download">Download PDF</button>
            </div>
          </div>
        </div>
      </div>
          <!-- /.modal -->
    </div>
  </div>


@endsection

@section('script')
  <script src="https://unpkg.com/sweetalert2@7.6.3/dist/sweetalert2.all.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.jqueryui.min.js"></script>
  <script src="{{ asset('js/custom/mahasiswa.js') }}"></script>
  <script>
    $('#btn-modal-add').click(function() {
      $('#general-modal').find('form').attr('action', "{{ url('mahasiswa/input') }}");      
    });

    $(document).on('click', '.edit', function() {
      $('#general-modal').find('form').attr('action', "{{ url('mahasiswa/edit') }}");
    });
  </script>
@include('sweet::alert')
@endsection
