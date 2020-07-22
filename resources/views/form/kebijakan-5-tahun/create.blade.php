@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">TAMBAH KONDISI SAAT INI ({{$rpjmn['start']}} -  {{$rpjmn['finish']}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<form action="{{route('kebijakan.pusat.5.tahun.store')}}" method="post">
	@csrf
	<div class="box box-solid">
		<div class="box-body ">
			<div class="form-group">
				<label>KONDISI SAAT INI</label>
				<textarea class="form-control" name="uraian" style="min-height: 100px;" required=""></textarea>
			</div>
			

		</div>
		<div class="box-footer">
			<button class="btn btn-success btn-xs">TAMBAH</button>
		</div>
	</div>

</form>

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