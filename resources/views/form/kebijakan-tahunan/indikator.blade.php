@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN </h3>
    	</div>
    	
    	
    </div>
@stop


@section('content')

	<?php $tahun_start=$proyek->tahun; ?>
	
	<h5 class="text-center"><b>{{$proyek->nama_sub_urusan}}</b></h5>
	<div class="box box-warning">
		<div class="box-header with-border">
			<h5><b>{{$proyek->nama}}</b></h5>
		</div>
		<div class="box-body">
			<table class="table-bordered table">
				<thead>
					<tr>
					<th>PN</th>
					<th>PP</th>
					<th>KP</th>
					<th>PROPN</th>

				</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{  ($proyek->nama_pn)}}</td>
						<td>{{  ($proyek->nama_pp)}}</td>
						<td>{{  ($proyek->nama_kp)}}</td>
						<td>{{  ($proyek->nama_propn)}}</td>



					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="box box-warning">
		<div class="box-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ACTION</th>

						<th>INDIKATOR</th>
						<th>SATUAN</th>
						<th>TIPE KALKULASI</th>
						<th class="bg {{$tahun_start==Hp::fokus_tahun()?'bg-warning':''}}">TARGET {{$tahun_start}}</th>
						<th class="bg {{($tahun_start+1)==Hp::fokus_tahun()?'bg-warning':''}}">TARGET {{$tahun_start+1}}</th>
						<th class="bg {{($tahun_start+2)==Hp::fokus_tahun()?'bg-warning':''}}">TARGET {{$tahun_start+2}}</th>
						<th class="bg {{($tahun_start+3)==Hp::fokus_tahun()?'bg-warning':''}}">TARGET {{$tahun_start+3}}</th>
						<th class="bg {{($tahun_start+4)==Hp::fokus_tahun()?'bg-warning':''}}">TARGET {{$tahun_start+4}}</th>

					</tr>
				</thead>
				<tbody>
					@foreach($data as $d)
						<tr>
							<td class="btn-group">
								<a href="" class="btn btn-warning btn-xs">Detail</a>
								<a href="{{route('kebijakan.pusat.tahunan.proyek.view_ind_psn',['id'=>$d->id])}}" class="btn btn-warning btn-xs">Edit</a>

							</td>
							<td>{{$d->uraian}}</td>
							<td>
								{{$d->view_satuan}}
							</td>
							<td>
								<b>{{strtoupper(str_replace('_',' ',$d->cal_type))}}</b>

							</td>
							<td class="bg {{$tahun_start==Hp::fokus_tahun()?'bg-warning':''}}">
								<H5 class="{{($d->rkp_1!=null)?'':'text-danger'}}" ><b>RKP {{$d->rkp_1}}</b> {{$d->view_satuan}}</H5>
								<small>RPJMN {{$d->target_1}} {{$d->view_satuan}}</small>
							</td>
							<td class="bg {{($tahun_start+1)==Hp::fokus_tahun()?'bg-warning':''}}">
								<H5 class="{{($d->rkp_2!=null)?'':'text-danger'}}" ><b>RKP {{$d->rkp_2}}</b> {{$d->view_satuan}}</H5>

								<small>RPJMN {{$d->target_2}} {{$d->view_satuan}}</small>
							</td>
							<td class="bg {{($tahun_start+2)==Hp::fokus_tahun()?'bg-warning':''}}">
								<H5 class="{{$d->rkp_3?'':'text-danger'}}" ><b>RKP {{$d->rkp_3}}</b> {{$d->view_satuan}}</H5>

								<small>RPJMN {{$d->target_3}} {{$d->view_satuan}}</small>
							</td>
							<td class="bg {{($tahun_start+3)==Hp::fokus_tahun()?'bg-warning':''}}">
								<H5 class="{{$d->rkp_4?'':'text-danger'}}" ><b>RKP {{$d->rkp_4}}</b> {{$d->view_satuan}}</H5>

								<small>RPJMN {{$d->target_4}} {{$d->view_satuan}}</small>
							</td>
							<td class="bg {{($tahun_start+4)==Hp::fokus_tahun()?'bg-warning':''}}">
								<H5 class="{{$d->rkp_5?'':'text-danger'}}" ><b>RKP {{$d->rkp_5}}</b> {{$d->view_satuan}}</H5>

								<small>RPJMN {{$d->target_5}} {{$d->view_satuan}}</small>
							</td>
						</tr>
						

					@endforeach
				</tbody>
			</table>
		</div>
	</div>


@stop