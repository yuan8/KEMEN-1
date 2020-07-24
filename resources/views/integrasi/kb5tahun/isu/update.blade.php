<form action="{{route('int.kb5tahun.isu.update',['id'=>$isu['id']])}}" method="post">
	@csrf
	@method('put')
	<small>
		<b>KONDISI : </b>
		<br>
		{!!$isu['uraian_kondisi']!!}
	</small>
	<hr>
	<div class="form-group">
		<label>URAIAN ISU STRATEGIS {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required="">{!!$isu['uraian']!!}</textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">UPDATE</button>
</form>
