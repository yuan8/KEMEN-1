
<form action="{{route('int.pelurusan.update',['id'=>$data['id']])}}" method="post">

	@method('PUT')
	@csrf
	<div class="form-group">
		<label>SUB URUSAN</label>
		<select class="form-control init-use-select2" required="" name="id_sub_urusan">
			@foreach($sub_urusan as $sub)
				<option value="{{$sub->id}}" {{$data['id_sub_urusan']==$sub->id?'selected':''}}}>{{$sub->nama}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>KEWENANGAN PUSAT</label>
		<textarea name="kw_nas" class="form-control">{!!($data['kewenangan_nas'])!!}</textarea>
	</div>
	<div class="form-group">
		<label>KEWENANGAN PROVINSI</label>
		<textarea name="kw_p" class="form-control">{!!($data['kewenangan_p'])!!}</textarea>
	</div>
	<div class="form-group">
		<label>KEWENANGAN KOTA/KAB</label>
		<textarea name="kw_k" class="form-control">{!!($data['kewenangan_k'])!!}</textarea>
	</div>
	<hr>
	<button class="btn btn-xs btn-warning" type="submit">UPDATE KEWENANGAN</button>
</form>