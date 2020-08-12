<table class="table-bordered table bg-yellow text-dark">
	<thead>
		<tr>
			<th>KODE</th>
			<th>NAMA KEGIATAN</th>
			
		</tr>
	</thead>
	<tbody>
		@foreach($data as $d)
		<tr>
			<td>{{$d->kode_kegiatan}}</td>
			<td>{{$d->uraikegiatan}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
