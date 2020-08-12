<form action="{{route('int.kb5tahun.isu.store',['id'=>$kondisi['id']])}}" method="post">
	@csrf

	<small>
		<b>KONDISI : </b>
		<br>
		{!!$kondisi['uraian']!!}
	</small>
	<hr>
	<div class="form-group">
		<label>URAIAN ISU STRATEGIS {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required=""></textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">TAMBAH</button>
</form>
