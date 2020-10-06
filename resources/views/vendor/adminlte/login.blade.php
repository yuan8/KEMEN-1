@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/custome/cs.css') }}">

    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="row no-gutters">
        <div class="login-logo" style="background: #222; padding-top:10px; color: #fff">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" style="color:#fff">
               <img src="{{url('logo.png')}}" style="max-width:30px;"><b> APLIKASI SINKRONISASI</b></a>
               <h5><small style="font-size: 20px; line-height: 1px; color: #fff">PUSAT DAN DAERAH</small></h5>
            <hr>
        </div>
        <!-- /.login-logo -->
        @if(!Auth::check())

           <div class="col-md-12" >
               <div class="">

                    @include('adminlte::partials.login_form')
               </div>
           </div>
           <div class=" " style="width:100vw; margin-left:15px; background: #fff; margin-top: 10px; position: absolute; bottom:0px;">
             <div class="col-md-12" >
                <h5 class="text-center"><b>&copy; BANGDA KEMENDARI - {{date('Y')}}</b></h5>
             </div>
           </div>
        @endif

        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
