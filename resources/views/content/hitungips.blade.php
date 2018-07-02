@extends('layout')
@section('head')
  <meta name="_token" content="{!! csrf_token() !!}">
  <style>
    .bg-purple { margin-right: 10px }
  </style>
@endsection

@section('heading')
  Hitung IPS mahasiswa
@endsection

@section('content')
  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <table class="table table-condensed table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%">#</th>
                <th style="width: 60%">Mata kuliah</th>
                <th style="width: 10%">Sks</th>
                <th style="width: 10%">Skala</th>
                <th style="width: 10%">Bobot</th>
                <th style="width: 10%">Mutu</th>
              </tr>
            </thead>
            <tbody id="tes">
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <form action="{{ URL('action-ips') }}" method="POST">
  {{csrf_field()}}
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Indeks Prestasi mahasiswa semester <strong>{{ $semester }}</strong></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table table-condensed">
        <tr>
          <th style="width: 3%">#</th>
          <th style="width: 12%">NIM</th>
          <th style="width: 35%">Nama</th>
          <th style="width: 10%; text-align: center">Total SKS</th>
          <th style="width: 10%; text-align: center">Total Mutu</th>
          <th style="width: 12%; text-align: center; font-size: 12px">Indeks prestasi</th>          
          <th style="width: 8%">Option</th>
        </tr>
        @php $no = 1 @endphp
        @foreach((array) $list as $key => $item)
        <tr>
          <td>{{ $no++ }}</td>
          <td>{{ $key }}</td>
          <td>{{ $item['nama'] }}</td>
          <td class="text-center">{{ $item['total_sks'] }}</td>
          <td class="text-center">{{ $item['total_mutu'] }}</td>
          @php $ip = round($item['total_mutu'] / $item['total_sks'], 2); @endphp
          <td class="text-center">{{ round($item['total_mutu'] / $item['total_sks'], 2) }}</td>
          <input type="hidden" name={{ $key }} value="{{ $ip }}" />
          <td>
            <button type="button" class="btn btn-sm bg-maroon preview" data-nim={{ $key }}>Preview</button>
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  @if ($validasi != 'sudah')
  <button type="submit" class="btn btn-sm btn-success pull-right" name="action" value="entry">Entry IP</button>
  @else
  <button type="button" class="btn btn-sm btn-success pull-right" disabled>Entry IP</button>
  @endif
  <button type="submit" class="btn btn-sm bg-purple pull-right" name="action" value="edit">Edit IP</button>
  </form>
@endsection

@section('script')
  <script>
    $('.preview').click(function() {
      const nim = $(this).data('nim');
      $.ajax({
        type: "GET",
        url: '/ajax/'+nim,
        success: function(data) {
          var tbody = '';
          var x = '';
          var index = 1;
          var ip = (data.total_mutu / data.total_sks).toFixed(2);
          $.each(data.data, function(i, item ) {
            var index = 1 + i;
            var bobot = item.bobot_nilai .toString();
            let hasil = 0;
            if (bobot.length == 1) hasil = bobot + '.00';
            if (bobot.length == 3) hasil = bobot + '0';
            if (bobot.length == 4) hasil = item.bobot_nilai;
            tbody +=  `<tr>
              <td>${index}</td>
              <td>${item.matkul}</td>
              <td class="text-center">${item.sks}</td>
              <td class="text-center">${item.skala_nilai}</td>
              <td class="text-center">${hasil}</td>
              <td class="text-center">${item.mutu}</td>
            </tr>`;
          });
          $('#tes').html(tbody);
          var x = `<tr>
            <td></td>
            <td class="text-center">Total</td>
            <td class="text-center">${data.total_sks}</td>
            <td></td>
            <td></td>
            <td class="text-center">${data.total_mutu}</td>
          </tr>`;
          
          var y = `<tr>
            <td></td>
            <td class="text-center">Indeks Prestasi</td>
            <td class="text-center">${ip}</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>`;
          $('#tes').append(x);
          $('#tes').append(y);
          $('#myModal').modal('show');
        }
      });
    });
  </script>
@endsection