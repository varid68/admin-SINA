@extends('layout')
@section('head')
  <meta name="_token" content="{!! csrf_token() !!}">
  <style>
  .col-md-6, .col-md-12 {
    padding-left: 5px!important;
    padding-right: 5px!important;
  }
  .red {
    color: #ff0500;
  }
  .green {
    color: #2df12d;
  }
  </style>
@endsection

@section('heading')
  Validasi Hitung IPS
@endsection

@section('content')
  <div class="row">

    <div class="col-md-6">
    <h4 class="text-center">Manajemen Informatika</h4>
    @foreach((array) $mi as $key => $item)
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Semester<strong> {{$key}}</strong></h3>
          @php $y = 0; @endphp
          @foreach((array) $item as $item3)
            @if ($item3['sudah_input'] == 0)
              @php $y++; @endphp
            @endif
          @endforeach
          @if ($y > 0)
            <button type="button" class="btn btn-sm btn-info pull-right disabled">Hitung IPS</button>
          @else
          <a href="/hitungip/{{$key}}/Manajemen Informatika">
            <button type="button" class="btn btn-sm btn-info pull-right">Hitung IPS</button>
          </a>
          @endif
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tr>
              <th style="width: 40%">Matkul</th>
              <th style="width: 35%">Dosen</th>
              <th style="width: 20%; font-size: 12px">Sudah Input?</th>
            </tr>
            <tr>
            @foreach((array) $item as $item2)
              <td>{{ $item2['matkul'] }}</td>
              <td>{{ $item2['nama'] }}</td>
              <td class="text-center">
                @if ($item2['sudah_input'] == 0)
                <i class="fa fa-close red"></i>
                @else
                <i class="fa fa-check green"></i>
                @endif
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
    @endforeach
    </div>

    <div class="col-md-6">
    <h4 class="text-center">Komputerisasi Akuntansi</h4>
    @foreach((array) $ka as $key => $item)    
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Semester <strong>{{$key}}</strong></h3>
          @php $y = 0; @endphp
          @foreach((array) $item as $item3)
            @if ($item3['sudah_input'] == 0)
              @php $y++; @endphp
            @endif
          @endforeach
          @if ($y > 0)
            <button type="button" class="btn btn-sm btn-info pull-right disabled">Hitung IPS</button>
          @else
          <a href="/hitungip/{{$key}}/Komputerisasi Akuntansi">
            <button type="button" class="btn btn-sm btn-info pull-right">Hitung IPS</button>
          </a>
          @endif
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed">
            <tr>
              <th style="width: 40%">Matkul</th>
              <th style="width: 35%">Dosen</th>
              <th style="width: 20%; font-size: 12px">Sudah Input?</th>
            </tr>
            @foreach((array) $item as $item2)
            <tr>
              <td>{{ $item2['matkul'] }}</td>
              <td>{{ $item2['nama'] }}</td>
              <td class="text-center">
                @if ($item2['sudah_input'] == 0)
                <i class="fa fa-close red"></i>
                @else
                <i class="fa fa-check green"></i>
                @endif
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
    @endforeach
    </div>

  </div>
@endsection

@section('script')
@endsection
