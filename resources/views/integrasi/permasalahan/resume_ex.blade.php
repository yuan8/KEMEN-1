@extends('layouts.export')


@section('content_header')


@stop

@section('content')
<table class="table-bordred table">
	<thead>
		<tr>
			<th colspan="11" class="text-center">PERMASALAHAN URUSAN</th>
		</tr>
		<tr>
			<th colspan="11">{{Hp::fokus_urusan()['nama'].' TAHUN '.Hp::fokus_tahun()}}</th>
		</tr>
	</thead>
</table>
<table class="table table-bordred table-striped">
	<thead>

		<tr>
			<td colspan="2">MASALAH POKOK</td>
			<td colspan="4"><b>{{$meta['urai_pokok']}}</b></td>
		</tr>
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>


		
		</tr>
		
		<tr>
			<th rowspan="">NO</th>
			<th rowspan="">KODE PEMDA</th>

			<th rowspan="">NAMA PROVINSI</th>

			<th rowspan="">NAMA DAERAH</th>

			<th colspan="">JUMLAH MASALAH</th>
			<th >JUMLAH AKAR MASALAH</th>
		
		</tr>
		
		
	</thead>
	<tbody>
		@foreach($data as $key=> $d)
		@php
		$d=(array)$d;
		@endphp
			<tr>
				<td>{{$key+1}}</td>
				<td>{{$d['kode_daerah']}}</td>

				<td>{{$d['nama_provinsi']?$d['nama_provinsi']:$d['nama_daerah']}}</td>
				<td>{{$d['nama_daerah']}}</td>
				<td>{{number_format($d['ms_count'],0)}} </td>
				<td>{{number_format($d['ms_akar_count'],0)}}</td>


			</tr>
			

		@endforeach
	</tbody>
</table>
@stop