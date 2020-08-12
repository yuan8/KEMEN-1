
	<H5 class="text-center text-uppercase">KONFIRMASI PENGHAPUSAN {{isset($permanen)?$permanen:''}}</H5>
	<hr>
	<p><b>INDIKATOR :</b></p>
	<p>{{$data['uraian']}}</p>
	<hr>
	<small class="text-yellow"><i class="fa fa-info-circle"></i> Penghapusan akan dilakukan pada indikator "{{$data['uraian']}}" </small>
	<hr>
	@php 
		if(isset($permanen)){
			$route_del=route('int.m.indikator.delete',['id'=>$data['id']]);
		}else{
			$route_del=route('int.pelurusan.delete',['id'=>$data['id']]);
		}
	@endphp
	<form action="{{$route_del}}" method="post">
		@csrf
		@method('DELETE')
		<div class="full-w text-center">
			<div class="btn-group">
				<button class="btn btn-success" type="submit">SETUJU</button>
				<button class="btn btn-danger" type="button" data-dismiss="modal">BATAL</button>
			</div>
		</div>


	</form>
