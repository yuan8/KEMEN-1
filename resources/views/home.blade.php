@extends('adminlte::page')


@section('content_header')
    <h1 class="text-center"><b>APLIKASI SINGKRONISASI</b></h1>
@stop

@section('content')
    <div class="col-md-4 col-md-offset-4 text-center animated bounceInUp">
    	<img src="{{url('logo.png')}}" class="" style="max-width: 40%">
    	<h2><b>BANGDA KEMENDAGRI</b></h2>
    	<h2><b>SUPD II</b></h2>
    	<hr>
    	<p><b>{{strtoupper(Auth::User()->name)}} - {{Hp::fokus_tahun()}}</b></p>
    	<small><i>{{Hp::fokus_urusan()['nama']}}</i></small>
    </div>


    <style type="text/css">
    	.content{
    		 background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(253,187,45,1) 100%) !important;
    	}
    </style>
@stop