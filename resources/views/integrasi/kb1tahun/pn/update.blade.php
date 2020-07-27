<form action="{{route('int.kb1tahun.pn_update',['id'=>$data->id])}}" method="post">
	@csrf
	@method('PUT')

	
	<div class="form-group">
		<label>URAIAN PN {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required="">{!!$data->uraian!!}</textarea>
	</div>
		<hr>
	<button class="btn btn-warning btn-xs">UPDATE</button>
</form>
