<form action="{{route('int.kb5tahun.sasaran.update',['id'=>$sasaran['id']])}}" method="post">
	@csrf
	@method('put')
	<small>
		<b>ARAH KEBIJAKAN : </b>
		<br>
		{!!$sasaran['uraian_s']!!}
	</small>
	<hr>
	<div class="form-group">
		<label>URAIAN SASARAN {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required="">{!!$sasaran['uraian']!!}</textarea>
	</div>
		<hr>
	<button class="btn btn-success btn-xs">UPDATE</button>
</form>
