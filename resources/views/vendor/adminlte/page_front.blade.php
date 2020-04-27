@extends('adminlte::master_front')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('ltefron.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('ltefron.skin', 'blue') . ' sidebar-mini ' . (config('ltefron.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('ltefron.layout')] : '') . (config('ltefron.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <style type="text/css">
        .skin-yellow .main-header .navbar .nav>li>a,.text-dark{
            color:#222!important;
        }
    </style>
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('ltefron.layout') == 'top-nav')
            <nav class="navbar navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('ltefron.dashboard_url', 'home')) }}" class="navbar-brand text-dark">
                            {!! config('ltefron.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav text-dark">
                            @include('adminlte::partials.nav')
                        </ul>
                       
                    </div>
                    <div class="navbar-custom-menu">
                         <ul class="nav navbar-nav"> 
                         @if(isset($name_right_side_bar))                      
                            <li>
                                <a href="#" data-toggle="control-sidebar">
                                    <i class="fas fa-check-square"></i>  {{$name_right_side_bar}}
                                </a>
                            </li>
                            @endif
                            <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <img src="{{asset('ava.png')}}" class="user-image" alt="User Image">
                              <span class="hidden-xs"> {{strtoupper(Auth::User()->name)}} ({{Hp::fokus_tahun()}})</span>
                            </a>
                            <ul class="dropdown-menu">
                              <!-- User image -->
                              <li class="user-header">
                                <img src="{{asset('ava.png')}}" class="img-circle" alt="User Image">

                                <p>
                                  {{strtoupper(Auth::User()->name)}}
                                  <small>{{Auth::User()->email}} </small>
                                  <b>{{Hp::fokus_tahun()}}</b>
                                </p>
                              </li>
                              <!-- Menu Body -->
                              <li class="user-body">
                              <!--   <div class="row">
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                  </div>
                                </div> -->
                                <!-- /.row -->
                              </li>
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                <div class="pull-left">
                                  <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                                </div>
                                <div class="pull-right">
                                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                              </li>
                            </ul>
                          </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('ltefron.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('ltefron.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('ltefron.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
              

            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">

                        
                       
                    </ul>
                </div>
                @if(config('ltefron.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('ltefron.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">

                  @foreach($adminlte->menu() as $key=>$item)
                    @include('adminlte::partials.menu-item',['item'=>$item,'key'=>$key])
                  @endforeach
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
              <section class="content-header">
                 <div class="row">
                 </div>
                  @yield('content_header')
                 
                
            </section>

            @if(config('ltefron.layout') == 'top-nav')
            <div class="container-fluid">
            @endif

            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content" style="min-height: 100vh">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('ltefron.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        @hasSection('footer')
        <footer class="main-footer">
            @yield('footer')
        </footer>
        @endif

            <aside class="control-sidebar control-sidebar-{{config('ltefron.right_sidebar_theme')}}" style="position: fixed;">
                @yield('right-sidebar')
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{url('vendor/highchart/highcharts.src.js')}}"></script> -->
    <script src="http://github.highcharts.com/highstock.src.js"></script>
    <script src="http://code.highcharts.com/maps/modules/map.js"></script>

    @stack('js')
    @yield('js')

    <div class="modal fade  " id="modal-info">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg bg-info with-border">
                    <H5 class="text-center"><b class="title"></b></H5>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

@stop
