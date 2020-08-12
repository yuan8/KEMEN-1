@extends('bot.simspam.template')

@section('content')

<script type="text/javascript">
	
		setTimeout(function(){

			var rekap=$('#Rekap table')[0].outerHTML;

			download(rekap,'PERPIPAAN REKAP PERPROVINSI');

			var rekap2=$('#DataUmum table')[0].outerHTML;

			download(rekap2,'PERPIPAAN REKAP PERPROVINSI DATA UMUM');

			var rekap3=$('#DataPelayanan table')[0].outerHTML;

			download(rekap3,'PERPIPAAN REKAP PERPROVINSI DATA PELAYANAN');

			var rekap3=$('#DataTeknis table')[0].outerHTML;

			download(rekap3,'PERPIPAAN REKAP PERPROVINSI  DATA TEKNIS');

			var rekap3=$('#DataKeuangan table')[0].outerHTML;

			download(rekap3,'PERPIPAAN REKAP PERPROVINSI  DATA KEUANGAN');

			var rekap3=$('#TargetPelayanan table')[0].outerHTML;

			download(rekap3,'PERPIPAAN REKAP PERPROVINSI  DATA TARGET PELAYANAN');


			var rekap3=$('#RencanaPengembangan table')[0].outerHTML;

			download(rekap3,'PERPIPAAN REKAP PERPROVINSI  DATA TARGET RECANA PENGEMBANGAN');


			var rekap3=$('#AirBaku table')[0].outerHTML;

			download(rekap3,'PERPIPAAN REKAP PERPROVINSI  DATA TARGET RECANA AIR BAKU');

			$('.ui-dialog-titlebar-close').click();
		},1000);


</script>

@stop