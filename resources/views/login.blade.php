<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="_token" content="{!! csrf_token() !!}">

  <!-- Styles -->
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
  <div class="progress" id="loading">
    <div class="progress-bar" style="width:5%"></div>
  </div>

  <div class="container">
    <marquee style="color: #fff">
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selamat datang di aplikasi SINA</p>
      <p style="margin-top:-10px"><span>S</span>istem <span>I</span>nformasi pe<span>N</span>ilaian <span>A</span>kademik</p>
    </marquee>
    <div class="row">
      <div class="col-md-6 col-md-offset-4 col-sm-4 col-sm-offset-3 col-xs-8 col-xs-offset-2" id="form">
        <form class="form-horizontal">
        {{ csrf_field() }}

          <div class="form-group">
            <div class="col-md-5">
              <input type="text" class="form-control password" name="username" placeholder="Username" required autofocus>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-5">
              <input type="password" class="form-control username" name="password" placeholder="Password" required>
              <a type="button" class="glyphicon glyphicon-eye-close"></a>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-3" id="select">
              <select class="form-control" disabled>
                <option disabled selected>- pilih matkul -</option>
              </select>                
            </div>
            <div class="col-md-2" id="submit">
              <button class="btn btn-primary btn-block btn-submit" type="submit">Login</button>
            </div>
          </div>

        </form>
      </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <p style="font-size: 16px; text-align: center">Silahkan pilih mata kuliah terlebih dahulu...!</p>
          </div>
        </div>
      </div>
    </div>

  </div>

{{-- script jquery-ripples --}}
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/custom/login.js') }}"></script>
<script src="{{ asset('js/jquery.ripples.js') }}"></script>
</body>
</html>