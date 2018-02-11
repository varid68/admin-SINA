@extends('layout')
@section('head')
  <link rel="stylesheet" href="{{ asset('css/input-nilai.css') }}">
@endsection

@section('heading')
  Input nilai
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">

      <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
          <li>Nilai absensi diperoleh dari ((Masuk kuliah / 14) x 10 / 100) x 100</li>
          <li>NIlai absensi max adalah 14 yang mana diperoleh dari jumlah pertemuan selama 1 semester</li>
          <li>Nilai akhir = 10% absensi + 20% tugas + 30% UTS + 40% UAS</li>
          <li>Nilai akhir akan muncul otomatis setelah field nilai absensi, tugas, UTS & UAS terisi semua-nya</li>
        </ul>
      </div>

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Table nilai mahasiswa semester {{ Session::get('semester') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tr>
              <th style="width: 3%">#</th>
              <th style="width: 10%">Nim</th>
              <th style="width: 30%">Nama</th>
              <th style="width: 11.25%">Absensi</th>
              <th style="width: 11.25%">Tugas</th>
              <th style="width: 11.25%">Uts</th>
              <th style="width: 11.25%">Uas</th>
              <th style="width: 10%">Nilai akhir</th>
            </tr>
            <form method="POST" action="{{ url('/input-nilai') }}">
            {{ csrf_field() }}
            @php $no = 1 @endphp
            @foreach((array) $list as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item->nim }}</td>
              <td>{{ $item->nama }}</td>
              <td>
                <input type="number" min="1" max="14" name="{{ $item->nim }}[absensi]" class="form-control input-sm input absensi" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="number" min="1" max="100" name="{{ $item->nim }}[tugas]" class="form-control input-sm input tugas" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="number" min="1" max="100" name="{{ $item->nim }}[uts]" class="form-control input-sm input uts" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="number" min="1" max="100" name="{{ $item->nim }}[uas]" class="form-control input-sm input uas" placeholder=".col-xs-3" required>
                <input type="hidden" name="{{ $item->nim }}[nilai_akhir]" class="nilai-akhir">
              </td>
              <td class="grade">-----</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div><!-- END TABLE CONTAINER -->

      @if (count($list) > 1)
        <button type="submit" id="submit" class="btn btn-success btn-sm pull-right">Submit</button>
      @else
        <marquee>Semua nilai mahasiswa telah di input!!</marquee>
      @endif
      </form><!-- END FORM INPUT NILAI -->

    </div><!-- END COL-MD-12 -->
  </div><!-- END ROW  -->
@endsection

@section('script')
  <script src="{{ asset('js/custom/input-nilai.js') }}"></script>
@endsection
