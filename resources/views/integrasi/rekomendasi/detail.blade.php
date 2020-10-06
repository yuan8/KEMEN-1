@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>INTEGRASI {{$daerah['nama']}} {{Hp::fokus_tahun()+1}} </h3>
      </div>
      
    </div>
@stop

@section('content')
			@if($daerah['_rekomendasi_final'])

<div class="box box-solid {{$daerah['_rekomendasi_final']?'bg-light-blue-gradient':''}}">
	<div class="box-body ">

		<div class="text-white">
			<h5><b>REKOMENDASI {{Hp::fokus_urusan()['nama']}} - STATUS FINAL</b> - <span class="text-white">{{\Carbon\Carbon::parse($daerah['_rekomendasi_final']['created_at'])->format('d F Y')}}</span></h5>
		</div>
	</div>
</div>
		@endif


<div class="row">
	<div class="col-md-12">

	<div class="btn-group pull-right">
			@if($daerah['_rekomendasi_final'])
			<a href="" class="btn btn-success btn-xs text-uppercase">DOWNLOAD DATA</a>
			@endif
			
			@if(empty($daerah['_rekomendasi_final']))
				<button class="btn btn-success" onclick="showFormTambahProgram({{$daerah['id']}})">TAMBAH PROGRAM</button>
				<a href="javascript:void(0)" class="btn btn-primary  text-uppercase" onclick="showFormFinalisasi()">FINALISASI REKOMENDASI</a>
			@endif
		</div>
</div>
</div>

<hr>

