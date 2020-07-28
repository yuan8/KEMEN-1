@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>INTEGRASI {{$daerah->nama}} {{Hp::fokus_tahun()+1}} </h3>
      </div>
      
    </div>
@stop

@section('content')
<div class="box box-solid 	">
	<div class="box-body ">

		<button onclick="showFormTambahProgram({{$daerah->id}})" class="btn btn-primary btn-xs text-uppercase">TAMBAH PROGRAM</button>
		<a href="" class="btn btn-success btn-xs text-uppercase">DOWNLOAD DATA</a>

	</div>
</div>
<hr>

<table class="table-bordered table bg-white">
	<thead class="bg-navy">
		<tr>
			<th rowspan="2" colspan="2">KODE PROGRAM</th>
			<th rowspan="2">PROGRAM</th>
			<th rowspan="2">KODE KEGIATAN</th>
			<th rowspan="2">KEGIATAN</th>
			<th rowspan="2">KODE SUB KEGIATAN</th>
			<th rowspan="2">SUB KEGIATAN</th>
			<th colspan="5">INDIKATOR</th>
			<th rowspan="2">ACTION</th>
		</tr>
		<tr>
			<th>KODE</th>
			<th>URAIAN</th>
			<th>TARGET PUSAT</th>
			<th>TARGET DAERAH</th>
			<th>SATUAN</th>
		</tr>

	</thead>
	<tbody>
		@foreach($data as $p)
			@php $pn=$p['_nomen']; @endphp
			<tr>
				<td>
					<div class=" pull-right">
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
				<td>{{$pn->kode}}</td>
				<td>{{$pn->nomenklatur}}</td>

			</tr>

			@foreach($p['_tag_indikator'] as $pi)
				@php $pii=$pi['_indikator'];  @endphp
				<tr class="pn-{{$p['id']}}">
					<td colspan="6"></td>
					<td>
						<div class=" pull-right">
							<button   class="btn btn-info btn-xs " onclick="showFormDetailIndikator({{$pii['id']}})">
									<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB INDIKATOR" class="fa fa-eye"></i>
							</button>
							
							<button class="btn btn-danger  btn-xs" onclick="showFormDeleteindikator({{$pi['id']}},{{$pi['jenis']}})"><i class="fa fa-trash"></i></button>
							
						</div>
					</td>
					<td>{{$pii->kode}}</td>
					<td>{{$pii->uraian}}</td>
					<td>
						@if(($pii['tipe_value']==1)OR($pii['tipe_value']==2))
						{{number_format($pii['target'],2)}}
						@else
							{{$pii['target']}}

						@endif

						@if($pii['tipe_value']==2)
							<-> {{number_format($pii['target_1'],2)}}

						@endif
							
					</td>
					<td style="min-width: 170px;">
						<div class="input-group">
							@if(($pii['tipe_value']==1)OR($pii['tipe_value']==2))
							<input type="number"  name="" class="form-control" id="indikator-{{$pii['id']}}-{{$pi['id']}}-target"  value="{{$pi['target']}}">
							@else
							<input type="text"  name="" class="form-control" id="indikator-{{$pii['id']}}-{{$pi['id']}}-target" value="{{$pi['target']}}">

							@endif
							@if($pii['tipe_value']==2)
								<-> 
							<input type="number"  name="" class="form-control" id="indikator-{{$pii['id']}}-{{$pi['id']}}-target-1" value="{{$pi['targe_1']}}">


							@endif
						</div>
					</td>
					<td>{{$pii['satuan']}}</td>
					<td>
						<button class="btn btn-xs btn-warning btn-xs">UPDATE</button>
					</td>

				</tr>

			@endforeach

			@foreach($p['_child_kegiatan'] as $k)
				@php $kn=$k['_nomen']; @endphp
				<tr class="pn-{{$p['id']}}">
					<td colspan="2"></td>
					<td>
						<div class=" pull-right">
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
					<td>{{$kn->kode}}</td>
					<td>{{$kn->nomenklatur}}</td>

				</tr>
				@foreach($k['_tag_indikator'] as $ki)
					@php $kii=$ki['_indikator'];  @endphp
					<tr class="pn-{{$p['id']}} kn-{{$k['id']}}">
						<td colspan="6"></td>
						<td>
							<div class=" pull-right">
								<button   class="btn btn-info btn-xs " onclick="showFormDetailIndikator({{$kii['id']}})">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB INDIKATOR" class="fa fa-eye"></i>
								</button>
								
								<button class="btn btn-danger  btn-xs" onclick="showFormDeleteindikator({{$ki['id']}},{{$ki['jenis']}})"><i class="fa fa-trash"></i></button>
								
							</div>
						</td>
						<td>{{$kii->kode}}</td>
						<td>{{$kii->uraian}}</td>
						<td>
							@if(($kii['tipe_value']==1)OR($kii['tipe_value']==2))
							{{number_format($kii['target'],2)}}
							@else
								{{$kii['target']}}

							@endif

							@if($kii['tipe_value']==2)
								<-> {{number_format($kii['target_1'],2)}}

							@endif
								
						</td>
						<td style="min-width: 170px;">
							<div class="input-group">
								@if(($kii['tipe_value']==1)OR($kii['tipe_value']==2))
								<input type="number"  name="" class="form-control" id="indikator-{{$kii['id']}}-{{$ki['id']}}-target" value="{{$ki['taregt']}}">
								@else
								<input type="text"  name="" class="form-control" id="indikator-{{$kii['id']}}-{{$ki['id']}}-target" value="{{$ki['target']}}">

								@endif
								@if($kii['tipe_value']==2)
									<-> 
								<input type="number"  name="" class="form-control" id="indikator-{{$kii['id']}}-{{$ki['id']}}-target-1" value="{{$ki['target_1']}}">

								@endif
							</div>
						</td>
						<td>{{$kii['satuan']}}</td>
						<td>
							<button class="btn btn-xs btn-warning btn-xs">UPDATE</button>
						</td>

					</tr>

				@endforeach

				@foreach($k['_child_sub_kegiatan'] as $s)
					@php $sn=$s['_nomen']; @endphp
					<tr class="pn-{{$p['id']}} kn-{{$k['id']}}">
						<td colspan="4"></td>
						<td>
							<div class=" pull-right">
								<button   collapse-btn-nested="false" data-target=".sn-{{$s['id']}}"  class="btn btn-info btn-xs ">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB KEGIATAN" class="fa fa-eye"></i>  ({{count($s['_tag_indikator'])}})
									</button>
								
								<button class="btn btn-danger  btn-xs" onclick="showFormDelete({{$s['id']}},{{$s['jenis']}})"><i class="fa fa-trash"></i></button>
								<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$s['id']}},{{$s['jenis']}})" >
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>
							</div>
						</td>
						<td>{{$sn->kode}}</td>
						<td>{{$sn->nomenklatur}}</td>

					</tr>

					@foreach($s['_tag_indikator'] as $si)
					@php $sii=$si['_indikator'];  @endphp
					<tr class="pn-{{$p['id']}} kn-{{$k['id']}} sn-{{$s['id']}}">
						<td colspan="6"></td>
						<td>
							<div class=" pull-right">
								<button   class="btn btn-info btn-xs " onclick="showFormDetailIndikator({{$sii['id']}})">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL SUB INDIKATOR" class="fa fa-eye"></i>
								</button>
								
								<button class="btn btn-danger  btn-xs" onclick="showFormDeleteindikator({{$si['id']}},{{$si['jenis']}})"><i class="fa fa-trash"></i></button>
								
							</div>
						</td>
						<td>{{$sii->kode}}</td>
						<td>{{$sii->uraian}}</td>
						<td>
							@if(($sii['tipe_value']==1)OR($sii['tipe_value']==2))
							{{number_format($sii['target'],2)}}
							@else
								{{$sii['target']}}

							@endif

							@if($sii['tipe_value']==2)
								<-> {{number_format($sii['target_1'],2)}}

							@endif
								
						</td>
						<td style="min-width: 170px;">
							<div class="input-group">
								@if(($sii['tipe_value']==1)OR($sii['tipe_value']==2))
								<input type="number"  name="" class="form-control" id="indikator-{{$sii['id']}}-{{$si['id']}}-target" value="{{$si['taregt']}}">
								@else
								<input type="text"  name="" class="form-control" id="indikator-{{$sii['id']}}-{{$si['id']}}-target" value="{{$si['target']}}">

								@endif
								@if($sii['tipe_value']==2)
									<-> 
								<input type="number"  name="" class="form-control" id="indikator-{{$sii['id']}}-{{$si['id']}}-target-1" value="{{$si['target_1']}}">

								@endif
							</div>
						</td>
						<td>{{$sii['satuan']}}</td>
						<td>
							<button class="btn btn-xs btn-warning btn-xs">UPDATE</button>
						</td>

					</tr>

				@endforeach


				@endforeach

			@endforeach

		@endforeach

	</tbody>
</table>

@stop

@section('js')
<script type="text/javascript">
	

	function showFormTambahProgram(id){

		API_CON.get("{{route('int.rekomendasi.add_program',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH PROGRAM {{Hp::fokus_tahun()+1}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormNested(nomen,jenis){
		var id="{{$daerah->id}}";
		API_CON.get("{{route('int.rekomendasi.nestedCreate',['id'=>null])}}/"+id+'/'+nomen+'/'+jenis).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH KEGIATAN {{Hp::fokus_tahun()+1}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});

	}

	function showFormCreateIndikator(nomen,jenis){
		var id="{{$daerah->id}}";
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
		var id="{{$daerah->id}}";
		API_CON.get("{{route('int.rekomendasi.delete_form_nest',['id'=>null])}}/"+id+'/'+nomen+'/'+jenis).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DELETE NOMENKLATUR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

</script>

@stop