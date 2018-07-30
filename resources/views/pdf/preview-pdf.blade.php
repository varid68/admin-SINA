@extends('layout')

@section('head')
  <style>
    .table-bordered>tbody>tr>td, .table-bordered>thead>tr>th {
      border: 1px solid #ccbfbf;
    }
    .table-bordered>thead>tr {
      border-top: 1px solid #ccbfbf;
    }
  </style>
@endsection

@section('heading')
  Preview Laporan Mahasiswa
@endsection

@section('content')
  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>NIM</th>
        <th>Nama Mahasiswa</th>
        <th>Gender</th>
        <th>Tempat, Tgl lahir</th>
        <th>Alamat</th>
        <th>Jurusan</th>
        <th>Tahun Masuk</th>
        <th>Semester</th>
      </tr>
    </thead>
    <tbody>
    @php $no = 1; @endphp
    @foreach ((array) $response as $item)
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $item->nim }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->gender }}</td>
        <td>{{ $item->ttl }}</td>
        <td>{{ $item->alamat }}</td>
        <td>{{ $item->jurusan }}</td>
        <td>{{ $item->tahun_masuk }}</td>
        <td>{{ $item->semester }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>

  <a href={{ url('mahasiswa/download-pdf?semester='.$a.'&jurusan='.$jurusan) }}>
    <button type="button" class="btn btn-sm btn-success">Cetak PDF</button>
  </a>
@endsection

@section('script')
@endsection