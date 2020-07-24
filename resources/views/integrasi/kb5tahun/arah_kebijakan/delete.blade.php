

	<H5 class="text-center">KONFIRMASI PENGHAPUSAN</H5>
	<hr>
	<p><b>ARAH KEBIJAKAN :</b></p>
	<p>{{$ak['uraian']}}</p>
	<hr>
	<small class="text-yellow"><i class="fa fa-info-circle"></i> Penghapusan akan dilakukan pada arah kebijakan  "{{$ak['uraian']}}" berserta data turunan dari arah kebijakan ini</small>
	<hr>
		<form action="{{route('int.kb5tahun.ak.delete',['id'=>$ak['id']])}}" method="post">
			@csrf
			@method('DELETE')
			<div class="full-w text-center">
				<div class="btn-group">
					<button class="btn btn-success" type="submit">SETUJU</button>
					<button class="btn btn-danger" type="button" data-dismiss="modal">BATAL</button>
				</div>
			</div>


		</form>
