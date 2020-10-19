@extends('layouts.export')


@section('content_header')


@stop

@section('content')
@include('layouts.header-export',['context'=>'KEBIJAKAN PUSAT -'])

<table class="table table-bordred table-striped">
	<thead class="bg-primary">
		
		
		<tr >
			<th rowspan="2" class="text-center">NO</th>
			<th rowspan="2" class="text-center">SUB URUSAN</th>
			<th colspan="4" class="text-center">NSPK</th>
			<th rowspan="2" class="text-center">MANDAT KE DAERAH</th>
			<th colspan="2" class="text-center">KEBIJAKAN DAERAH</th>
			<th colspan="2" class="text-center">KESESUAIAN NSPK DAN KEBIJAKAN DAERAH</th>
		</tr>
		<tr>
			<th class="text-center">UU</th>
			<th class="text-center">PP</th>
			<th class="text-center">PERPRES</th>
			<th class="text-center">PERMEN</th>
			<th class="text-center">PERDA</th>
			<th class="text-center">PERKADA</th>
			<th class="text-center">SESUAI</th>
			<th class="text-center">TIDAK SESUAI</th>

		</tr>
		<tr class="text-center">
			<th class="text-center">1</th>
			<th class="text-center">2</th>
			<th class="text-center">3</th>
			<th class="text-center">4</th>
			<th class="text-center">5</th>
			<th class="text-center">6</th>
			<th class="text-center">7</th>
			<th class="text-center">8</th>
			<th class="text-center">9</th>
			<th class="text-center">10</th>
			<th class="text-center">11</th>

		</tr>
		
	</thead>
	<tbody>
		@foreach($data as $key=> $d)
			<tr>
				
			</tr>
			

		@endforeach
	</tbody>
</table>
@stop