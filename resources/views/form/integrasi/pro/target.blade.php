@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">

    		<h3 class="text-uppercase"><img src="{{asset($daerah->logo)}}" style="width: 50px;"> INTEGRASI  {{strtoupper($daerah->nama)}} </h3>
    		
    	</div>
    	
    </div>
@stop



@section('content')

	<div class="box box-warning">
		<form class="" action="{{route('map.provinsi.ind.store',['id'=>$daerah->id,'ind'=>$ind['id']])}}" method="post">
			@csrf
		<div class="box-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>PN</th>
						<th>PP</th>
						<th>KP</th>
						<th>PROPN</th>
						<th>PROYEK</th>

					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{$ind['nama_pn']}}</td>
						<td>{{$ind['nama_pp']}}</td>
						<td>{{$ind['nama_kp']}}</td>
						<td>{{$ind['nama_propn']}}</td>
						<td>{{$ind['nama_psn']}}</td>

					</tr>
					<tr  class="bg bg-success">
						<td colspan="2">
							<b>{{$ind['uraian']}}</b>
						</td>
						<td>
							<b>Target Pusat ({{HP::fokus_tahun()}})</b>
							<h5>{!!nl2br($ind['target_pusat']?'<b>RKP</b> '.$ind['target_pusat']:'')!!} ({{$ind['satuan']}})</h5>
							<small><b>RPJMN</b> {!!nl2br($ind[$ind['use_tg_when_false']])!!} ({{$ind['satuan']}})</small>
						</td>

						<td>
							@if(in_array($ind['cal_type'],['min_accept','max_accept','aggregate']))
							<input type="number" name="target" placeholder="" required="target daerah" class="form-control" value="{{$ind['target_daerah']}}">
							<small>Target Daerah</small>
							@else
							<textarea name="target" placeholder="target daerah" class="form-control">{!!$ind['target_daerah']!!}</textarea>
							@endif
						</td>
						<td>
							<b>{{$ind['satuan']}}</b>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="box-footer modal-footer">
			<button type="submit" class="btn btn-warning btn-sm">SIMPAN</button>
		</div>
		</form>
	</div>

	<div class="box box-warning">
		<div class="box-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>TINGKAT</th>
						<th>NOMEKLATUR</th>
						<th>URAIAN</th>


					</tr>
				</thead>
			</table>
		</div>
	</div>

@stop