<div class="table-responsive">
	<table class="table-bordered table-hover table bg-white">
	
	<tbody>
		@foreach($data as $p)
				@php $pn=$p['_nomen']; @endphp
				<tr class=" bg-info">
					
					
					<td style="min-width: 210px;" >
						<div class="">
						<p class="p-no-p"><b>URAIAN PROGRAM</b></p>
								
							</div>
					{{$pn['uraian']}}
					<hr style="margin:2px;">
					<div class=" btn-group">
							<button   collapse-btn-nested="false" data-target=".pn-{{$p['id']}}"  class="btn btn-info btn-xs ">
									<i data-toggle="tooltip" data-placement="top" title="DETAIL PROGRAM" class="fa fa-eye"></i> ({{count($p['_child_kegiatan'])}})
								</button>
							<button class="btn btn-success  btn-xs" onclick="showFormNested({{$p['id']}},{{$p['jenis']}})" >

							<i  data-toggle="tooltip" data-placement="top" title="TAMBAH KEGIATAN" class="fa fa-plus"></i></button>
							<button class="btn btn-danger  btn-xs" onclick="showFormDelete({{$p['id']}},{{$p['jenis']}})"><i class="fa fa-trash"></i></button>
							<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$p['id']}},{{$p['jenis']}})" >
							<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
						</div>
				</td>
				
				<td>
					<div>
						<p><b>MENDUKUNG PERMASALAHAN</b></p>
						<table class="table table-bordered">
							@foreach($p['_pendukung_masalah'] as $m)
							<tr>
								<td style="width: 60px; padding: 0px" class="text-center">
									<div class="btn btn-group-vertical" style="margin: 0px; padding: 5px;">
										<button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
										<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
									</div>
								</td>
								<td >
									
									<p> <span><b>{{$m['uraian']}}</b></span></p>
								</td>
							</tr>
							@endforeach
						</table>
						<hr style="margin: 2px">
						<div class="btn-group-vertical">
							<button onclick="tagging_permasalahan({{$daerah['id']}},{{$p['id']}},'{{route('api.int.integrasi.rekomendasi.tagging_list',['kodepemda'=>$daerah['id'],'jenis'=>'PERMASALAHAN'])}}','PERMASALAHAN')" class="btn-success btn-xs btn">Tagging</button>
						</div>
					</div>

				</td>
					<td>
					<div>
						<p><b>MENDUKUNG NSPK</b></p>
						<table class="table table-bordered">
							@foreach($p['_pendukung_nspk'] as $m)
							<tr>
								<td style="width: 60px; padding: 0px" class="text-center">
									<div class="btn btn-group-vertical" style="margin: 0px; padding: 5px;">
										<button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
										<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
									</div>
								</td>
								<td >
									
									<p> <span><b>{{$m['uraian']}}</b></span></p>
								</td>
							</tr>
							@endforeach
						</table>
						<hr style="margin: 2px">
						<div class="btn-group-vertical">
							<button onclick="tagging_permasalahan({{$daerah['id']}},{{$p['id']}},'{{route('api.int.integrasi.rekomendasi.tagging_list',['kodepemda'=>$daerah['id'],'jenis'=>'NSPK'])}}','NSPK')" class="btn-success btn-xs btn">Tagging</button>
						</div>
					</div>
					
				</td>
				<td>
					<div>
						<p><b>MENDUKUNG PP / MAJOR PROJECT</b></p>
						<table class="table table-bordered">
							@foreach($p['_pendukung_rkp'] as $m)
							<tr>
								<td style="width: 60px; padding: 0px" class="text-center">
									<div class="btn btn-group-vertical" style="margin: 0px; padding: 5px;">
										<button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
										<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
									</div>
								</td>
								<td >
									@if($m['jenis']==-1)
									<p class="text-primary">MAJOR PROJECT<b></b></p>
									@endif
									<p> <span><b>{{$m['uraian']}}</b></span></p>
								</td>
							</tr>
							@endforeach
						</table>
						<hr style="margin: 2px">
						<div class="btn-group-vertical">
							<button onclick="tagging_permasalahan({{$daerah['id']}},{{$p['id']}},'{{route('api.int.integrasi.rekomendasi.tagging_list',['kodepemda'=>$daerah['id'],'jenis'=>'RKP'])}}','RKP')" class="btn-success btn-xs btn">RKP</button>
						</div>
					</div>

				</td>
				<td>
					<div>
						<p><b>MENDUKUNG SPM</b></p>
						
					</div>

				</td>
				
					
				<td></td>
					


				</tr>

				@foreach($p['_tag_indikator'] as $pi)
					@php $pii=$pi['_indikator'];  @endphp
					<tr class="pn-{{$p['id']}} ">
						<td colspan="1"></td>
						
						<td style="min-width: 210px;">
							<p><b>INDIKATOR PROGRAM - {{strtoupper($pii['tipe'])}}</b></p>
							{{$pii['uraian']}}
							<hr style="margin: 2px;">
							<div class=" btn-group-vertical">
								<button   class="btn btn-info btn-xs " onclick="showFormDetailIndikator({{$pii['id']}})">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB INDIKATOR" class="fa fa-eye"></i>
								</button>
								
								<button class="btn btn-danger  btn-xs" onclick="showFormDeleteindikator({{$pi['id']}},{{$pi['jenis']}})"><i class="fa fa-trash"></i></button>
								
							</div>
							
						</td>
						<td>
							<p><b>TARGET PUSAT </b></p>

							@if(($pii['tipe_value']==1)OR($pii['tipe_value']==2))
							{{number_format($pii['target'],2)}}
							@else
								{{$pii['target']}}

							@endif

							@if($pii['tipe_value']==2)
								<br> -> 
								{{number_format($pii['target_1'],2)}}

							@endif
							{{$pii['satuan']}}
						</td>
						<td style="min-width: 170px;" class="{{empty($pi['target'])?'bg-danger':''}}">
							<div class="input-group">
								<label>TARGET DAERAH</label>
								@if(($pii['tipe_value']==1)OR($pii['tipe_value']==2))
								<input type="number" step="0.001"  name="" class="form-control" id="indikator-{{$pii['id']}}-{{$pi['id']}}-target"  value="{{$pi['target']}}">
								@else
								<input type="text"  name="" class="form-control" id="indikator-{{$pii['id']}}-{{$pi['id']}}-target" value="{{$pi['target']}}">

								@endif
								@if($pii['tipe_value']==2)
									<br> -> 
									<br><label>TARGET MAXIMUM</label> 
									<input type="number" step="0.001"  name="" class="form-control" id="indikator-{{$pii['id']}}-{{$pi['id']}}-target-1" value="{{$pi['targe_1']}}">


								@endif
							</div>

							<button style="margin-top: 5px" class="btn btn-xs btn-warning btn-xs" onclick="setTarget('indikator-{{$pii['id']}}-{{$pi['id']}}',{{$pi['id']}})">UPDATE TARGET DAERAH</button>
						</td>
						<td colspan="2"></td>
						

					</tr>

				@endforeach

				@foreach($p['_child_kegiatan'] as $k)
					@php $kn=$k['_nomen']; @endphp
					<tr class="pn-{{$p['id']}} bg-success">
						<td colspan="1" class="text-right">
							
						</td>
						
						<td  style="min-width: 210px;">
							<div class="">
								<p class="p-no-p"><b>URAIAN KEGIATAN</b></p>
								
							</div>			
							{{$kn['uraian']}}
							<hr style="margin: 2px;">
							<div class=" btn-group" >
								<button   collapse-btn-nested="false" data-target=".kn-{{$k['id']}}"  class="btn btn-info btn-xs ">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL KEGIATAN" class="fa fa-eye"></i> ({{count($k['_child_sub_kegiatan'])}})
									</button>
								<button class="btn btn-success  btn-xs" onclick="showFormNested({{$k['id']}},{{$k['jenis']}})" >

								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH SUB KEGIATAN" class="fa fa-plus"></i></button>
								<button class="btn btn-danger  btn-xs" onclick="showFormDelete({{$k['id']}},{{$k['jenis']}})"><i class="fa fa-trash"></i></button>
								<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$k['id']}},{{$k['jenis']}})" >
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
							</div>
						</td>
					<td>
					<div>
						<p><b>MENDUKUNG PERMASALAHAN</b></p>
						<table class="table table-bordered">
							@foreach($k['_pendukung_masalah'] as $m)
							<tr>
								<td style="width: 60px; padding: 0px" class="text-center">
									<div class="btn btn-group-vertical" style="margin: 0px; padding: 5px;">
										<button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
										<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
									</div>
								</td>
								<td >
									
									<p> <span><b>{{$m['uraian']}}</b></span></p>
								</td>
							</tr>
							@endforeach
						</table>
						<hr style="margin: 2px">
						<div class="btn-group-vertical">
							<button onclick="tagging_permasalahan({{$daerah['id']}},{{$k['id']}},'{{route('api.int.integrasi.rekomendasi.tagging_list',['kodepemda'=>$daerah['id'],'jenis'=>'PERMASALAHAN'])}}','PERMASALAHAN')" class="btn-success btn-xs btn">Tagging</button>
						</div>
					</div>

				</td>
					<td>
					<div>
						<p><b>MENDUKUNG NSPK</b></p>
						<table class="table table-bordered">
							@foreach($k['_pendukung_nspk'] as $m)
							<tr>
								<td style="width: 60px; padding: 0px" class="text-center">
									<div class="btn btn-group-vertical" style="margin: 0px; padding: 5px;">
										<button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
										<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
									</div>
								</td>
								<td >
									
									<p> <span><b>{{$m['uraian']}}</b></span></p>
								</td>
							</tr>
							@endforeach
						</table>
						<hr style="margin: 2px">
						<div class="btn-group-vertical">
							<button onclick="tagging_permasalahan({{$daerah['id']}},{{$k['id']}},'{{route('api.int.integrasi.rekomendasi.tagging_list',['kodepemda'=>$daerah['id'],'jenis'=>'NSPK'])}}','NSPK')" class="btn-success btn-xs btn">Tagging</button>
						</div>
					</div>
					
				</td>
				<td>
					<div>
						<p><b>MENDUKUNG PP / MAJOR PROJECT</b></p>
						<table class="table table-bordered">
							@foreach($k['_pendukung_rkp'] as $m)
							<tr>
								<td style="width: 60px; padding: 0px" class="text-center">
									<div class="btn btn-group-vertical" style="margin: 0px; padding: 5px;">
										<button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
										<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
									</div>
								</td>
								<td >
									@if($m['jenis']==-1)
									<p class="text-primary">MAJOR PROJECT<b></b></p>
									@endif
									<p> <span><b>{{$m['uraian']}}</b></span></p>
								</td>
							</tr>
							@endforeach
						</table>
						<hr style="margin: 2px">
						<div class="btn-group-vertical">
							<button onclick="tagging_permasalahan({{$daerah['id']}},{{$k['id']}},'{{route('api.int.integrasi.rekomendasi.tagging_list',['kodepemda'=>$daerah['id'],'jenis'=>'RKP'])}}','RKP')" class="btn-success btn-xs btn">RKP</button>
						</div>
					</div>

				</td>
				<td>
					<div>
						<p><b>MENDUKUNG SPM</b></p>
						
					</div>

				</td>
				
					
						




					</tr>
					@foreach($k['_tag_indikator'] as $ki)
						@php $kii=$ki['_indikator'];  @endphp
						<tr class="pn-{{$p['id']}} kn-{{$k['id']}}">
							<td colspan="2" class="text-right">
							
							</td>
							
							<td style="min-width: 210px;">
								<p><b>INDIKATOR KEGIATAN - {{strtoupper($kii['tipe'])}}</b></p>
								{{$kii['uraian']}}
								<hr style="margin: 2px;">
								<div class=" btn-group-vertical" >
									<button   class="btn btn-info btn-xs " onclick="showFormDetailIndikator({{$kii['id']}})">
											<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB INDIKATOR" class="fa fa-eye"></i>
									</button>
									
									<button class="btn btn-danger  btn-xs" onclick="showFormDeleteindikator({{$ki['id']}},{{$ki['jenis']}})"><i class="fa fa-trash"></i></button>
									
								</div>
							</td>
							<td>
								<p><b>TARGET PUSAT</b></p>

								@if(($kii['tipe_value']==1)OR($kii['tipe_value']==2))
								{{number_format($kii['target'],2)}}
								@else
									{{$kii['target']}}

								@endif

								@if($kii['tipe_value']==2)
									 -> 
									{{number_format($kii['target_1'],2)}}

								@endif
									
								{{$kii['satuan']}}	
							</td>
							<td style="min-width: 170px;" class="{{empty($ki['target'])?'bg-danger':''}}">
								<div class="input-group">
									<label>TARGET DAERAH</label>
									@if(($kii['tipe_value']==1)OR($kii['tipe_value']==2))
									<input type="number" step="0.001"  name="" class="form-control" id="indikator-{{$kii['id']}}-{{$ki['id']}}-target" value="{{$ki['target']}}">
									@else
									<input type="text"  name="" class="form-control" id="indikator-{{$kii['id']}}-{{$ki['id']}}-target" value="{{$ki['target']}}">

									@endif
									@if($kii['tipe_value']==2)
										<br> -> 
										<br><label>TARGET MAXIMUM</label> 
									<input type="number" step="0.001"  name="" class="form-control" id="indikator-{{$kii['id']}}-{{$ki['id']}}-target-1" value="{{$ki['target_1']}}">

									@endif
								</div>

									<button style="margin-top: 5px;" class="btn btn-xs btn-warning btn-xs" onclick="setTarget('indikator-{{$kii['id']}}-{{$ki['id']}}',{{$ki['id']}})">UPDATE TARGET DAERAH</button>
							</td>
							<td></td>
							

						</tr>

					@endforeach

					@foreach($k['_child_sub_kegiatan'] as $s)
						@php $sn=$s['_nomen']; @endphp
						<tr class="pn-{{$p['id']}} kn-{{$k['id']}} bg-warning">
							<td colspan="2" class="text-right">
									
							</td>
							
							
							<td  style="min-width: 210px;">
								<div class="">
									<p><b>URAIAN SUBKEGIATAN</b></p>
									
									<p><b>{{$sn['kode']}}</b></p>
								</div>
							{{$sn['uraian']}}
							<hr style="margin: 2px;">
							<div class=" btn-group" >
									<button   collapse-btn-nested="false" data-target=".sn-{{$s['id']}}"  class="btn btn-info btn-xs ">
											<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB KEGIATAN" class="fa fa-eye"></i>  ({{count($s['_tag_indikator'])}})
										</button>
									
									<button class="btn btn-danger  btn-xs" onclick="showFormDelete({{$s['id']}},{{$s['jenis']}})"><i class="fa fa-trash"></i></button>
									<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$s['id']}},{{$s['jenis']}})" >
									<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
								</div>
						</td>
						<td colspan="3"></td>

						</tr>

						@foreach($s['_tag_indikator'] as $si)
						@php $sii=$si['_indikator'];  @endphp
						<tr class="pn-{{$p['id']}} kn-{{$k['id']}} sn-{{$s['id']}}">
							<td colspan="3"></td>
							
							<td style="min-width: 210px;">
								<p><b>INDIKATOR SUBKEGIATAN - {{strtoupper($sii['tipe'])}}</b></p>
							{{$sii['uraian']}}
							<hr style="margin: 2px;">
							<div class="btn-group-vertical">

									<button   class="btn btn-info btn-xs " onclick="showFormDetailIndikator({{$sii['id']}})">
											<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB INDIKATOR" class="fa fa-eye"></i>
									</button>
									
									<button class="btn btn-danger  btn-xs" onclick="showFormDeleteindikator({{$si['id']}},{{$si['jenis']}})"><i class="fa fa-trash"></i></button>
									
							</div>
							</td>

							<td>
							<p><b>TARGET PUSAT</b></p>
								@if(($sii['tipe_value']==1)OR($sii['tipe_value']==2))
								{{number_format($sii['target'],2)}}
								@else
									{{$sii['target']}}


								@endif

								@if($sii['tipe_value']==2)
									 -> 
									{{number_format($sii['target_1'],2)}}

								@endif

								{{$sii['satuan']}}
									
							</td>
							<td style="min-width: 170px;" class="{{empty($si['target'])?'bg-danger':''}}">
								<div class="input-group">
									<label>TARGET DAERAH</label>
									@if(($sii['tipe_value']==1)OR($sii['tipe_value']==2))
									<input type="number" step="0.001"  name="" class="form-control" id="indikator-{{$sii['id']}}-{{$si['id']}}-target" value="{{$si['target']}}">
									@else
									<input type="text"  name="" class="form-control" id="indikator-{{$sii['id']}}-{{$si['id']}}-target" value="{{$si['target']}}">

									@endif
									@if($sii['tipe_value']==2)
										<br> -> 
										<br><label>TARGET MAXIMUM</label> 
									<input type="number" step="0.001"  name="" class="form-control" id="indikator-{{$sii['id']}}-{{$si['id']}}-target-1" value="{{$si['target_1']}}">

									@endif

									<button style="margin-top: 5px;" class="btn btn-xs btn-warning btn-xs" onclick="setTarget('indikator-{{$sii['id']}}-{{$si['id']}}',{{$si['id']}})">UPDATE TARGET DAERAH</button>
								</div>
							</td>
							

						</tr>

					@endforeach


					@endforeach

				@endforeach

			@endforeach 

		



	</tbody>
	<thead class="bg-navy">
		<tr>
			<th colspan="10"><b>REKOMENDASI PROGRAM KEGIATAN {{$daerah['nama']}} - {{Hp::fokus_tahun()+1}}</b></th>
		</tr>
		{{-- <tr>
			<th rowspan="2" colspan="1">PROGRAM</th>
			<th rowspan="2" colspan="1">KEGIATAN</th>
			<th rowspan="2" colspan="2">SUB KEGIATAN</th>
			<th colspan="4">INDIKATOR</th>
			<th rowspan="2">ACTION</th>
		</tr>
		<tr>
			<th colspan="">URAIAN</th>
			<th>TARGET PUSAT</th>
			<th>TARGET DAERAH</th>
			<th>SATUAN</th>
		</tr> --}}

	</thead>
