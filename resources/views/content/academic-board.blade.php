@extends('layout')

@section('heading')
  Academic Board
@endsection

@section('content')
  <div class="row">
    <table style="margin-bottom: 10px;margin-left:15px">
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
    <tr>
      <td>IPK</td>
      <td>: {{ $ipk }}</td>
    </tr>
  </table>

    <div style="display:flex;flex-wrap:wrap">
    @foreach((array) $list as $key => $value)
      <div class="box box-success" style="width:48%;margin:7px">
        <div class="box-header">
          <h3 class="box-title">Semester {{ $key }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed table-bordered table-striped">
            <tr>
              <th style="width: 3%">#</th>
              <th style="width: 8%">ID Matkul</th>
              <th style="width: 25%">Mata Kuliah</th>
              <th style="width: 10%">SKS</th>
              <th style="width: 10%">Nilai Akhir</th>
            </tr>
            @php $no = 1 @endphp
            @foreach((array) $value['scores'] as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item['id_matkul'] }}</td>
              <td>{{ $item['mata_kuliah'] }}</td>
              <td>{{ $item['sks'] }}</td>
              <td>{{ $item['nilai_akhir'] }}&nbsp;&nbsp;&nbsp;&nbsp; ({{ $item['skala'] }})</td>
            </tr>
            @endforeach
            <tr><td colspan="5">.</td></tr>
            <tr>
              <td class="text-center" colspan="4">Indeks Prestasi Semester</td>
              <td>{{ $value['ips'] or 0 }}</td>
            </tr>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    @endforeach
    </div>
  </div>
@endsection