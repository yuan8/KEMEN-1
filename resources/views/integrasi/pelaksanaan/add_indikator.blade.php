<form action="" method="post">
	@csrf
	<div class="form-group">
		<label>KEWENANGAN PUSAT</label>
		<textarea class="form-control" name="kw_nas"></textarea>
	</div>
	<div class="form-group">
		<label>KEWENANGAN PROVINSI</label>
		<textarea class="form-control" name="kw_p"></textarea>
	</div>
	<div class="form-group">
		<label>KEWENANGAN KOTA/KAB</label>
		<textarea class="form-control" name="kw_k"></textarea>
	</div>
	<div class="col-md-12">
		<button type="submit" class="btn btn-xs bt-success">TAMBAH KEWENAGAN</button>
	</div>
</form>