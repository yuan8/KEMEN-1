<form action="{{route('int.kb5tahun.ak.update',['id'=>$ak['id']])}}" method="post">
	@csrf
	@method('put')
	<small>
		<b>ISU STARTEGIS : </b>
		<br>
		{!!$ak['uraian_isu']!!}
	</small>
	<hr>
	<div class="form-group">
		<label>URAIAN ARAH KEBIJAKAN {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required="">{!!$ak['uraian']!!}</textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">UPDATE</button>
</form>
