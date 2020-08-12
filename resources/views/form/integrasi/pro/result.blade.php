@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">RESULT INTEGRASI PROGRAM </h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')

<div class="box box-warning">
	<div class="box-body">
		<table class="table-bordered table">
			<thead>
				<tr>
				<th>DETAIL</th>
				<th>INDIKATOR</th>
				<th>TARGET PUSAT</th>
				<th>TARGET PENCAPAIAN DAERAH</th>
				<th>SURPLUS</th>
				<TH>DAERAH</TH>

			</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						<td></td>
						<td>{{$d->nama_ind}}</td>
						<td>
							@if(in_array($d->cal_type,['none',null]))
							{!!nl2br($d->target_pusat)!!} ({{$d->satuan}})
							@else
							{{number_format((float)$d->target_pusat,2,',','.')}} ({{$d->satuan}})
							@endif
						</td>
						<td>{{number_format((float)$d->terpenuhi,2,',','.')}} ({{$d->satuan}})</td>
						<td>
							@if($d->type=='cal')
								<?php
								$p=(float)($d->target_pusat)?$d->target_pusat:0;
								$s=(float)($d->terpenuhi)?$d->terpenuhi:0;
								?>

								{{number_format(($s - ($p)),2,',','.')}} ({{$d->satuan}})



							@else
								{{number_format((float)$d->terpenuhi,0,',','.')}} <small>DAERAH MENGUNKAAN INDIKATOR</small>
 							@endif

						</td>
						<td>
							<?php $DAERAH=explode('|@|', $d->daerah_join);  ?>
							@foreach($DAERAH as $key=>$dd)
								@if($key<5)
								<?php $dd=explode('||', $dd); ?>
								@if($dd[0]!='')
								<span class="badge bg-blue">{{$dd[1]}}</span>
								@endif
								@endif

							@endforeach
							{{isset($DAERAH[6])?'DLL':''}}

						</td>

					</tr>

				@endforeach
			</tbody>
		</table>
		{{$data->links()}}
	</div>
</div>

@stop