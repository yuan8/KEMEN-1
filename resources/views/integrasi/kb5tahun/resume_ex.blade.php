@extends('layouts.export')


@section('content_header')
<style type="text/css">
	
	th{
		text-align: center!important;
	}
</style>

@stop

@section('content')

<table class="table-bordred table">
	<thead  class="text-center" >
		<tr>
			<th class="text-center"  colspan="11" class="text-center">{{$sub_title}}</th>
		</tr>
		<tr>
			<th class="text-center"  colspan="11" class="text-center">{{Hp::fokus_urusan()['nama'].' TAHUN '.Hp::fokus_tahun()}}</th>
		</tr>
	</thead>
</table>
<table class="table table-bordred ">
	<thead class="text-center" >
		<tr>
			<th rowspan="2">ISU STRATEGIS</th>
			<th rowspan="2">KONDISI SAAT INI</th>
			<th rowspan="2">ARAH KEBIJAKAN</th>
			<th colspan="5">SASARAN / INDIKATOR</th>
			<th colspan="4">KEWENANGAN</th>


		</tr>
		<tr>
			<th>SUB URUSAN</th>
			<th>KODE</th>
			<th>URAIAN</th>
			<th>TARGET</th>
			<th>SATUAN</th>

			<th>PUSAT</th>
			<th>PROVINSI</th>
			<th>KOTA / KAB</th>
			<th>PELAKSANA</th>





		</tr>

	</thead>
	<tbody>
		@foreach($data as $d)
			<tr>
				<td colspan="12">{!!nl2br($d['uraian']) !!}</td>
			</tr>
			@foreach($d['_children'] as $kn)
			<tr>
				<td></td>
				<td colspan="11">{!!nl2br($kn['uraian'])!!}</td>
			</tr>
			@foreach($kn['_children'] as $ak)
			<tr>
				<td colspan="2"></td>
				<td colspan="10">{!!nl2br($ak['uraian'])!!}</td>
			</tr>
			@foreach($ak['_indikator'] as $i)
			<tr>
				<td colspan="3"></td>
				<td >{!!nl2br($i['_sub_urusan']['nama'])!!}</td>

				<td >{!!nl2br($i['kode'])!!}</td>

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