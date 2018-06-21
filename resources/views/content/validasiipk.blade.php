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

    @foreach($result as $item)
    <div class="col-md-6">
      <a href={{ url("hitungipk/$item->semester") }}>
        <button type="button" class="btn btn-block bg-purple">Pilih Semester {{ $item->semester }}</button>
      </a>
    </div>
    @endforeach

  </div>
@endsection