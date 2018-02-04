<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,300italic,400italic,600italic">
    <style>
      .progress {
        background-color: #00a65a;
        position:relative;
        top:0px;
        height:1.5px;
        margin-bottom:0px;
        display:none;
      }
      .progress-bar {
        background-color: red;
      }
    </style>
    @yield('head')
  </head>
  <body class="hold-transition skin-green sidebar-mini">

      <div class="progress">
        <div class="progress-bar" style="width:5%"></div>
      </div>
    <div class="wrapper">
    
    <header class="main-header">
      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('images/user2-160x160.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">Alexander Pierce</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('images/user2-160x160.png') }}" class="img-circle" alt="User Image">
                
                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('images/user2-160x160.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="{{ url('/home') }}">
          <i class="fa fa-home"></i>
          <span data-id="home">Home</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/news/1') }}">
          <i class="fa fa-bullhorn"></i>
          <span data-id="news">News</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/mahasiswa') }}">
          <i class="fa fa-user-circle-o"></i>
          <span data-id="mahasiswa">Mahasiswa</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/alumni') }}">
          <i class="fa fa-graduation-cap"></i>
          <span data-id="alumni">Alumni</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/nilai') }}">
          <i class="fa fa-trophy"></i>
          <span data-id="nilai">Nilai</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/input-nilai') }}">
          <i class="fa fa-pencil-square-o"></i>
          <span data-id="input-nilai">Input nilai</span>
        </a>
      </li>
      <li>
        <a href="{{ url('/remidial') }}">
          <i class="fa fa-refresh"></i>
          <span data-id="remidial">Remidial</span>
        </a>
      </li>
    </ul>
  </section>
    <!-- /.sidebar -->
  </aside>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('heading', 'Dashboard')
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">@yield('heading', 'Dashboard')</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->
<!-- <script src="bower_components/jquery/dist/jquery.min.js"></script> -->
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- Script tambah class active -->
<script>
  (function addClassActive(){
    let split = location.href.split('/');
    // let page = location.href.substr(location.href.lastIndexOf("/") + 1);
    $('ul.sidebar-menu').find('li a span').each(function() {
      let parents = $(this).parents('li');
      $(this).data('id') == split[3] ? parents.addClass('active') : parents.removeClass('active');
    });
  }());
</script>

@yield('script')
</body>
</html>
