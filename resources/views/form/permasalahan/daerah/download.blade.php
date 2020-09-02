@extends('layouts.export')


@section('content_header')


@stop

@section('content')
<table class="table-bordred table">
	<thead>
		<tr>
			<th colspan="11" class="text-center">{{$sub_title}}</th>
		</tr>
		<tr>
			<th colspan="11">{{Hp::fokus_urusan()['nama'].' TAHUN '.Hp::fokus_tahun()}}</th>
		</tr>
	</thead>
</table>

@stop