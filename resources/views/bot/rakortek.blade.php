mencoba mengambil data {{$daerah->nama}}

<script type="text/javascript">
	setTimeout(function(){
		window.location.href='{{route('bot.rakortek',['tahun'=>2021,'kodepemda'=>$daerah->id,'langsung'=>'aja'])}}';
	},2000);

</script>