</table>
</div>
@stop

@section('js')
<script type="text/javascript">
	

	function showFormTambahProgram(id,id_rkp){

		API_CON.get("{{route('int.rekomendasi.add_program',['id'=>null])}}/"+id+'/'+id_rkp).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH PROGRAM {{Hp::fokus_tahun()+1}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormNested(nomen,jenis){
		var id="{{$daerah['id']}}";
		API_CON.get("{{route('int.rekomendasi.nestedCreate',['id'=>null])}}/"+id+'/'+nomen+'/'+jenis).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH KEGIATAN {{Hp::fokus_tahun()+1}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});

	}

	function showFormCreateIndikator(nomen,jenis){
		var id="{{$daerah['id']}}";
		API_CON.get("{{route('int.rekomendasi.add_indikator',['id'=>null])}}/"+id+'/'+nomen+'/'+jenis).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR {{Hp::fokus_tahun()+1}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});


	}


	function showFormDetailIndikator(id){

		API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormDelete(nomen,jenis){
		var id="{{$daerah['id']}}";
		API_CON.get("{{route('int.rekomendasi.delete_form_nest',['id'=>null])}}/"+id+'/'+nomen+'/'+jenis).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DELETE uraian {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormDeleteindikator(nomen,jenis){
		var id="{{$daerah['id']}}";
		API_CON.get("{{route('int.rekomendasi.delete_form_indikator',['id'=>null])}}/"+id+'/'+nomen).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DELETE INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}


	function showFormFinalisasi(){
		var id="{{$daerah['id']}}";
		API_CON.get("{{route('int.rekomendasi.form_final',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('FINALISASI REKOMENDASI {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}




  function setTarget(id_dom,id_indikator){
    var data={
      'target_1':$('#'+id_dom+'-target-1').val(),
      'target':$('#'+id_dom+'-target').val(),
    };

    API_CON.post("{{route('api.int.daerah.set.target',['kodepemda'=>$daerah['id'],'id_indikator'=>''])}}/"+id_indikator,data).then(function(res){
      if(res.data.code==200){
        Swal.fire(
          'Success',
          'Berhasil Menambahkan Target',
          'success'
        );
                
      }

    }); 
  }


  function tagging_permasalahan(kodepemda,idrekom,url,jenis){
	var kodepemda="{{$daerah['id']}}";
		API_CON.get(url+'?&idrekom='+idrekom).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAGGING '+jenis+' {{$daerah['nama']}} {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
  	
  }

   



// api.int.daerah.set.target
</script>

@stop