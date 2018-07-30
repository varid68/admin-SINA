<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Title</title>
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,300italic,400italic,600italic"> -->
  <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->

  <style>
    * {
      font-family: Helvetica;
      font-size: 12px;
    }
    .myTable {
      border: solid 1px #DDEEEE;
      border-collapse: collapse;
      border-spacing: 0;
      font: normal 13px Arial, sans-serif;
      }
    .myTable thead th {
      background-color: #DDEFEF;
      border: solid 1px #DDEEEE;
      color: #336B6B;
      padding: 10px;
      text-align: left;
      text-shadow: 1px 1px 1px #fff;
      }
    .myTable tbody td {
      border: solid 1px #DDEEEE;
      color: #333;
      padding: 10px;
      text-shadow: 1px 1px 1px #fff;
      }
    .myTable-horizontal tbody td {
      /* border-left: none;
      border-right: none; */
    }
    h2 {
      margin-bottom: 70px;
      text-align: center;
    }
  </style>
  <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
  <!-- <script src="main.js"></script> -->
</head>
<body>
  <div class="container">

  <h2>KARTU HASIL STUDI (KHS)</h2>

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
      <td>Jenjang</td>
      <td>: D3</td>
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

  <table style="width: 100%" class="myTable myTable-horizontal">
    <thead>
      <tr>
        <th style="width: 5%">#</th>
        <th style="width: 47%">Mata kuliah</th>
        <th style="width: 12%">Sks</th>
        <th style="width: 12%">Skala</th>
        <th style="width: 12%">Bobot</th>
        <th style="width: 12%">Mutu</th>
      </tr>
    </thead>
    <tbody id="tes">
      @php $no = 1 @endphp
      @foreach((array) $response['data'] as $item)
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $item['matkul'] }}</td>
        <td>{{ $item['sks'] }}</td>
        <td>{{ $item['skala_nilai'] }}</td>
        <td>{{ $item['bobot_nilai'] }}</td>
        <td>{{ $item['mutu'] }}</td>
      </tr>
      @endforeach
      <tr>
        <td></td>
        <td style="font-weight: bold;text-align:right">Total :</td>
        <td style="font-weight: bold">{{ $response['total_sks'] }}</td>
        <td></td>
        <td></td>
        <td style="font-weight: bold">{{ $response['total_mutu'] }}</td>
      </tr>
      <tr>
        <td></td>
        <td style="font-weight: bold;text-align:right">Indeks Prestasi Semester :</td>
        <td style="font-weight: bold">{{ round($response['total_mutu'] / $response['total_sks'], 2) }}</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  </div>

<!-- <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> -->
<!-- Bootstrap 3.3.7 -->
<!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
</body>
</html>