

	<H5 class="text-center">KONFIRMASI PENGHAPUSAN</H5>
	<hr>
	<p><b>INDIKATOR :</b></p>
	<p>{{$indikator['uraian']}}</p>
	<hr>
	<small class="text-yellow"><i class="fa fa-info-circle"></i> Penghapusan akan dilakukan pada indikator "{{$indikator['uraian']}}" </small>
	<hr>
		<form action="{{route('int.kb5tahun.indikator.delete',['id'=>$indikator['id']])}}" method="post">
			@csrf
			@method('DELETE')
			<div class="full-w text-center">
				<div class="btn-group">
					<button class="btn btn-success" type="submit">SETUJU</button>
					<button class="btn btn-danger" type="button" data-dismiss="modal">BATAL</button>

				</div>
			</div>


		</form>
