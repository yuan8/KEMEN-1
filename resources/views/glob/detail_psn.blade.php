<h5><b>{{$data['psn']['nama']}}</b></h5>
<table class="table table-bordered">
	<thead>
		<tr class="bg bg-warning">
			<th>PN</th>
			<th>PP</th>
			<th>KP</th>
			<th>PROPN</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{$data['psn']['nama_pn']}}</td>
			<td>{{$data['psn']['nama_pp']}}</td>
			<td>{{$data['psn']['nama_kp']}}</td>
			<td>{{$data['psn']['nama_propn']}}</td>

		</tr>
	</tbody>
	
</table>

<table class="table table-bordered">
	<thead>
		<tr class="bg bg-warning">
			<th>INDIKATOR</th>
			<th>TARGET PUSAT <b>{{$data['psn']['tahun_access']}}</b></th>
			
		</tr>
	</thead>
	<tbody>
		@foreach($data['ind'] as $d)
		<?php $d=(array)$d; ?>
		<tr>
			<td>{{$d['uraian']}}</td>
			<td>
				<h5><b>RKP</b> {{$d['target_pusat']}} ({{$d['satuan']}})</h5>
				<small><b>RPJMN</b> {{$d[$d['use_tg_when_false']]}} ({{$d['satuan']}})</small>

			</td>
			

		</tr>

		@endforeach

	</tbody>
	
</table>


