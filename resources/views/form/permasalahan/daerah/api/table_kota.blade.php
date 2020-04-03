<div class="box box-success animated fadeInRight">
	<div class="box-body">
		
		<table class="table " id="table-kota">
			<thead>
				<tr>
					<th>KODE</th>
					<th>KOTA</th>
				</tr>
			</thead>
			<tbody>
				@foreach($daerahs as $d)
					<tr  class="cursor-link {{strlen(($d->id.'') )<3?'bg bg-warning':''}}" onclick="window.location='{{route('permasalahan.daerah.view.daerah',['id'=>$d->id])}}'">
						<td>{{$d->id}}</td>
						<td>{{$d->nama}}</td>
					</tr>

				@endforeach
			</tbody>

		</table>


	</div>

</div>