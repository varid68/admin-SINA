@extends('layout')
@section('head')
  <meta name="_token" content="{!! csrf_token() !!}">
  <style>
    .input-sm {
      border-radius: 3px;
    }
  </style>
@endsection

@section('heading')
  Hitung Indeks Prestasi Kumulatif
@endsection

@section('content')
  @php $col = 1; @endphp
  @foreach((array) $list as $key => $value)
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Indeks Prestasi Siswa Semester <strong>{{ $key }}</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-condensed table-stripped">
            <thead>
              <tr>
                <th style="width: 3%; padding-bottom: 25px" rowspan="2">#</th>
                <th style="width: 10%; padding-bottom: 25px" rowspan="2">NIM</th>
                <th style="width: 37%; padding-bottom: 25px" rowspan="2">Nama</th>
                <th style="width: 35%; text-align: center" colspan={{ $col }}>IPS</th>
                <th style="width: 15%; padding-bottom: 25px; text-align: center" rowspan="2">IPK</th>
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
              @foreach((array) $value as $item)
              <tr>
                <td>1</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->nama }}</td>
                @switch($col)
                  @case(1)
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-satu" required />
                    </td>
                  @break

                  @case(2)
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-dua" required />                      
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-dua2" required />                      
                    </td>
                  @break

                  @case(3)
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-tiga" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-tiga" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-tiga" required />
                    </td>
                  @break

                  @case(4)
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-empat" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-empat" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-empat" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-empat" required />
                    </td>
                  @break

                  @case(5)
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-lima" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-lima" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-lima" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-lima" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-lima" required />
                    </td>
                  @break

                  @case(6)
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-enam" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-enam" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-enam" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-enam" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-enam" required />
                    </td>
                    <td style="text-align: center">
                      <input type="number" min="1.00" max="4.00" class="form-control input-sm input-enam" required />
                    </td>  
                @endswitch
                <td style="text-align: center" class="ipk">---</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
  @php $col++; @endphp
  @endforeach
@endsection

@section('script')
  <script>
    $('.input-satu').keyup(function() {
      const ipk = Number($(this).val()).toFixed(2);
      $(this).parent().next().text(ipk);
    });


    $('.input-dua, .input-dua2').keyup(function() {
      const ips1 = Number($(this).val());
      const classname = $(this).attr('class').split(' ').pop();
      if (classname == 'input-dua') {
        $ips2 = $(this).parents('tr').find('.input-dua2').val();
        if ($ips2 == '') $ips2 = 0;
        else $ips2 = Number($ips2);
      } else {
        $ips2 = $(this).parents('tr').find('.input-dua').val();        
        if ($ips2 == '') $ips2 = 0;
        else $ips2 = Number($ips2);
      }

      const ipk = ((ips1 + $ips2) / 2).toFixed(2);
      $(this).parents('tr').find('.ipk').text(ipk);
    });
  </script>
@endsection