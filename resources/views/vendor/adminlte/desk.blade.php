@extends('adminlte::desk_master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('desk.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('desk.skin', 'blue') . ' sidebar-mini ' . (config('desk.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('desk.layout')] : '') . (config('desk.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')

    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('desk.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('desk.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('desk.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @include('adminlte::partials.nav')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('desk.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('desk.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('desk.logo', '<b>Admin</b>LTE') !!}</span>
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

                 @if(Auth::User())
                       <ul class="nav navbar-nav">
                         <li>
                            <a href="javascript:void(0)" onclick="$('#modal-pindah-tahun-fokus').modal()"><i class="fas fa-history"></i> Tahun</a>
                        </li>
                         @if(config('desk.right_sidebar') and (config('desk.layout') != 'top-nav'))
                        <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar" @if(!config('desk.right_sidebar_slide')) data-controlsidebar-slide="false" @endif>
                                    <i class="{{config('desk.right_sidebar_icon')}}"></i> Urusan
                                </a>
                            </li>
                        @endif
                        
                        <li>
                            @if(config('desk.logout_method') == 'GET' || !config('desk.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('desk.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ strtoupper(Auth::User()->name) }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ strtoupper(Auth::User()->name) }}
                                </a>
                                <form id="logout-form" action="{{ url(config('desk.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('desk.logout_method'))
                                        {{ method_field(config('desk.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                       
                    </ul>
                 @endif
                </div>
                @if(config('desk.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('desk.layout') != 'top-nav')
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
            @if(config('desk.layout') == 'top-nav')
            <div class="">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                 
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content-fluid" style="min-height: 100vh">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('desk.layout') == 'top-nav')
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

        @if(config('desk.right_sidebar') and (config('desk.layout') != 'top-nav'))
            <aside class="control-sidebar control-sidebar-{{config('desk.right_sidebar_theme')}}">
                @yield('right-sidebar')
                @include('partials.right_side_bar')
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        @endif

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>


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

    <script type="text/javascript">
        $('.use-select-2-def').select2();
    </script>

@stop
