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
        <button type="button" id="close" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
          <li>Nilai akhir = 20% tugas + 30% UTS + 50% UAS</li>
          <li>Nilai akhir akan muncul otomatis setelah field nilai absensi, tugas, UTS & UAS terisi semua-nya</li>
          <li>tekan <strong>enter</strong> untuk berpindah ke kolom berikutnya</li>
          <li>Silahkan click button <strong>submit</strong> untuk entry semua nilai</li>
        </ul>
      </div>

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">input nilai matkul <strong>{{ Session::get('mata_kuliah') }}</strong> semester <strong>{{ Session::get('semester') }}</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tr>
              <th style="width: 3%">#</th>
              <th style="width: 10%">Nim</th>
              <th style="width: 42%">Nama</th>
              <th style="width: 10%">Tugas</th>
              <th style="width: 10%">Uts</th>
              <th style="width: 10%">Uas</th>
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
                <input type="number" min="0" max="100" name="{{ $item->nim }}[tugas]" class="form-control input-sm input tugas" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="number" min="0" max="100" name="{{ $item->nim }}[uts]" class="form-control input-sm input uts" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="number" min="0" max="100" name="{{ $item->nim }}[uas]" class="form-control input-sm input uas" placeholder=".col-xs-3" required>
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
