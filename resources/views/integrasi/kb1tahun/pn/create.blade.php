<form action="{{route('int.kb1tahun.pn_store')}}" method="post">
	@csrf

	
	<div class="form-group">
		<label>URAIAN PN {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required=""></textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">TAMBAH</button>
</form>
