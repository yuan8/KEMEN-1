@extends('layouts.export')


@section('content_header')
<style type="text/css">
	
	th{
		text-align: center!important;
	}
</style>

@stop

@section('content')

@include('layouts.header-export',['context'=>$sub_title.' -'])
	<table class="table bg-white table-bordered " id="data_pelaksanaan_table">
		<thead class="bg-primary">
			<tr>
				<th rowspan="2" class="text-center">SUB URUSAN</th>
				<th rowspan="2" class="text-center">KEWENANGAN PUSAT</th>
				<th rowspan="2" class="text-center">KEWENANGAN PROVINSI</th>
				<th rowspan="2" class="text-center">KEWENANGAN KOTA / KAB</th>
				<th colspan="4" class="text-center">INDIKATOR</th>
			</tr>
			<tr>
				<th class="text-center">JENIS</th>
				<th class="text-center">INDIKATOR</th>
				<th class="text-center">TARGET</th>
				<th class="text-center">SATUAN</th>

			</tr>
			
		</thead>
		<tbody>
			@foreach($data as $k)
			<tr>
			
				<td>{{$k['_sub_urusan']['nama']}}</td>
				<td>{!!nl2br($k['kewenangan_nas'])!!}</td>
				<td>{!!nl2br($k['kewenangan_p'])!!}</td>
				<td colspan="6">{!!nl2br($k['kewenangan_k'])!!}</td>




			</tr>

			@foreach($k['_indikator'] as $i)
				<tr class="k-{{$k['id']}}">
					<td colspan="4">
						
					</td>
					<td>{{$i->_sumber()}}</td>
					
					<td>{{$i->uraian}}</td>
					<td>
						@if(($i['tipe_value']==1)OR($i['tipe_value']==2))
							{{number_format($i['target'],2)}}
						@else
							{{$i['target']}}

						@endif

						@if($i['tipe_value']==2)
							<-> {{number_format($i['target_1'],2)}}

						@endif
						

					</td>
					<td>{{$i->satuan}}</td>



				</tr>
			@endforeach



			@endforeach
		</tbody>
	</table>

@stop