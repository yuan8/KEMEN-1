@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>INTEGRASI {{$daerah['nama']}} {{Hp::fokus_tahun()+1}} </h3>
      </div>
      
    </div>
@stop

@section('content')
<div class="table-responsive">
	<table class="table-bordered table-hover table bg-white">
		<tbody>
			@foreach($data as $d)
			<tr>
				<td style="width: 220px">{!!nl2br($d['uraian'])!!}</td>
				<td style="width: 40px;"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i></button></td>
				<td style="width: 220px"></td>
				<td></td>
				<td></td>
				<td></td>

			</tr>
			@foreach($d['_reko_program'] as $p)
				<tr>
					<td></td>
					<td></td>
					<td>{{$p['_nomen']['uraian']}}</td>
				</tr>
				@foreach($d['_akar'] as $aka)
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td>{{$aka['uraian']}}</td>
				</tr>
				@endforeach

				@foreach($p['_child_kegiatan'] as $k)
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{$k['_nomen']['uraian']}}</td>

				</tr>
				@endforeach
			@endforeach
			@endforeach
		</tbody>
		<thead class="bg-navy">
			<tr>
				<th  colspan="2">MASALAH</th>
				<th>PROGARAM</th>
				<th style="width: 220px" colspan="2">AKAR MASALAH</th>
				<th>KEGIATAN</th>


			</tr>
		</thead>
	</table>
	</div>


@stop