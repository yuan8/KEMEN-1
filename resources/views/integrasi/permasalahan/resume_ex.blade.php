@extends('layouts.export')


@section('content_header')


@stop

@section('content')
@include('layouts.header-export',['context'=>'PERMASALAHAN URUSAN -'])

<table class="table table-bordered ">
	<thead>

		<tr>
			<td colspan="2" class="text-center"><b>MASALAH POKOK</b></td>
			<td colspan="4"><b>{!!nl2br($meta['urai_pokok'])!!}</b></td>
		</tr>
		
		
		<tr class="bg-primary">
			<th class="text-center" rowspan="" style="width: 50px;">NO</th>
			<th class="text-center" rowspan="" style="width: 50px;">KODE PEMDA</th>

			<th class="text-center" rowspan="">NAMA PROVINSI</th>

			<th class="text-center" rowspan="">NAMA DAERAH</th>

			<th class="text-center" colspan="">JUMLAH MASALAH</th>
			<th class="text-center" >JUMLAH AKAR MASALAH</th>
		
		</tr>
		<tr class="bg-primary">
			<th class="text-center">1</th>
			<th class="text-center">2</th>
			<th class="text-center">3</th>
			<th class="text-center">4</th>
			<th class="text-center">5</th>
			<th class="text-center">6</th>


		
		</tr>
		
		
	</thead>
	<tbody>
		@foreach($data as $key=> $d)
		@php
		$d=(array)$d;
		@endphp
			<tr>
				<td class="text-center">{{$key+1}}</td>
				<td class="text-center">{{$d['kode_daerah']}}</td>

				<td>{{$d['nama_provinsi']?$d['nama_provinsi']:$d['nama_daerah']}}</td>
				<td>{{$d['nama_daerah']}}</td>
				<td>{{number_format($d['ms_count'],0)}} </td>
				<td>{{number_format($d['ms_akar_count'],0)}}</td>


			</tr>
			

		@endforeach
	</tbody>
</table>
@stop