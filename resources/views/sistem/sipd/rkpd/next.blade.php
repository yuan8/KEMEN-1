@extends('adminlte::page_front')



@section('content')
	<h5 class="text-center">NEXT : <b>{{$daerah->nama}}</b></h5>



<script type="text/javascript">
	
	setTimeout(function(){
		window.location.href='{{route('bot.sipd.rkpd.store',['tahun'=>$tahun,'kodepemda'=>$daerah->id,'json'=>true])}}';
	

	},1000);
</script>

@stop