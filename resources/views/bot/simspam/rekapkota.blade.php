@extends('bot.simspam.template')

@section('content')

<H1 >{{$provinsi->nama}}</H1>

<script type="text/javascript">
	var ids=<?php echo json_encode($ids); ?>;

	var data=$('#Rekap table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA');

	var data=$('#DataUmum table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA UMUM');

	var data=$('#DataPelayanan table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA PELAYANAN');

	var data=$('#DataTeknis table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA TEKNIS');

	var data=$('#DataKeuangan table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA KEUANGAN');

	var data=$('#TargetPelayanan table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA TARGET PELAYANAN');

	var data=$('#RencanaPengembangan table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA RENCANA PENGEMBANGAN');


	var data=$('#RiwayatSR table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA RENCANA RIWAYAR SR');


	var data=$('#AirBaku table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA RENCANA AIR BAKU');


	var data=$('#SpamJaringan table')[0].outerHTML;
	download(data,'PERPIPAAN {{$provinsi->nama}} REKAP KOTA DATA RENCANA AIR SPAM JARINGAN');


</script>

<div id="content_api">
	

</div>

<script type="text/javascript">
	function build_this(i){
		if(ids[i]!=undefined){

			$.post(ids[i].link_detail,{data:ids[i]},function(res){
				$('#content_api').html(res);

				setTimeout(function(){
						if(ids[i+1]!=undefined){
							build_this(i+1);
						}

				},7000);
			});

		}

	
	}


	setTimeout(function(){
		build_this(0);
	},3000);



</script>

@stop