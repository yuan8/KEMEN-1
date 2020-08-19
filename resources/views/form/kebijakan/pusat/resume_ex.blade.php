@extends('layouts.export')


@section('content_header')


@stop

@section('content')
<table class="table-bordred table">
	<thead>
		<tr>
			<th colspan="11" class="text-center">KEBIJAKAN PUSAT</th>
		</tr>
		<tr>
			<th colspan="11">{{Hp::fokus_urusan()['nama'].' TAHUN '.Hp::fokus_tahun()}}</th>
		</tr>
	</thead>
</table>
<table class="table table-bordred table-striped">
	<thead>
		
		
		<tr >
			<th rowspan="2" class="text-center">NO</th>
			<th rowspan="2" class="text-center">SUB URUSAN</th>
			<th colspan="4" class="text-center">NSPK</th>
			<th rowspan="2" class="text-center">MANDAT KE DAERAH</th>
			<th colspan="2" class="text-center">KEBIJAKAN DAERAH</th>
			<th colspan="2" class="text-center">KESESUAIAN NSPK DAN KEBIJAKAN DAERAH</th>
		</tr>
		<tr>
			<th>UU</th>
			<th>PP</th>
			<th>PERMEN</th>
			<th>PERPRES</th>
			<th>PERDA</th>
			<th>PERKADA</th>
			<th>SESUAI</th>
			<th>TIDAK SESUAI</th>

		</tr>
		<tr class="text-center">
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
			<th>10</th>
			<th>11</th>

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