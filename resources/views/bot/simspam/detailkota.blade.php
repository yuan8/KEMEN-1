
<div id="cc">{!!$content!!}</div>
<script type="text/javascript">
	var data=$('#cc #Rekap table')[0].outerHTML;
	download(data,'{{$nama}} , REKAP');

	var data=$('#cc #DataUmum table')[0].outerHTML;
	download(data,'{{$nama}} , DATA UMUM');

	var data=$('#cc #DataPelayanan table')[0].outerHTML;
	download(data,'{{$nama}} , DATA  PELAYANAN');

	var data=$('#cc #DataTeknis table')[0].outerHTML;
	download(data,'{{$nama}} , DATA  TEKNIS');

	var data=$('#cc #DataKeuangan table')[0].outerHTML;
	download(data,'{{$nama}} , DATA  KEUANGAN');

	var data=$('#cc #TargetPelayanan table')[0].outerHTML;
	download(data,'{{$nama}} , DATA  TARGET PELAYANAN');

	var data=$('#cc #RencanaPengembangan table')[0].outerHTML;
	download(data,'{{$nama}} , DATA  RENCANA PENGEMBANGAN');

</script>