@extends('layout')

@section('head')
  <style>
    .num-ip {
      text-align: center;
    }
  .bg-purple {
    margin-right: 10px;
  }
  </style>
@endsection

@section('heading')
  Hitung IPK Mahasiswa
@endsection

@section('content')
  <form action="{{ URL('action-ipk') }}" method="POST">
  {{csrf_field()}}
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">IPK mahasiswa semester <strong>{{ $semester }}</strong></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table table-condensed table-bordered">
        <thead>
          <tr>
            <th style="width: 3%; padding-bottom: 25px" rowspan="2">#</th>
            <th style="width: 10%; padding-bottom: 25px" rowspan="2">NIM</th>
            <th style="width: 30%; padding-bottom: 25px" rowspan="2">Nama Lengkap Mahasiswa</th>
            <th style="width: 36%; text-align: center" colspan={{ $col }}>IPS</th>
            <th style="width: 12%; padding-bottom: 25px; text-align: center" rowspan="2">Total</th>
            <th style="width: 12%; padding-bottom: 25px; text-align: center" rowspan="2">IPK</th>
          </tr>
          <tr>
          @switch($col)
            @case(1)
              <th style="text-align: center">I</th>
            @break

            @case(2)
              <th style="text-align: center">I</th>
              <th style="text-align: center">II</th>                  
            @break

            @case(3)
              <th style="text-align: center">I</th>
              <th style="text-align: center">II</th>
              <th style="text-align: center">AI</th>
            @break

            @case(4)
              <th style="text-align: center">I</th>
              <th style="text-align: center">II</th>
              <th style="text-align: center">AI</th>
              <th style="text-align: center">III</th>
            @break

            @case(5)
              <th style="text-align: center">I</th>
              <th style="text-align: center">II</th>
              <th style="text-align: center">AI</th>
              <th style="text-align: center">III</th>
              <th style="text-align: center">IV</th>
            @break

            @case(6)
              <th style="text-align: center">I</th>
              <th style="text-align: center">II</th>
              <th style="text-align: center">AI</th>
              <th style="text-align: center">III</th>
              <th style="text-align: center">IV</th>
              <th style="text-align: center">A2</th>
                  
              @endswitch
          </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @foreach($list as $key => $item)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $key }}</td>
            <td>{{ $item['nama'] }}</td>
            @foreach($item['ip'] as $ips)
              <td class="num-ip">{{ $ips }}</td>
            @endforeach
            <td class="num-ip">{{ $item['total'] }}</td>
            @php $ipk = round($item['total'] / $col, 2); @endphp
            <td class="num-ip">{{ $ipk }}</td>
            <input type="hidden" name={{ $key }} value={{ $ipk }} />
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <button type="submit" class="btn btn-sm btn-success pull-right" name="action" value="entry">Entry IPK</button>
  <button type="submit" class="btn btn-sm bg-purple pull-right" name="action" value="edit">Edit IPK</button>
  </form>
@endsection
