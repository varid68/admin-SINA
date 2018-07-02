@extends('layout')

@section('head')
  <style>
    #myModal .grade {
      text-align: center;
    }
    #myModal .grade {
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 65px;
      line-height: 45px;
      height: 80px;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
@endsection

@section('heading')
  Nilai
@endsection

@section('content')
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Nilai mahasiswa untuk matkul <strong>{{ Session::get('mata_kuliah') }}</strong>
      semester <strong>{{ Session::get('semester') }}</strong></h3>
      <button class="btn btn-sm btn-warning pull-right" id="btn-modal-download">download pdf</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table table-condensed">
        <tr>
          <th style="width: 3%">#</th>
          <th style="width: 8%">NIM</th>
          <th style="width: 25%">Nama</th>
          <th style="width: 10%">Jurusan</th>
          <th style="width: 10%">Absensi</th>
          <th style="width: 10%">Tugas</th>
          <th style="width: 10%">Uts</th>
          <th style="width: 10%">Uas</th>
          <th style="width: 10%">Nilai akhir</th>
        </tr>
        @php $no = 1 @endphp
        @foreach((array) $list as $item)
        <tr>
          <td>{{ $no++ }}</td>
          <td>{{ $item["nim"] }}</td>
          <td>
            <a data-toggle="modal" href="#myModal">{{ $item["nama"] }}</a>
          </td>
          <td>{{ $item["jurusan"] }}</td>
          <td>{{ $item["absensi"] }}</td>
          <td>{{ $item["tugas"] }}</td>
          <td>{{ $item["uts"] }}</td>
          <td>{{ $item["uas"] }}</td>
          <td>{{ $item["nilai_akhir"] }} <span style="color:#FF9800;font-weight:bolder">({{ $item["grade"] }})</span></td>
        </tr>
        @endforeach
      </table>
    </div>
    <!-- /.box-body -->
  </div>

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <form method="POST" action="{{ url('nilai') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-2">Nim</div>
            <div class="col-md-4 nim">: ---</div>
            <div class="col-md-2">Nama</div>
            <div class="col-md-4 nama">: ---</div>
          </div><br />

          <div class="row">
            <div class="col-md-2">Nilai Absensi</div>
            <div class="col-md-4">
              <input type="number" name="absensi" class="form-control input-sm absensi" required />
            </div>
            <div class="col-md-2">Nilai Tugas</div>
            <div class="col-md-4">
              <input type="number" name="tugas" class="form-control input-sm tugas" required />
            </div>
          </div><br />
          
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-4">Nilai UTS</div>
                <div class="col-md-8">
                  <input type="number" name="uts" class="form-control input-sm uts" required />
                </div>
              </div><br />
              <div class="row">
                <div class="col-md-4">Nilai UAS</div>
                <div class="col-md-8">
                  <input type="number" name="uas" class="form-control input-sm uas" required />
                </div>
              </div>
            </div>

            <div class="col-md-6 grade">
              <input type="hidden" name="nim" class="nim2" />
              <input type="hidden" name="nilai_akhir" class="nilai-akhir" />
              <span class="skala-nilai">89 (c+)</span>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </form>
      </div>

    </div>
  </div>
  
@endsection
@section('script')
  <script src="{{ asset('js/custom/nilai.js') }}"></script>
  <script src="https://unpkg.com/sweetalert2@7.6.3/dist/sweetalert2.all.js"></script>  
@include('sweet::alert')
@endsection