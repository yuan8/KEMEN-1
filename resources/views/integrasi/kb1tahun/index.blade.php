@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN ({{Hp::fokus_tahun()}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<div class="box box-solid 	">
	<div class="box-body ">

		<button onclick="showFormCreatePn()" class="btn btn-primary btn-xs text-uppercase">TAMBAH PN</button>
		<a href="" class="btn btn-success btn-xs text-uppercase">DWONLOAD DATA</a>

	</div>
</div>
<hr>

<table class="table-bordered table bg-white">
	<thead class="bg-navy">
		<tr>
			<th rowspan="2"></th>
			<th rowspan="2" >PN</th>
			<th rowspan="2">PP</th>
			<th rowspan="2">KP</th>
			<th rowspan="2">PROPN</th>
			<th rowspan="2">PROYEK KL</th>
			<th colspan="4">INDIKATOR</th>
			<th rowspan="2">LOKUS</th>
			<th rowspan="2">PELAKSANA</th>

		</tr>
		<tr>
			<th>KODE</th>
			<th>URAIAN</th>
			<th>TARGET</th>
			<th>SATUAN</th>
		</tr>

	</thead>
	<tbody>
		@foreach($data as $pn)
			<tr>
				<td >
					<div class=" pull-right">
						<button   collapse-btn-nested="false" data-target=".pn-{{$pn['id']}}"  class="btn btn-info btn-xs ">
								<i data-toggle="tooltip" data-placement="top" title="DETAIL SASARAN" class="fa fa-eye"></i>
							 ({{count($pn['_child_pp'])}})</button>
						<button class="btn btn-success  btn-xs" onclick="showFormNested({{$pn['id']}},{{$pn['jenis']}})" >

						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH PP" class="fa fa-plus"></i></button>
						<button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$pn['id']}},{{$pn['jenis']}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$pn['id']}},{{$pn['jenis']}})"><i class="fa fa-trash"></i></button>
						<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$pn['id']}},{{$pn['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
					</div>
				</td>
				<td colspan="11">{{$pn['uraian']}}</td>

			</tr>
			@foreach($pn['_tag_indikator'] as $tagpni)
					@php
						$pni=$tagpni['_indikator'];
					@endphp
					<tr class="pn-{{$pn['id']}}">

					<td colspan="5"></td>
					<td>
						<div class="form-group pull-right">
							<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$pni['id']}})"><i class="fa fa-eye"></i></button>
							<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagpni['id']}},{{$pni['jenis']}})"><i class="fa fa-trash"></i></button>
						</div>
					</td>
					<td><b>{{$pni['kode']}}</b></td>
					<td>{{$pni['uraian']}}</td>
					<td>
						@if(($pni['tipe_value']==1)OR($pni['tipe_value']==2))
						{{number_format($pni['target'],2)}}
						@else
							{{$pni['target']}}

						@endif

						@if($pni['tipe_value']==2)
							<-> {{number_format($pni['target_1'],2)}}

						@endif
							
					</td>
					<td>{{$pni['satuan']}}</td>
					<td>
						{!!$pni['lokus']!!}
					</td>
					<td>
						@php
							$pelaksana=[];
							preg_match_all("/@\w+/",$pni['pelaksana'],$pelaksana);
						
						@endphp
						@foreach($pelaksana[0] as $idexmacth=> $p)
							<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

						@endforeach
					</td>

			</tr>

			@endforeach
			@foreach($pn['_child_pp'] as $pp)
				<tr class="pn-{{$pn['id']}}">
					<td colspan="2">
							<div class=" pull-right">
							<button   collapse-btn-nested="false" data-target=".pp-{{$pp['id']}}"  class="btn btn-info btn-xs ">
									<i data-toggle="tooltip" data-placement="top" title="DETAIL PP" class="fa fa-eye"></i>
								 ({{count($pp['_child_kp'])}})</button>
								 <button class="btn btn-success  btn-xs" onclick="showFormNested({{$pp['id']}},{{$pp['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH KP" class="fa fa-plus"></i></button>
						  <button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$pp['id']}},{{$pp['jenis']}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$pp['id']}},{{$pp['jenis']}})"><i class="fa fa-trash"></i></button>
						<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$pp['id']}},{{$pp['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
						</div>
					</td>
					<td colspan="10">{{$pp['uraian']}}</td>

				</tr>
				@foreach($pp['_tag_indikator'] as $tagppi)
					<tr class="pp-{{$pp['id']}} pn-{{$pn['id']}} ">	
						@php
							$ppi=$tagppi['_indikator'];
						@endphp

						<td colspan="5"></td>
						<td>
							<div class="form-group pull-right">
								<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$ppi['id']}})"><i class="fa fa-eye"></i></button>
								<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagppi['id']}},{{$ppi['jenis']}})"><i class="fa fa-trash"></i></button>
							</div>

						</td>
						<td><b>{{$ppi['kode']}}</b></td>
						<td>{{$ppi['uraian']}}</td>
						<td>
							@if(($ppi['tipe_value']==1)OR($ppi['tipe_value']==2))
							{{number_format($ppi['target'],2)}}
							@else
								{{$ppi['target']}}

							@endif

							@if($ppi['tipe_value']==2)
								<-> {{number_format($ppi['target_1'],2)}}

							@endif
								
						</td>
						<td>{{$ppi['satuan']}}</td>
						<td>
							{!!$ppi['lokus']!!}
						</td>
						<td>
							@php
								$pelaksana=[];
								preg_match_all("/@\w+/",$ppi['pelaksana'],$pelaksana);
							
							@endphp
							@foreach($pelaksana[0] as $idexmacth=> $p)
								<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

							@endforeach
						</td>

					</tr>

				@endforeach

				@foreach($pp['_child_kp'] as $kp)
					<tr class="pp-{{$pp['id']}} pn-{{$pn['id']}}">
						<td colspan="3">
								<div class=" pull-right">
								<button   collapse-btn-nested="false" data-target=".kp-{{$kp['id']}}"  class="btn btn-info btn-xs ">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL KP" class="fa fa-eye"></i>
									 ({{count($kp['_child_propn'])}})</button>
									  <button class="btn btn-success  btn-xs" onclick="showFormNested({{$kp['id']}},{{$kp['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH KP" class="fa fa-plus"></i></button>
								  <button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$kp['id']}},{{$kp['jenis']}})"><i class="fa fa-pen"></i></button>
								<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$kp['id']}},{{$kp['jenis']}})"><i class="fa fa-trash"></i></button>
								<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$kp['id']}},{{$kp['jenis']}})" >
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
							</div>
						</td>
						<td colspan="9">{{$kp['uraian']}}</td>

					</tr>
					@foreach($kp['_tag_indikator'] as $tagkpi)
					<tr class=" kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}}">
						@php
							$kpi=$tagkpi['_indikator'];
						@endphp
						<td colspan="5"></td>
						<td>
							<div class="form-group pull-right">
								<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$kpi['id']}})"><i class="fa fa-eye"></i></button>
								<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagkpi['id']}},{{$kpi['jenis']}})"><i class="fa fa-trash"></i></button>
							</div>

						</td>
						<td><b>{{$kpi['kode']}}</b></td>
						<td>{{$kpi['uraian']}}</td>
						<td>
							@if(($kpi['tipe_value']==1)OR($kpi['tipe_value']==2))
							{{number_format($kpi['target'],2)}}
							@else
								{{$kpi['target']}}

							@endif

							@if($kpi['tipe_value']==2)
								<-> {{number_format($kpi['target_1'],2)}}

							@endif
								
						</td>
						<td>{{$kpi['satuan']}}</td>
						<td>
							{!!$kpi['lokus']!!}
						</td>
						<td>
							@php
								$pelaksana=[];
								preg_match_all("/@\w+/",$kpi['pelaksana'],$pelaksana);
							
							@endphp
							@foreach($pelaksana[0] as $idexmacth=> $p)
								<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

							@endforeach
						</td>


					</tr>

					@endforeach
					@foreach($kp['_child_propn'] as $propn)
						<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}}">
							<td colspan="4">
												<div class=" pull-right">
										<button   collapse-btn-nested="false" data-target=".propn-{{$propn['id']}}"  class="btn btn-info btn-xs ">
												<i data-toggle="tooltip" data-placement="top" title="DETAIL PROPN" class="fa fa-eye"></i>  ({{count($propn['_child_proyek'])}})
											 </button>
											   <button class="btn btn-success  btn-xs" onclick="showFormNested({{$propn['id']}},{{$propn['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH KP" class="fa fa-plus"></i></button>
									  	<button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$propn['id']}},{{$propn['jenis']}})"><i class="fa fa-pen"></i></button>
										<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$propn['id']}},{{$propn['jenis']}})"><i class="fa fa-trash"></i></button>
										<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$propn['id']}},{{$propn['jenis']}})" >
										<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
									</div>
								</td>
							<td colspan="8">{{$propn['uraian']}}</td>

						</tr>

						@foreach($propn['_tag_indikator'] as $tagpropni)
							<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}}">
								@php
									$propni=$tagpropni['_indikator'];
								@endphp

								<td colspan="5"></td>
									<td>
									<div class="form-group pull-right">
										<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$propni['id']}})"><i class="fa fa-eye"></i></button>
										<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagpropni['id']}},{{$propni['jenis']}})"><i class="fa fa-trash"></i></button>

									</div>

								</td>
								<td><b>{{$propni['kode']}}</b></td>
								<td>{{$propni['uraian']}}</td>
								<td>
									@if(($propni['tipe_value']==1)OR($propni['tipe_value']==2))
									{{number_format($propni['target'],2)}}
									@else
										{{$propni['target']}}

									@endif

									@if($propni['tipe_value']==2)
										<-> {{number_format($propni['target_1'],2)}}

									@endif
										
								</td>
								<td>{{$propni['satuan']}}</td>
								<td>
									{!!$propni['lokus']!!}
								</td>
								<td>
									@php
										$pelaksana=[];
										preg_match_all("/@\w+/",$propni['pelaksana'],$pelaksana);
									
									@endphp
									@foreach($pelaksana[0] as $idexmacth=> $p)
										<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

									@endforeach
								</td>




							</tr>

						@endforeach
						@foreach($propn['_child_proyek'] as $proyek)
							<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}}">
								<td colspan="5">
									<div class=" pull-right">
										<button   collapse-btn-nested="false" data-target=".proyek-{{$proyek['id']}}"  class="btn btn-info btn-xs ">
												<i data-toggle="tooltip" data-placement="top" title="DETAIL PROYEK" class="fa fa-eye"></i> ({{count($propn['_child_proyek'])}})
											</button>
											<button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$proyek['id']}},{{$proyek['jenis']}})"><i class="fa fa-pen"></i></button>
										<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$proyek['id']}},{{$proyek['jenis']}})"><i class="fa fa-trash"></i></button>
										<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$proyek['id']}},{{$proyek['jenis']}})" >
										<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
									</div>
								</td>

								<td>{{$proyek['uraian']}}</td>

							</tr>
							@foreach($proyek['_tag_indikator'] as $tagproyeki)
								<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}} proyek-{{$proyek['id']}}">
									@php
										$proyeki=$tagproyeki['_indikator'];
									@endphp

									<td colspan="5"></td>
									<td>
										<div class="form-group pull-right">
											<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$proyeki['id']}})"><i class="fa fa-eye"></i></button>
											<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagproyeki['id']}},{{$proyeki['jenis']}})"><i class="fa fa-trash"></i></button>
											
										</div>
									</td> 
									<td><b>{{$proyeki['kode']}}</b></td>
									<td>{{$proyeki['uraian']}}</td>
									<td>
										@if(($proyeki['tipe_value']==1)OR($proyeki['tipe_value']==2))
										{{number_format($proyeki['target'],2)}}
										@else
											{{$proyeki['target']}}

										@endif

										@if($proyeki['tipe_value']==2)
											<-> {{number_format($proyeki['target_1'],2)}}

										@endif

									</td>
									<td>{{$proyeki['satuan']}}</td>
									<td>
										{!!$proyeki['lokus']!!}
									</td>
									<td>
										@php
											$pelaksana=[];
											preg_match_all("/@\w+/",$proyeki['pelaksana'],$pelaksana);
										
										@endphp
										@foreach($pelaksana[0] as $idexmacth=> $p)
											<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

										@endforeach
									</td>


								</tr>

							@endforeach

						@endforeach


					@endforeach

				@endforeach

			@endforeach

		@endforeach
	</tbody>
