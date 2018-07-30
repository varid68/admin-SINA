<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Provinsi</title>
    <body>
      <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;width: 100%; }
        .tg td{font-family:Arial;font-size:12px;padding:5px;border-style:solid;border-width:0.5px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
        .tg th{font-family:Arial;font-size:14px;font-weight:normal;padding:5px;border-style:solid;border-width:0.5px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
        .tg .tg-3wr7{font-weight:400;font-size:14px;font-family:"Consolas", Helvetica, sans-serif !important;text-align:center}
        .tg .tg-rv4w{font-size:12px;font-family:"Arial", Helvetica, sans-serif !important;}
        .center{text-align:center}
        .date{text-align:right;margin-right:30px}
        .name{text-align:right;}
      </style>

      <p style="text-align:center">List nilai mahasiswa mata kuliah {{ $matkul }}</p>
      <br>

      <table class="tg">
        <tr>
          <th style="width: 5%">#</th>
          <th style="width: 12%">NIM</th>
          <th style="width: 30%">Nama</th>
          <th style="width: 10%">Tugas</th>
          <th style="width: 10%">Uts</th>
          <th style="width: 10%">Uas</th>
          <th style="width: 13%">Nilai akhir</th>
        </tr>
        @php $no = 1; @endphp
        @foreach ((array) $nilai as $item)
        <tr>
          <td class="tg-rv4w center" width="5%">{{ $no++ }}</td>
          <td class="tg-rv4w" width="12%">{{ $item->nim }}</td>
          <td class="tg-rv4w" width="30%">{{ $item->nama }}</td>
          <td class="tg-rv4w" width="10%">{{ $item->tugas }}</td>
          <td class="tg-rv4w" width="10%">{{ $item->uts }}</td>
          <td class="tg-rv4w" width="10%">{{ $item->uas }}</td>
          <td class="tg-rv4w" width="13%">{{ $item->nilai_akhir }}</td>
        </tr>
        @endforeach
      </table><br>

      @php date_default_timezone_set("Asia/Jakarta");
      $date = date('j F Y'); @endphp
      <p class="date">Cikarang, {{ $date }}</p><br><br>
      <p class="name">{{ Session::get('dosen') }}</p>
    </body>
  </head>
</html>