@extends('layouts.export')


@section('content_header')
<style type="text/css">
	
	th{
		text-align: center!important;
	}

	.page-break {
    	page-break-before: always!important;
	}
	 tr.page-break  { display: block; page-break-before: always; }
</style>

@stop

@section('content')
@include('layouts.header-export',['context'=>'IDENTIFIKASI KEBIJAKAN -'])

<table class="table table-bordered" border='1'  >
	<thead class="text-center bg-primary" >
		<tr class="bg-primary" >
			<th class="text-center"  rowspan="2" style="width: 50px;" >NO</th>
			<th class="text-center"  rowspan="2">SUB URUSAN</th>
			<th class="text-center"  colspan="4">NSPK</th>
			<th class="text-center"  rowspan="2">MANDAT KE DAERAH</th>
			<th class="text-center"  rowspan="2">KATEGORI</th>
			<th class="text-center"  colspan="2">REGULASI DAERAH</th>
			<th class="text-center"  colspan="2">KESESUAIAN NSPK DAN REGULASI DAERAH</th>
		</tr>
		<tr class="bg-primary">
			<th class="text-center" >UU</th>
			<th class="text-center" >PP</th>
			<th class="text-center" >PERPRES</th>
			<th class="text-center" >PERMEN</th>
			<th class="text-center" >PERDA</th>
			<th class="text-center" >PERKADA</th>
			<th class="text-center" >SESUAI</th>
			<th class="text-center" >TIDAK SESUAI</th>

		</tr>
		<tr class="bg-primary">
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
		@php
			$id_sub_urusan=('');
		@endphp
		@foreach($data as $key=> $d)
			
		@if(($d['_sub_urusan']['id']!=$id_sub_urusan) AND ($id_sub_urusan!=''))
			</tbody>
		</table>
		<div class="page-break"></div>
		<table class="table table-bordered" border='1'  >
			<thead class="text-center bg-primary" >
				<tr class="bg-primary" >
					<th class="text-center"  rowspan="2" style="width: 50px;" >NO</th>
					<th class="text-center"  rowspan="2">SUB URUSAN</th>
					<th class="text-center"  colspan="4">NSPK</th>
					<th class="text-center"  rowspan="2">MANDAT KE DAERAH</th>
					<th class="text-center"  rowspan="2">KATEGORI</th>
					<th class="text-center"  colspan="2">REGULASI DAERAH</th>
					<th class="text-center"  colspan="2">KESESUAIAN NSPK DAN REGULASI DAERAH</th>
				</tr>
				<tr class="bg-primary">
					<th class="text-center" >UU</th>
					<th class="text-center" >PP</th>
					<th class="text-center" >PERPRES</th>
					<th class="text-center" >PERMEN</th>
					<th class="text-center" >PERDA</th>
					<th class="text-center" >PERKADA</th>
					<th class="text-center" >SESUAI</th>
					<th class="text-center" >TIDAK SESUAI</th>

				</tr>
				<tr class="bg-primary">
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

		@endif

			@if($id_sub_urusan!=$d['_sub_urusan']['id'])
				<tr class="bg-info">
					<td colspan="12"><b>SUB URUSAN - {{$d['_sub_urusan']['nama']}}</b></td>
				</tr>
			@endif
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

			@php
			if($id_sub_urusan!=$d['_sub_urusan']['id']){
				$id_sub_urusan=$d['_sub_urusan']['id'];
			}
			@endphp

		@endforeach
	</tbody>
</table>
@stop