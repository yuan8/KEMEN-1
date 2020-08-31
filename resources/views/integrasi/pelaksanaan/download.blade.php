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
	<table class="table bg-white table-bordered " id="data_pelaksanaan_table">
		<thead class="bg-navy">
			<tr>
				<th rowspan="2" >SUB URUSAN</th>
				<th rowspan="2">KEWENANGAN PUSAT</th>
				<th rowspan="2">KEWENANGAN PROVINSI</th>
				<th rowspan="2">KEWENANGAN KOTA / KAB</th>
				<th colspan="5">INDIKATOR</th>
			</tr>
			<tr>
				<th >JENIS</th>
				<th >KODE</th>
				<th >INDIKATOR</th>
				<th >TARGET</th>
				<th >SATUAN</th>

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
					
					<td>{{$i->kode}}</td>
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