<H5 class="text-center">KONFIRMASI PENGHAPUSAN</H5>
<hr>
<b>INDIKATOR {{$jenis}} :</b>
<br>
<p> {{$parent['uraian']}} </p>

<form action="{{route('int.rekomendasi.delete_indikator',['kodepemda'=>$kodepemda,'id'=>$id_parent])}}" method="post">
	@csrf
	@method('DELETE')
	<div class="full-w text-center">
		<div class="btn-group">
			<button class="btn btn-success" type="submit">SETUJU</button>
			<button class="btn btn-danger" type="button" data-dismiss="modal">BATAL</button>
		</div>
	</div>


</form>