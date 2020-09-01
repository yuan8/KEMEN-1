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
			<th class="text-center"  colspan="11" class="text-center">KEBIJAKAN PUSAT</th>
		</tr>
		<tr>
			<th class="text-center"  colspan="11" class="text-center">{{Hp::fokus_urusan()['nama'].' TAHUN '.Hp::fokus_tahun()}}</th>
		</tr>
	</thead>
</table>
<table class="table table-bordred table-striped">
	<thead class="text-center" >

		
		<tr >
			<th class="text-center"  rowspan="2" >NO</th>
			<th class="text-center"  rowspan="2">SUB URUSAN</th>
			<th class="text-center"  colspan="4">NSPK</th>
			<th class="text-center"  rowspan="2">MANDAT KE DAERAH</th>
			<th class="text-center"  rowspan="2">KATEGORI</th>

			<th class="text-center"  colspan="2">REGULASI DAERAH</th>
			<th class="text-center"  colspan="2">KESESUAIAN NSPK DAN REGULASI DAERAH</th>
		</tr>
		<tr>
			<th class="text-center" >UU</th>
			<th class="text-center" >PP</th>
			<th class="text-center" >PERPRES</th>
			<th class="text-center" >PERMEN</th>
			<th class="text-center" >PERDA</th>
			<th class="text-center" >PERKADA</th>
			<th class="text-center" >SESUAI</th>
			<th class="text-center" >TIDAK SESUAI</th>

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
				
				
				<td>{{number_format($d['_list_perda_count'],0)}}</td>
				<td>{{number_format($d['_list_perkada_count'],0)}}</td>
				<td>{{number_format($d['_integrasi_sesuai_count'],0)}} Daerah</td>
				<td>{{number_format($d['_integrasi_tidak_sesuai_count'],0)}} Daerah</td>


			</tr>
			

		@endforeach
	</tbody>
</table>
@stop