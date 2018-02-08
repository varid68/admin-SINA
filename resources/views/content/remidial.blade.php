@extends('layout')
@section('head')
  <link rel="stylesheet" href="{{ asset('css/mahasiswa.css') }}">
  <style>
    .absensi, .tugas, .uts, .uas {
      border-radius: 4px;
      display: none;
    }
  </style>
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
              <td>
                <span>{{ $item["absensi"] }}</span>
                <input type="text" name="absensi" class="form-control input-sm input absensi" value="{{ $item['absensi'] }}" data-absensi="{{ $item['absensi'] }}" required>
              </td>
              <td>
                <span>{{ $item["tugas"] }}</span>
                <input type="text" name="tugas" class="form-control input-sm input tugas" value="{{ $item['tugas'] }}" data-tugas="{{ $item['tugas'] }}" required>                
              </td>
              <td>
                <span>{{ $item["uts"] }}</span>
                <input type="text" name="uts" class="form-control input-sm input uts" value="{{ $item['uts'] }}" data-uts="{{ $item['uts'] }}" required>                
              </td>
              <td>
                <span>{{ $item["uas"] }}</span>
                <input type="text" name="uas" class="form-control input-sm input uas" value="{{ $item['uas'] }}" data-uas="{{ $item['uas'] }}" required>                
              </td>
              <td class="nilai_akhir">{{ $item["nilai_akhir"] }} <span style="color:red;font-weight:bolder">({{ $item["grade"] }})</span></td>
              <td>
                <div class="on-edit" style="display:none">
                  <button type="button" class="btn btn-sm btn-success save">
                    <i class="fa fa-floppy-o"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-danger dismiss">
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
                <button type="button" class="btn btn-sm btn-info">Edit</button>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('script')
  <script src="{{ asset('js/custom/remidial.js') }}"></script>
@endsection
