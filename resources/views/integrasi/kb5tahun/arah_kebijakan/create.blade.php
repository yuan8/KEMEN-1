<form action="{{route('int.kb5tahun.ak.store',['id'=>$isu['id']])}}" method="post">
	@csrf

	<small>
		<b>ISU STATEGIS : </b>
		<br>
		{!!$isu['uraian']!!}
	</small>
	<hr>
	<div class="form-group">
		<label>URAIAN ARAH KEBIJAKAN {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required=""></textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">TAMBAH</button>
</form>
