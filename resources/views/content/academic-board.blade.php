@extends('layout')

@section('head')
  <style>
    .table-bordered {
      max-width: 88%;
      margin-left: 60px;
    }
    .table-bordered > tbody > tr > td {
      border: 1px solid #8da3be;
    }
    .table-bordered > tbody > tr > th {
      border: 1px solid #8da3be;
    }
    .btn-success {
      position: absolute;
      top: 109px;
      right: 65px;
    }
    .bold-and-center {
      font-weight: bold;
      text-align: center;
    }
    .bold-and-right {
      font-weight: bold;
      text-align: right;
    }
    .bold {
      font-weight: bold;
    }
    .desc {
      margin-left: 60px;
      margin-bottom: 20px;
    }
  </style>
@endsection

@section('heading')
  Academic Board
@endsection

@section('content')
  <div class="row">
    <table class="desc">
      <tr>
        <td>NIM</td>
        <td>: {{ $mahasiswa[0]->nim }}</td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>: {{ $mahasiswa[0]->nama }}</td>
      </tr>
      <tr>
        <td>Program Studi</td>
        <td>: {{ $mahasiswa[0]->jurusan }}</td>
      </tr>
      <tr>
        <td>Semester</td>
        <td>: {{ $mahasiswa[0]->semester }}</td>
      </tr>
      <tr>
        <td>Tahun Akademik</td>
        @php $a = $mahasiswa[0]->tahun_masuk + 1 @endphp
        <td>: {{ $mahasiswa[0]->tahun_masuk }}/{{ $a }}</td>
      </tr>
    </table>

    <a href={{ $mahasiswa[0]->nim.'?isForPdf=true' }}>
      <button type="button" class="btn btn-success">Cetak Transkrip nilai</button>
    </a>

    <table class="table table-condensed table-bordered">
      <tr>
        <th style="width: 3%">No.</th>
        <th style="width: 8%">KDMK</th>
        <th style="width: 48%">MATA KULIAH</th>
        <th style="width: 10%">SKS</th>
        <th style="width: 10%">NILAI</th>
        <th style="width: 10%">BOBOT</th>
        <th style="width: 10%">MUTU</th>
      </tr>
      @php $no = 1 @endphp
      @foreach((array) $list as $key => $value)
        <tr><td colspan="7"></td></tr>
        <tr>
          <td colspan="7" class="bold-and-center">Semester {{ $key }}</td>
        </tr>
        @foreach((array) $value as $item)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item['id_matkul'] }}</td>
            <td>{{ $item['mata_kuliah'] }}</td>
            <td>{{ $item['sks'] }}</td>
            <td>{{ $item['skala'] }}</td>
            <td>{{ number_format((float) $item['bobot_nilai'], 2, ',', '') }}</td>
            <td>{{ number_format((float) $item['mutu'], 2, ',', '') }}</td>
          </tr>
        @endforeach
      @endforeach
      <tr><td></td></tr>
      <tr>
        <td colspan="3" class="bold-and-right">Total :</td>
        <td colspan="3" class="bold">{{ $total_sks }}</td>
        <td class="bold">{{ number_format((float) $total_mutu, 2, ',', '') }}</td>
      </tr>
      <tr>
        <td colspan="3" class="bold-and-right">Indeks Prestasi Kumulatif :</td>
        <td colspan="4" class="bold">{{ round($total_mutu / $total_sks, 2) }}</td>
      </tr>
    </table>
  </div>
@endsection