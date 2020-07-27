@extends('adminlte::page_front')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PROGRAM KEGIATAN PER URUSAN</h3>
    	</div>
    </div>
   
    <?php
?>
@stop

@section('content')
	<div id="chart_container_next">
		<h5 class="text-center"><b>Loading...</b></h5>
	</div>


@stop



@section('js')

<script type="text/javascript">
	$.get('program-kegiatan/urusan',function(res){
		$('#chart_container_next').html(res);
	});

</script>
@stop