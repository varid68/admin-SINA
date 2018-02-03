@extends('layout')
@section('head')
  <link rel="stylesheet" href="{{ asset('css/nilai.css') }}">
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
          <li>Nilai absensi didaptakan dari ((Masuk / 14) x 10 / 100) x 100</li>
          <li>NIlai absensi max adalah 14 yang mana didapatkan dari jumlah pertemuan 1 semester</li>
          <li>Nilai akhir = 10% absensi + 20% tugas + 30% UTS + 40% UAS</li>
          <li>Nilai akhir otomatis muncul setelah kolom nilai terisi semua-nya</li>
        </ul>
      </div>

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Table nilai mahasiswa semester {{ Session::get('semester') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table">
            <tr>
              <th style="width: 5%">No.</th>
              <th style="width: 15%">Nim</th>
              <th style="width: 25%">Nama</th>
              <th style="width: 11.25%">Absensi</th>
              <th style="width: 11.25%">Tugas</th>
              <th style="width: 11.25%">Uts</th>
              <th style="width: 11.25%">Uas</th>
              <th style="width: 10%">Nilai akhir</th>
            </tr>
            <form method="POST" action="{{ url('/nilai') }}">
            {{ csrf_field() }}
            @php $no = 10 * $page - (10 - 1) @endphp
            @foreach((array) $list as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item->nim }}</td>
              <td>{{ $item->nama }}</td>
              <td>
                <input type="text" name="{{ $item->nim }}[absensi]" class="form-control input-sm input absensi" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="text" name="{{ $item->nim }}[tugas]" class="form-control input-sm input tugas" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="text" name="{{ $item->nim }}[uts]" class="form-control input-sm input uts" placeholder=".col-xs-3" required>
              </td>
              <td>
                <input type="text" name="{{ $item->nim }}[uas]" class="form-control input-sm input uas" placeholder=".col-xs-3" required>
                <input type="hidden" name="{{ $item->nim }}[nilai_akhir]" class="nilai-akhir">
              </td>
              <td class="grade">-----</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div><!-- END TABLE CONTAINER -->

      @if ($page > 1)
        @php $prev = $page - 1;
        $style = 'unset'; @endphp
      @else
        @php $prev = 1;
        $style = 'none' @endphp
      @endif

      @if ($page == $total)
        @php $next = $page;
        $style2 = 'none'; @endphp
      @else
        @php $next = $page + 1;
        $style2 = 'unset'; @endphp
      @endif
      <ul class="pagination pagination-sm no-margin">
        <li><a href="{{ url('nilai/'.$prev) }}" style="pointer-events:{{ $style }}">&laquo;</a></li>
        @for($i=1;$i<=$total;$i++)
        <li><a href="{{ url('nilai/'.$i) }}">{{ $i }}</a></li>
        @endfor
        <li><a href="{{ url('nilai/'.$next) }}" style="pointer-events:{{ $style2 }}">&raquo;</a></li>
      </ul><!-- END PAGINATION -->

      <button type="submit" id="submit" class="btn btn-success btn-sm pull-right">Submit</button>
      </form><!-- END FORM INPUT NILAI -->

    </div><!-- END COL-MD-12 -->
  </div><!-- END ROW  -->
@endsection

@section('script')
  <script src="{{ asset('js/custom/nilai.js') }}"></script>
@endsection
