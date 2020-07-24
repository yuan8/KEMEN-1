<form action="{{route('kebijakan.pusat.5.tahun.store')}}" method="post">
	@csrf
	<div class="row">
		<div class="col-md-6">
			<div class="box box-solid">
		<div class="box-body" id="form-kb5">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>KONDISI SAAT INI</label>
						<textarea class="form-control" name="uraian" style="min-height: 120px;" required=""></textarea>
					</div>

				</div>
				<div class="col-md-4">
						<div class="form-group">
							<label>NILAI</label>
							<input type="number" class="form-control" name="">
						
						</div>
						<div class="form-group">
							<label>SATUAN</label>
							<input type="number" class="form-control" name="">
						
						</div>
					</div>
				
			</div>
			

		</div>
		<div class="box-footer">
			<button class="btn btn-success btn-xs">TAMBAH</button>
		</div>
	</div>
		</div>
	</div>

</form>