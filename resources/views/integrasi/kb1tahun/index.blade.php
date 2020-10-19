@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN ({{Hp::fokus_tahun()}})</h3>

    	</div>

    </div>
    <style media="screen">
      tr .btn-group{
        display: none;
      }

      tr:hover .btn-group{
        display: block;
      }
    </style>
@stop


@section('content')
<div class="box box-solid 	">
	<div class="box-body ">

		<div class="btn-group">
			<button onclick="showFormCreatePn()" class="btn btn-primary text-uppercase">TAMBAH PN</button>
			<button onclick="showFormCreatePn('MAJOR')" class="btn btn-info  text-uppercase">TAMBAH MAJOR PROJECT</button>

		<a href="{{route('int.kb1tahun.download',['pdf'=>'true'])}}" class="btn btn-success text-uppercase">DOWNLOAD DATA</a>
		</div>

	</div>
</div>
<hr>

<div class="table-responsive">
	<table class=" table-bordered  table bg-white table-hover">
	{{-- <thead class="bg-navy">
		<tr>
			<th rowspan="2" colspan="2"></th>
			<th rowspan="2" >PN / MAJOR PROJECT</th>
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

	</thead> --}}
	<tbody>
		@foreach($data as $pn)
			@php
			$pnrowspan=0;

			@endphp
			<tr >

				<td rowspan="{{$pn['_rowspan']['rowspan']+1}}" style="min-width:180px;" >

					<div class=" btn-group ">

						<button   collapse-btn-nested="false" data-target=".pn-{{$pn['id']}}"  class="btn btn-info btn-xs ">
								<i data-toggle="tooltip" data-placement="top" title="DETAIL PP" class="fa fa-eye"> </i> </button>
					@if($pn['jenis']!=-1)

						<button class="btn btn-success  btn-xs" onclick="showFormNested({{$pn['id']}},{{$pn['jenis']}})" >

						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH PP" class="fa fa-plus"></i> PP</button>

					@endif
						<button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$pn['id']}},{{$pn['jenis']}})"><i class="fa fa-pen"></i> PN</button>
						<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$pn['id']}},{{$pn['jenis']}})"><i class="fa fa-trash"></i> PN</button>

					@if($pn['jenis']==-1)
					<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$pn['id']}},{{$pn['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i>

					</button>

					@endif
					</div>
					<hr>
					<b>{{($pn['jenis']==-1?'MAJOR PROJECT':'PN')}}: </b>{{$pn['uraian']}}</td>
					<td colspan="9" class="bg-grey">
						{!!count($pn['_tag_indikator'])?
						'<small  class="text-center"><b>INDIKATOR MAJOR PROJECT</b></small>':'<small  class="text-center"><b>TURUNAN PROGRAM PRIORITAS</b></small>'!!}
					</td>

			</tr>
			@foreach($pn['_tag_indikator'] as $tagpni)
					@php
						$pni=$tagpni['_indikator'];
					@endphp
					<tr class="pn-{{$pn['id']}} bg-success">


					<td>
						<div class="btn-group ">
							<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$pni['id']}})"><i class="fa fa-eye"></i></button>
							<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagpni['id']}},{{$pni['jenis']}})"><i class="fa fa-trash"></i></button>
						</div>
						<hr>
						<b>{{$pni['kode']}}</b>
					</td>
					<td style="min-width:180px;" >
							<p>	<b>{{strtoupper($pni['tipe'])}}</b></p>

					{{$pni['uraian']}}</td>
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
								$i=$pni;
								$i['pelaksana_nas']=json_decode($pni['pelaksana_nas']);
								$i['pelaksana_p']=json_decode($pni['pelaksana_p']);
								$i['pelaksana_k']=json_decode($pni['pelaksana_k']);
							@endphp
							<b>PUSAT</b>
							<ul>
							@foreach($i['pelaksana_nas'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
							<b>PROVINSI</b>
							<ul>
							@foreach($i['pelaksana_p'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
							<b>KOTA/KAB</b>
							<ul>
							@foreach($i['pelaksana_k'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>

						</td>
					<td colspan="3"></td>

			</tr>

			@endforeach
			@foreach($pn['_child_pp'] as $pp)
				<tr class="pn-{{$pn['id']}}">
					<td rowspan="{{$pp['_rowspan']['rowspan']+1}}">
						<div class=" btn-group ">
							<button   collapse-btn-nested="false" data-target=".pp-{{$pp['id']}}"  class="btn btn-info btn-xs ">
									<i data-toggle="tooltip" data-placement="top" title="DETAIL PP" class="fa fa-eye"></i>
								 </button>
								 <button class="btn btn-success  btn-xs" onclick="showFormNested({{$pp['id']}},{{$pp['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH KP" class="fa fa-plus"></i> KP</button>
						  <button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$pp['id']}},{{$pp['jenis']}})"><i class="fa fa-pen"></i> PP</button>
						<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$pp['id']}},{{$pp['jenis']}})"><i class="fa fa-trash"></i> PP</button>
						<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$pp['id']}},{{$pp['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> IND PP</button>
						</div>
						<hr>
						<b>PP: </b>{{$pp['uraian']}}</td>
						<td colspan="8" class="bg-grey">
							{!!count($pp['_tag_indikator'])?
						'<small  class="text-center"><b>INDIKATOR PROGRAM PRIORITAS</b></small>':''!!}
						</td>
				</tr>
				@foreach($pp['_tag_indikator'] as $tagppi)
					<tr class="pp-{{$pp['id']}} pn-{{$pn['id']}} bg-success">
						@php
							$ppi=$tagppi['_indikator'];
						@endphp

						<td>
							<div class="btn-group ">
								<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$ppi['id']}})"><i class="fa fa-eye"></i></button>
								<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagppi['id']}},{{$ppi['jenis']}})"><i class="fa fa-trash"></i></button>
							</div>
							<hr>
							<b>
							{{$ppi['kode']}}</b></td>
						<td>

							<p>	<b>{{strtoupper($ppi['tipe'])}}</b></p>
						{{$ppi['uraian']}}
					</td>
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
								$i=$ppi->toArray();
								$i['pelaksana_nas']=json_decode($ppi['pelaksana_nas']);

								$i['pelaksana_p']=json_decode($ppi['pelaksana_p']);
								$i['pelaksana_k']=json_decode($ppi['pelaksana_k']);
							@endphp
							@if($i['kw_nas'])
									<b>PUSAT</b>
									<ul>
									@foreach($i['pelaksana_nas'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									@endif
									@if($i['kw_p'])

									<b>PROVINSI</b>
									<ul>
									@foreach($i['pelaksana_p'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									@endif
									@if($i['kw_k'])

									<b>KOTA/KAB</b>
									<ul>
									@foreach($i['pelaksana_k'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									@endif
						</td>
						<td colspan="2"></td>

					</tr>

				@endforeach

				@foreach($pp['_child_kp'] as $kp)
				<tr class="pp-{{$pp['id']}} pn-{{$pn['id']}}">



						<td  rowspan="{{$kp['_rowspan']['rowspan']+1}}">
							<div class=" btn-group">
								<button   collapse-btn-nested="false" data-target=".kp-{{$kp['id']}}"  class="btn btn-info btn-xs ">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL KP" class="fa fa-eye"></i>
									</button>
									  <button class="btn btn-success  btn-xs" onclick="showFormNested({{$kp['id']}},{{$kp['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH PROPN" class="fa fa-plus"></i> PROPN</button>
								  <button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$kp['id']}},{{$kp['jenis']}})"><i class="fa fa-pen"></i> KP</button>
								<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$kp['id']}},{{$kp['jenis']}})"><i class="fa fa-trash"></i> KP</button>
								<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$kp['id']}},{{$kp['jenis']}})" >
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> IND KP</button>
							</div>
							<hr>
							<b>KP: </b>{{$kp['uraian']}}</td>
						<td colspan="7" class="bg-grey">
							{!!COUNT($kp['_tag_indikator'])?'<small><b>INDIKATOR KEGIATAN PRIORITAS</b></small>':''!!}
						</td>

					</tr>
					@foreach($kp['_tag_indikator'] as $tagkpi)
						<tr class=" kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} bg-success">
							@php
								$kpi=$tagkpi['_indikator'];
							@endphp

							<td>
								<div class="btn-group ">
									<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$kpi['id']}})"><i class="fa fa-eye"></i></button>
									<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagkpi['id']}},{{$kpi['jenis']}})"><i class="fa fa-trash"></i></button>
								</div>
								<hr>
								<b>{{$kpi['kode']}}</b></td>
							<td>
							<p>	<b>{{strtoupper($kpi['tipe'])}}</b></p>

							{{$kpi['uraian']}}</td>
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
									$i=$kpi;
									$i['pelaksana_nas']=json_decode($kpi['pelaksana_nas']);
									$i['pelaksana_p']=json_decode($kpi['pelaksana_p']);
									$i['pelaksana_k']=json_decode($kpi['pelaksana_k']);
								@endphp
								@if($i['kw_nas'])
									<b>PUSAT</b>
									<ul>
									@foreach($i['pelaksana_nas'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
								@endif
								@if($i['kw_p'])

								<b>PROVINSI</b>
								<ul>
								@foreach($i['pelaksana_p'] as $p)
									<li>{{$p}}</li>
								@endforeach
								</ul>
								@endif
								@if($i['kw_k'])

								<b>KOTA/KAB</b>
								<ul>
								@foreach($i['pelaksana_k'] as $p)
									<li>{{$p}}</li>
								@endforeach
								</ul>
								@endif


							</td>


						</tr>

					@endforeach
					@foreach($kp['_child_propn'] as $propn)
						<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}}">




							<td colspan="" rowspan="{{$propn['_rowspan']['rowspan']+1}}">
								<div class=" btn-group">
										<button   collapse-btn-nested="false" data-target=".propn-{{$propn['id']}}"  class="btn btn-info btn-xs ">
												<i data-toggle="tooltip" data-placement="top" title="DETAIL PROPN" class="fa fa-eye"></i>
											 </button>
											   <button class="btn btn-success  btn-xs" onclick="showFormNested({{$propn['id']}},{{$propn['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH PROYEK KL" class="fa fa-plus"></i> PROYEK KL</button>
									  	<button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$propn['id']}},{{$propn['jenis']}})"><i class="fa fa-pen"></i> PROPN</button>
										<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$propn['id']}},{{$propn['jenis']}})"><i class="fa fa-trash"></i> PROPN</button>
										<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$propn['id']}},{{$propn['jenis']}})" >
										<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> IND PROPN</button>
									</div>
								<hr>
								<b>PROPN: </b>{{$propn['uraian']}}
							</td>
							<td colspan="6">
								{!!COUNT($propn['_tag_indikator'])?'<small><b>INDIKATOR PROYEK PRIORITAS</b></small>':''!!}
							</td>

						</tr>

						@foreach($propn['_tag_indikator'] as $tagpropni)
							<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}} bg-success">
								@php
									$propni=$tagpropni['_indikator'];
								@endphp


								<td>
									<div class="btn-group">
										<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$propni['id']}})"><i class="fa fa-eye"></i></button>
										<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagpropni['id']}},{{$propni['jenis']}})"><i class="fa fa-trash"></i></button>

									</div>
									<hr>
									<b>{{$propni['kode']}}</b></td>
								<td>
							<p>	<b>{{strtoupper($propni['tipe'])}}</b></p>

								{{$propni['uraian']}}</td>
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
									@php
									$i=$propni;
									$i['pelaksana_nas']=json_decode($propni['pelaksana_nas']);
									$i['pelaksana_p']=json_decode($propni['pelaksana_p']);
									$i['pelaksana_k']=json_decode($propni['pelaksana_k']);
									@endphp
									<b>PUSAT</b>
									<ul>
									@foreach($i['pelaksana_nas'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									<b>PROVINSI</b>
									<ul>
									@foreach($i['pelaksana_p'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									<b>KOTA/KAB</b>
									<ul>
									@foreach($i['pelaksana_k'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>

								</td>




							</tr>

						@endforeach
						@foreach($propn['_child_proyek'] as $proyek)
							<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}}">

								<td rowspan="{{$proyek['_rowspan']['rowspan']+1}} class="bg-warning" >
									<div class=" btn-group ">
										<button   collapse-btn-nested="false" data-target=".proyek-{{$proyek['id']}}"  class="btn btn-info btn-xs ">
												<i data-toggle="tooltip" data-placement="top" title="DETAIL PROYEK" class="fa fa-eye"></i> ({{count($propn['_child_proyek'])}})
											</button>
											<button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$proyek['id']}},{{$proyek['jenis']}})"><i class="fa fa-pen"></i></button>
										<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$proyek['id']}},{{$proyek['jenis']}})"><i class="fa fa-trash"></i></button>
										<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$proyek['id']}},{{$proyek['jenis']}})" >
										<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
									</div>
									<hr>
								<b>PROYEK: </b>{{$proyek['uraian']}}

								</td>
								<td colspan="6">
									{!!count($proyek['_tag_indikator'])?
									'<small  class="text-center"><b>INDIKATOR PROYEK KL</b></small>':''!!}
								</td>



							</tr>
							@foreach($proyek['_tag_indikator'] as $tagproyeki)
								<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}} proyek-{{$proyek['id']}} ">
									@php
										$proyeki=$tagproyeki['_indikator'];
									@endphp

									<td class="bg-warning">
										<div class="form-group">
											<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$proyeki['id']}})"><i class="fa fa-eye"></i></button>
											<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagproyeki['id']}},{{$proyeki['jenis']}})"><i class="fa fa-trash"></i></button>

										</div>
										<hr>
										<b>{{$proyeki['kode']}}</b>
									</td>

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
											$i=$proyeki;
											$i['pelaksana_nas']=json_decode($proyeki['pelaksana_nas']);
											$i['pelaksana_p']=json_decode($proyeki['pelaksana_p']);
											$i['pelaksana_k']=json_decode($proyeki['pelaksana_k']);
										@endphp

										@if($i['kw_nas'])
										<b>PUSAT</b>
										<ul>
										@foreach($i['pelaksana_nas'] as $p)
											<li>{{$p}}</li>
										@endforeach
										</ul>
										@endif
										@if($i['kw_p'])

										<b>PROVINSI</b>
										<ul>
										@foreach($i['pelaksana_p'] as $p)
											<li>{{$p}}</li>
										@endforeach
										</ul>
										@endif
										@if($i['kw_k'])

										<b>KOTA/KAB</b>
										<ul>
										@foreach($i['pelaksana_k'] as $p)
											<li>{{$p}}</li>
										@endforeach
										</ul>
										@endif


									</td>


								</tr>

							@endforeach

						@endforeach


					@endforeach

				@endforeach

			@endforeach

		@endforeach
	</tbody>
	<thead class="bg-navy">
		<tr>
			<th colspan="11">
				<p class="text-center"><b>INDNTIFIKASI KEBIJAKAN 5 TAHUNAN {{Hp::fokus_tahun()}}</b></p>
			</th>
		</tr>
	</thead>
</table>

</div>
@stop

@section('js')

<script type="text/javascript">

	function nameRKP(jenis){
		switch(jenis){
			case -1:
				jenis='MAJOR PROJECT';
			break;
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
				jenis='PROYEK';
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

	function showFormCreatePn(major=null){
		API_CON.get("{{route('int.kb1tahun.pn_create')}}"+(major?'?major=true':'')).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH '+(major?'MAJOR PROJECT':'')+' {{Hp::fokus_tahun()}}');
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
