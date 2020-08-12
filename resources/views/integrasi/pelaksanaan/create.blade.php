<form action="{{route('int.pelurusan.store_kewenangan')}}" method="post">
	@csrf
	<div class="form-group">
		<label>SUB URUSAN</label>
		<select class="form-control init-use-select2" required="" name="id_sub_urusan">
			@foreach($sub_urusan as $sub)
				<option value="{{$sub->id}}">{{$sub->nama}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>KEWENANGAN PUSAT</label>
		<textarea name="kw_nas" class="form-control"></textarea>
	</div>
	<div class="form-group">
		<label>KEWENANGAN PROVINSI</label>
		<textarea name="kw_p" class="form-control"></textarea>
	</div>
	<div class="form-group">
		<label>KEWENANGAN KOTA/KAB</label>
		<textarea name="kw_k" class="form-control"></textarea>
	</div>
	<hr>
	<button class="btn btn-xs btn-success">TAMBAH KEWENANGAN</button>
</form>