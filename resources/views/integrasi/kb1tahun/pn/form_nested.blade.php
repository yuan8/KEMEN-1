<form action="{{route('int.kb1tahun.nested_store',['id'=>$id,'jenis'=>((int)$jenis_kode+1)])}}" method="post">
	@csrf

	<div class="form-group">
		<label>URAIAN {{$jenis}} {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required=""></textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">TAMBAH</button>
</form>
