@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN </h3>
    	</div>
    	
    	
    </div>
@stop


@section('content')
<h5 class="text-center"><b>{{$data['nama_sub_urusan']}}</b></h5>
	<div class="box box-warning">
		<div class="box-header with-border">
			<h5><b>{{$data['nama_psn']}}</b></h5>
		</div>
		<div class="box-body">
			<table class="table table-bordered">
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
						<td>{{$data['nama_pn']}}</td>
						<td>{{$data['nama_pp']}}</td>
						<td>{{$data['nama_kp']}}</td>
						<td>{{$data['nama_propn']}}</td>

					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="box box-warning">
		<div class="box-header with-border">
			<h5>{{$data['uraian']}}</h5>
		</div>
		<form method="post" action="{{route('kebijakan.pusat.tahunan.proyek.update_ind_psn_meta',['id'=>$data['id']])}}">
				@csrf
				@method('PUT')
		<div class="box-body">

					<table class="table table-bordered">
				<thead>
					<tr>
						<th>SATUAN</th>
						<th  style="max-width: 100px;">TIPE KALKULASI</th>
						<th colspan="3">KEWENANGAN</th>
						<th>PELAKSANA</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<select class="form-control" required="" name="satuan">
								<option value="">Belum Terdefinisi</option>
								@foreach(DB::table('master_satuan')->get() as $s)
									<option value="{{$s->id}}" {{$s->id==$data['id_satuan']?'selected':''}}>{{$s->kode}}</option>
								@endforeach
							</select>
						</td>
					
						<td style="max-width: 200px;">
							<select class="form-control" name="cal_type">
								<option value="none" {{$data['cal_type']=='none'?'selected':''}}>
									Tanpa Kalkulasi otomatis
								</option>
								<option value="min_accept" {{$data['cal_type']=='min_accept'?'selected':''}}>
									<h5><b>MIN ACCEPT</b></h5>
									<br>
									<small>Hanya menghitung jika nilai (minimal) terpenuhi</small>
								</option>
								<option value="max_accept" {{$data['cal_type']=='max_accept'?'selected':''}}>
									<h5><b>MAX ACCEPT</b></h5>
									<br>
									<small>Hanya menghitung jika nilai (maximal) terpenuhi atau < dari nilai </small>
								</option>
								<option value="aggregate" {{$data['cal_type']=='aggregate'?'selected':''}}>
									Aggregate
								</option>
								<option value="aggregate_min" {{$data['cal_type']=='aggregate_min'?'selected':''}}>
									Aggregate (Bernilai -)
								</option>
							</select>
							@if(in_array($data['cal_type'],['min_accept','max_accept','aggregate']))
							<h5><b>NUMERIC</b></h5>
							@else
							<h5><b>TEXT</b></h5>

							@endif
							<small>Otomatis tergatung tipe kalkulasi</small>
							
						</td>
						<td>
							<p><b>Pusat</b></p>
						 <label class="checkbox-inline" style="min-width: 100%;">
                           <input type="checkbox" name="k_pusat" {{$data['k_pusat']?'checked':''}}  data-toggle="toggle"  data-onstyle="warning" data-on="Berwenang" data-off="Tidak Berwenang" data-offstyle="danger" data-size="small" data-width="100%"> 
                          </label>
							
							
						</td>
						<td>
								<p><b>Provinsi</b></p>
						 <label class="checkbox-inline" style="min-width: 100%;">
                           <input type="checkbox" name="k_pro" {{$data['k_pro']?'checked':''}}  data-toggle="toggle"  data-onstyle="warning" data-on="Berwenang" data-off="Tidak Berwenang" data-offstyle="danger" data-size="small" data-width="100%"> 
                          </label>
						</td>
						<td>
							<p><b>Kota/Kab</b></p>
						 <label class="checkbox-inline" style="min-width: 100%;">
                           <input type="checkbox" name="k_kota" {{$data['k_kota']?'checked':''}}  data-toggle="toggle"  data-onstyle="warning" data-on="Berwenang" data-off="Tidak Berwenang" data-offstyle="danger" data-size="small" data-width="100%"> 
                          </label>
						</td>
						<td>
							<textarea class="form-control" placeholder="pelaksana..." name="pelaksana">{{($data['pelaksana'])}}</textarea>
						</td>
						

					</tr>
					<tr>
						<th colspan="5">Lokus</th>
						<!-- <th>Major Proyek</th> -->
					</tr>
					<tr>
						<td colspan="5">
							<textarea class="form-control" placeholder="Lokus..." name="lokus_text">{{($data['lokus_text'])}}</textarea>
						</td>
						<td>
						<!-- <p><b>Provinsi</b></p>
						 <label class="checkbox-inline" style="min-width: 100%;">
                           <input type="checkbox" name="k_pro" {{$data['k_pro']?'checked':''}}  data-toggle="toggle"  data-onstyle="warning" data-on="Berwenang" data-off="Tidak Berwenang" data-offstyle="danger" data-size="small" data-width="100%"> 
                          </label> -->
							
						</td>
					</tr>
				</tbody>

			</table>
		</div>
		<div class="box-footer modal-footer">
			<button class="btn btn-warning btn-sm" type="submit">Update</button>
		</div>
			</form>

	</div>
	<div class="box box-warning">
		<form action="{{route('kebijakan.pusat.tahunan.proyek.update_ind_psn',['id'=>$data['id']])}}" method="post">
			@csrf
			@method('PUT')
				<div class="box-body">
			
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Indikator</th>
						<th>{{$tahun_start}}</th>
						<th>{{$tahun_start+1}}</th>
						<th>{{$tahun_start+2}}</th>
						<th>{{$tahun_start+3}}</th>
						<th>{{$tahun_start+4}}</th>

					</tr>


				</thead>
				<tbody>
					<tr>
						<td>{{$data['uraian']}}</td>
						<td>
							@if(($tahun_start)==$fokus_tahun)
							@if(in_array($data['cal_type'],['min_accept','max_accept','aggregate','aggregate_min']))
							<input type="number" name="target_tahunan[{{$tahun_start}}]" class="form-control" value="{{!empty($data['target_tahunan'][$tahun_start])?$data['target_tahunan'][$tahun_start]['target']:''}}" placeholder="target..">

							@else
							<textarea class="form-control"  name="target_tahunan[{{$tahun_start}}]" placeholder="target.." >{!!nl2br(!empty($data['target_tahunan'][$tahun_start])?$data['target_tahunan'][$tahun_start]['target']:'')!!}</textarea>

							@endif
						
							<h5><b>RKP SEBELUMNYA <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start)])?$data['target_tahunan'][($tahun_start)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@else
							<h5><b>RKP  <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start)])?$data['target_tahunan'][($tahun_start)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@endif
							<small>RPJMN {{$data['target_1']}} {{$data['satuan']}}</small>

						</td>
						<td>
							@if(($tahun_start+1)==$fokus_tahun)
							@if(in_array($data['cal_type'],['min_accept','max_accept','aggregate','aggregate_min']))
							<input type="number" name="target_tahunan[{{($tahun_start+1)}}]" class="form-control" value="{{!empty($data['target_tahunan'][($tahun_start+1)])?$data['target_tahunan'][($tahun_start+1)]['target']:''}}" placeholder="target.." >

							@else
							<textarea class="form-control"  name="target_tahunan[{{($tahun_start+1)}}]" placeholder="target..">{!!nl2br(!empty($data['target_tahunan'][($tahun_start+1)])?$data['target_tahunan'][($tahun_start+1)]['target']:'')!!}</textarea>

							@endif

					
							<h5><b>RKP SEBELUMNYA <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+1)])?$data['target_tahunan'][($tahun_start+1)]['target']:''}}
							</span>  {{$data['satuan']}}</b></h5>
							@else
							<h5><b>RKP <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+1)])?$data['target_tahunan'][($tahun_start+1)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@endif
							<small>RPJMN {{$data['target_2']}} {{$data['satuan']}}</small>
						</td>
						<td>
							@if(($tahun_start+2)==$fokus_tahun)

							@if(in_array($data['cal_type'],['min_accept','max_accept','aggregate','aggregate_min']))
							<input type="number" name="target_tahunan[{{($tahun_start+2)}}]" class="form-control" value="{{!empty($data['target_tahunan'][($tahun_start+2)])?$data['target_tahunan'][($tahun_start+2)]['target']:''}}" placeholder="target..">

							@else
							<textarea class="form-control"  name="target_tahunan[{{($tahun_start+2)}}]" placeholder="target..">{!!nl2br(!empty($data['target_tahunan'][($tahun_start+2)])?$data['target_tahunan'][($tahun_start+2)]['target']:'')!!}</textarea>

							@endif
							<h5><b>RKP SEBELUMNYA <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+2)])?$data['target_tahunan'][($tahun_start+2)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@else
							<h5><b>RKP <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+2)])?$data['target_tahunan'][($tahun_start+2)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@endif
							<small>RPJMN {{$data['target_3']}} {{$data['satuan']}}</small>
						</td>

						<td>
							@if(($tahun_start+3)==$fokus_tahun)

							@if(in_array($data['cal_type'],['min_accept','max_accept','aggregate','aggregate_min']))
							<input type="number" name="target_tahunan[{{($tahun_start+3)}}]" class="form-control" value="{{!empty($data['target_tahunan'][($tahun_start+3)])?$data['target_tahunan'][($tahun_start+3)]['target']:''}}" placeholder="target..">

							@else
							<textarea class="form-control"  name="target_tahunan[{{($tahun_start+3)}}]" placeholder="target..">{!!nl3br(!empty($data['target_tahunan'][($tahun_start+3)])?$data['target_tahunan'][($tahun_start+3)]['target']:'')!!}</textarea>

							@endif
							<h5><b>RKP SEBELUMNYA <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+3)])?$data['target_tahunan'][($tahun_start+3)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@else
							<h5><b>RKP  <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+3)])?$data['target_tahunan'][($tahun_start+3)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@endif

							<small>RPJMN {{$data['target_4']}} {{$data['satuan']}}</small>

						</td>
						<td>
							@if(($tahun_start+4)==$fokus_tahun)

							@if(in_array($data['cal_type'],['min_accept','max_accept','aggregate','aggregate_min']))
							<input type="number" name="target_tahunan[{{($tahun_start+4)}}]" class="form-control" value="{{!empty($data['target_tahunan'][($tahun_start+4)])?$data['target_tahunan'][($tahun_start+4)]['target']:''}}" placeholder="target..">

							@else
							<textarea class="form-control"  name="target_tahunan[{{($tahun_start+4)}}]" placeholder="target..">{!!nl4br(!empty($data['target_tahunan'][($tahun_start+4)])?$data['target_tahunan'][($tahun_start+4)]['target']:'')!!}</textarea>

							@endif
							<h5><b>RKP SEBELUMNYA <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+4)])?$data['target_tahunan'][($tahun_start+4)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@else

							<h5><b>RKP  <span class="val_check_type">
								{{!empty($data['target_tahunan'][($tahun_start+4)])?$data['target_tahunan'][($tahun_start+4)]['target']:''}} 
							</span> ({{$data['satuan']}})</b></h5>
							@endif

							<small>RPJMN {{$data['target_5']}} {{$data['satuan']}}</small>
						</td>
					</tr>
				</tbody>

			</table>
		</div>
		<div class="box-footer modal-footer">
			<button class="btn btn-warning btn-sm" type="submit">Update</button>
		</div>

		</form>
	</div>
	

@stop