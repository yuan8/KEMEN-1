@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN 5 TAHUNAN ({{$rpjmn['start']}} -  {{$rpjmn['finish']}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<ul class="list-group">
	<li class="list-group-item ">
		<p data-toggle="collapse" href="#satu" aria-expanded="false" aria-controls="satu"><b>1</b></p>

<ul class="list-group collapse" id="satu">
	<li class="list-group-item collapse" >
	<p data-toggle="collapse" href="#dua" aria-expanded="false" aria-controls="dua"><b>1</b></p>
		<ul class="list-group collapse" id="dua" >
			<li class="list-group-item"></li>
		</ul>
	</li>
</ul>

	</li>
	<li class="list-group-item ">
		<p data-toggle="collapse" href="#satu" aria-expanded="false" aria-controls="satu"><b>1</b></p>

<ul class="list-group collapse" id="satu">
	<li class="list-group-item collapse" >
	<p data-toggle="collapse" href="#dua" aria-expanded="false" aria-controls="dua"><b>1</b></p>
		<ul class="list-group collapse" id="dua" >
			<li class="list-group-item"></li>
		</ul>
	</li>
</ul>
	</li>
</ul>
  <!-- /.box-body -->

	


@stop


@section('js')


<script type="text/javascript">
	var app=new Vue({
		el:'#data',
		data:{
			text:''
		}
	});

</script>
  

@stop