</table>

@stop

@section('js')

<script type="text/javascript">

	function nameRKP(jenis){
		switch(jenis){
			case 1:
				jenis='PN';
			break;
			case 2:
				jenis='PP';
			break;
			case 3:
				jenis='KP';
			break;
			case 4:
				jenis='PROPN';
			break;
			case 5:
				jenis='PTOYEK';
			break;
		}

		return jenis;
	}
	
	function showFormDetailIndikator(id){

		API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormCreatePn(){
		API_CON.get("{{route('int.kb1tahun.pn_create')}}").then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH PN {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormViewPn(id,jenis=null){
		API_CON.get("{{route('int.kb1tahun.pn_view',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('UBAH '+nameRKP(jenis)+' {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormDeletePn(id,jenis=null){
		API_CON.get("{{route('int.kb1tahun.pn_form_delete',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DELETE '+nameRKP(jenis)+' {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}
	
	function showFormCreatePnIndikator(id,jenis=null){
		API_CON.get("{{route('int.kb1tahun.pn_indikator',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR '+nameRKP(jenis)+' {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormNested(id,jenis){
		API_CON.get("{{route('int.kb1tahun.nested_create',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH  '+nameRKP(jenis+1)+' {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}


	function showFormDetailDeleteIndikator(id,jenis){
		API_CON.get("{{route('int.kb1tahun.indikator_form_delete',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('HAPUS INDIKATOR  '+nameRKP(jenis+1)+' {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}
</script>

@stop