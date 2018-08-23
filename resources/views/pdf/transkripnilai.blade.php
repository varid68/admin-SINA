<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .bold-and-right {
      font-weight: bold;
      text-align: right;
    }
    .bold-and-center {
      font-weight: bold;
      text-align: center;
    }
    .right {
      text-align: right;
    }
    .center {
      text-align: center;
    }
    .bold {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h3 class="center">TRANSKRIP NILAI SEMENTARA</h3><br>

  <table style="margin-bottom: 10px">
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


  <table style="width: 100%">
    <thead>
      <tr>
        <th style="width: 6%">No.</th>
        <th style="width: 12%">KDMK</th>
        <th style="width: 42%">MATA KULIAH</th>
        <th style="width: 10%">SKS</th>
        <th style="width: 10%">NILAI</th>
        <th style="width: 10%">BOBOT</th>
        <th style="width: 10%;text-align:right">MUTU</th>
      </tr>
    </thead>
    <tbody>
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
        <td class="right">{{ number_format((float) $item['mutu'], 2, ',', '') }}</td>
      </tr>
      @endforeach
      @endforeach
      <tr><td></td></tr>
      <tr>
        <td colspan="3" class="bold-and-right">Total :</td>
        <td colspan="3" class="bold">{{ $total_sks }}</td>
        <td class="bold-and-right">{{ number_format((float) $total_mutu, 2, ',', '') }}</td>
      </tr>
      <tr>
        <td colspan="3" class="bold-and-right">Indeks Prestasi Kumulatif :</td>
        <td colspan="4" class="bold">{{ round($total_mutu / $total_sks, 2) }}</td>
      </tr>
    </tbody>
  </table>
</body>
</html>