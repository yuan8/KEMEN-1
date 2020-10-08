@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN ({{Hp::fokus_tahun()}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<div class="box">
	<div class="box-body">
		<table class="table table-bordered">
			@foreach($data as $pn)
			<tr>
				<td style="width: 30px"></td>
				<td colspan="3">{{$pn['uraian']}}</td>

			</tr>
			@foreach($pn['_tag_indikator'] as $tagpni )
				@php
				$pni=$tagpni['_indikator'];
				@endphp
				<tr>
					<td style="width: 60px" colspan="2"></td>
					<td>{{$pni['uraian']}}</td>

				</tr>
			@endforeach
			@foreach($pn['_child_pp'] as $pp )
				
				<tr>
					<td style="width: 60px" colspan="2"></td>
					<td>{{$pp['uraian']}}</td>

				</tr>
				@foreach($pp['_child_kp'] as $kp )
					
					<tr>
						<td style="width: 60px" colspan="3"></td>
						<td>KP-{{$kp['uraian']}}</td>

					</tr>
				@endforeach
			@endforeach


			@endforeach
		</table>
	</div>
</div>

@stop