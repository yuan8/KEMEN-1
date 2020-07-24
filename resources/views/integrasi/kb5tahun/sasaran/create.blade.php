<form action="{{route('int.kb5tahun.sasaran.store',['id'=>$kebijakan['id']])}}" method="post">
	@csrf

	<small>
		<b>KONDISI : </b>
		<br>
		{!!$kebijakan['uraian']!!}
	</small>
	<hr>
	<div class="form-group">
		<label>URAIAN SASARAN {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required=""></textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">TAMBAH</button>
</form>
