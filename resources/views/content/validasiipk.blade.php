@extends('layout')

@section('heading')
  validasi Hitung IPK
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger">
        <ul>
          <li>Sebelum input IPK pilih semester terlebih dahulu</li>
          <li>Pilihan semester hanya ada 2 karena mengikuti semester aktif</li>
        </ul>
      </div>
    </div>

    <div class="col-md-6">
      <a href={{ url('hitungipk/I') }}>
        <button type="button" class="btn btn-block bg-purple">Pilih Semester I</button>
      </a>
    </div>
    <div class="col-md-6">
      <a href={{ url('hitungipk/III') }}>
        <button type="button" class="btn btn-block bg-purple">Pilih Semester III</button>
      </a>
    </div>
  </div>
@endsection