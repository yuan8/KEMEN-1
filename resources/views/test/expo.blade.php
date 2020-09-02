<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<title></title>
</head>
<body>
	<table>
	<thead>
		<tr>
			<th>a</th>
			<th>a</th>
			<th>a</th>
			<th>a</th>

		</tr>
	</thead>
	<tbody>
		<tr>
			<td>1</td>
			<td>2</td>
			<td>2</td>
			<td>2</td>

		</tr>
	</tbody>
</table>
<table>
	<thead>
			<tr>
			<th class="text-center" >1</th>
			<th class="text-center" >2</th>
			<th class="text-center" >3</th>
			<th class="text-center" >4</th>
			<th class="text-center" >5</th>
			<th class="text-center" >6</th>
			<th class="text-center" >7</th>
			<th class="text-center" >8</th>
			<th class="text-center" >9</th>
			<th class="text-center" >10</th>
			<th class="text-center" >11</th>
			<th class="text-center" >12</th>


		</tr>
		
	</thead>
	<tbody>
		@foreach($data as $key=> $d)
			<tr>
				<td>{{($key+1)}}</td>
				<td>{{$d['_sub_urusan']['nama']}}</td>
				<td>
					<ul>
						@foreach($d['_uu'] as $u)
							<li>{!!nl2br($u['uraian'])!!}</li>
						@endforeach
					</ul>

				</td>
				<td>
					<ul>
						@foreach($d['_pp'] as $u)
							<li>{!!nl2br($u['uraian'])!!}</li>
						@endforeach
					</ul>

				</td>
				<td>
					<ul>
						@foreach($d['_perpres'] as $u)
							<li>{!!nl2br($u['uraian'])!!}</li>
						@endforeach
					</ul>

				</td>
				<td>
					<ul>
						@foreach($d['_permen'] as $u)
							<li>{!!nl2br($u['uraian'])!!}</li>
						@endforeach
					</ul>

				</td>
				<td>
					{!!nl2br($d['uraian'])!!}
				</td>
				<td>
					{{$d['tipe']?'REGULASI':'KEGIATAN'}}
				</td>
				
				@if($d['tipe'])


				<td>{{number_format($d['_list_perda_count'],0)}}</td>
				<td>{{number_format($d['_list_perkada_count'],0)}}</td>
				<td>{{number_format($d['_integrasi_sesuai_count'],0)}} Daerah</td>
				<td>{{number_format($d['_integrasi_tidak_sesuai_count'],0)}} Daerah</td>
				@else
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>

				@endif


			</tr>
			

		@endforeach
	</tbody>
</table>

</body>
</html>