<div class="col-md-12 text-center">
	<h5><b>FINALISASI REKOMENDASI {{$data['nama']}} TAHUN {{Hp::fokus_tahun()}}</b></h5>
	<hr>
	<p>ANDA TIDAK DAPAT MELAKUKAN PERUBAHAN DATA KEMBALI PADA STATUS REKOMENDASI FINAL</p>
</div>

<form action="{{route('int.rekomendasi.finalisasi',['id'=>$data['id']])}}" method="post">
	@csrf
	@method('POST')

	<div class="full-w text-center">
		<div class="btn-group">
			<button class="btn btn-success" type="submit">SETUJU</button>
			<button class="btn btn-danger" type="button" data-dismiss="modal">BATAL</button>
		</div>
	</div>


</form>