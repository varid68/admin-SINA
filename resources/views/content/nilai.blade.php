@extends('layout')

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
          <td>{{ $item["nama"] }}</td>
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
@endsection
@section('script')
  <script>
    $('#btn-modal-download').click(function() {
      window.location = '/nilai-pdf';
    });
  </script>
@endsection