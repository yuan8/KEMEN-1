@extends('layouts.export')


@section('content_header')
<style type="text/css">
	.bg-gray{
		background-color: #ddd!important;
	}
</style>

@stop

@section('content')


@include('layouts.header-export',['context'=>$sub_title.' -'])
<table class="table table-bordered ">
	<thead class="text-center bg-primary" >
		<tr>
			<th rowspan="2" class="text-center">ISU STRATEGIS</th>
			<th rowspan="2" class="text-center">KONDISI SAAT INI</th>
			<th rowspan="2" class="text-center">ARAH KEBIJAKAN</th>
			<th colspan="4" class="text-center">SASARAN / INDIKATOR</th>
			<th colspan="4" class="text-center">KEWENANGAN</th>


		</tr>
		<tr>
			<th class="text-center">SUB URUSAN</th>
			<th class="text-center">URAIAN</th>
			<th class="text-center">TARGET</th>
			<th class="text-center">SATUAN</th>

			<th class="text-center">PUSAT</th>
			<th class="text-center">PROVINSI</th>
			<th class="text-center">KOTA / KAB</th>
			<th class="text-center">PELAKSANA</th>





		</tr>
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


		</tr>

	</thead>
	<tbody>
		@foreach($data as $d)
			<tr>
				<td>{!!nl2br($d['uraian']) !!}</td>
				<td class="bg-info"></td>
				<td></td>
				<td colspan="8"></td>
			</tr>
			@foreach($d['_children'] as $kn)
			<tr>
				<td></td>
				<td class="bg-info">{!!nl2br($kn['uraian'])!!}</td>
				<td></td>
				<td colspan="8"></td>

			</tr>
			@foreach($kn['_children'] as $ak)
			<tr>
				<td colspan=""></td>
				<td class="bg-info"></td>

				<td >{!!nl2br($ak['uraian'])!!}</td>
				<td colspan="8"></td>

			</tr>
			@foreach($ak['_indikator'] as $i)
			<tr>
				<td colspan=""></td>
				<td class="bg-info"></td>
				<td colspan=""></td>

				<td >{!!nl2br($i['_sub_urusan']['nama'])!!}</td>


				<td >{!!nl2br($i['uraian'])!!}</td>
				<td >
					@if(($i['tipe_value']==1)OR($i['tipe_value']==2))
						{{number_format($i['target'],2)}}
					@else
						{{$i['target']}}

					@endif

					@if($i['tipe_value']==2)
						<-> {{number_format($i['target_1'],2)}}

					@endif
				</td>
				<td>{!!$i['satuan']!!}</td>
					<td>
									@if($i['kw_nas'])
										<i class="fa text-success fa-check"></i> BERWENANG
									@else
										<i class="fa text-danger fa-times"></i> TIDAK BERWENANG
										

									@endif


								</td>
								<td>
									@if($i['kw_p'])
										<i class="fa text-success fa-check"></i> BERWENANG
									@else
										<i class="fa text-danger fa-times"></i> TIDAK BERWENANG

									@endif


								</td>
								<td>
									@if($i['kw_k'])
										<i class="fa text-success fa-check"></i> BERWENANG
									@else
										<i class="fa text-danger fa-times"></i> TIDAK BERWENANG

									@endif


								</td>
								<td style="min-width: 200px;">
									@php
										$i['pelaksana_nas']=json_decode($i['pelaksana_nas']);

										$i['pelaksana_p']=json_decode($i['pelaksana_p']);
										$i['pelaksana_k']=json_decode($i['pelaksana_k']);

									@endphp
									@if($i['kw_nas'])

										<b>PUSAT</b>
										<ul>
										@foreach($i['pelaksana_nas'] as $p)

											<li>{{$p}}</li>
										@endforeach
										</ul>
									@endif
									@if($i['kw_p'])


									<b>PROVINSI</b>
									<ul>
									@foreach($i['pelaksana_p'] as $p)

										<li>{{$p}}</li>
									@endforeach
									</ul>
									@endif
									@if($i['kw_k'])
									

									<b>KOTA/KAB</b>
									<ul>
									@foreach($i['pelaksana_k'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									@endif
									
								</td>

			</tr>
			@endforeach
			@endforeach


			@endforeach
		@endforeach
	</tbody>
</table>
@stop