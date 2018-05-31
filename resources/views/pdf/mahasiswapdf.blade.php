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
  
      {{-- <div style="font-family:Segoe Print; font-size:15px;font-style:italic">
        @if ($jurusan == 'none')
          <p>Menampilkan : jurusan Manajemen Informatika & Komputerisasi Akuntansi</p>
        @else
          <p>Menampilkan : jurusan {{ $jurusan }}</p>
        @endif          
        <p style="font-family:Arial; font-size:15px;font-style:italic">Tahun lulus : {{ $start }} ~ {{ $end }}</p>
      </div>
      <br> --}}

      <table class="tg">
        <tr>
          <th class="tg-3wr7">No.<br></th>
          <th class="tg-3wr7">NIM<br></th>
          <th class="tg-3wr7">Nama</th>
          <th class="tg-3wr7">Gender<br></th>
          <th class="tg-3wr7">TTL<br></th>
          <th class="tg-3wr7">Jurusan<br></th>
          <th class="tg-3wr7">Semester<br></th>
          <th class="tg-3wr7">Alamat<br></th>
        </tr>
        @php $no = 1; @endphp
        @foreach ((array) $response as $item)
        <tr>
          <td class="tg-rv4w center" width="3%">{{ $no++ }}</td>
          <td class="tg-rv4w" width="10%">{{ $item->nim }}</td>
          <td class="tg-rv4w" width="20%">{{ $item->nama }}</td>
          <td class="tg-rv4w" width="10%">{{ $item->gender }}</td>
          <td class="tg-rv4w" width="15%">{{ $item->ttl }}</td>
          <td class="tg-rv4w" width="12%">{{ $item->jurusan }}/{{ $item->tahun_masuk }}</td>
          <td class="tg-rv4w" width="8%">{{ $item->semester }}</td>
          <td class="tg-rv4w" width="25%">{{ $item->alamat }}</td>
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