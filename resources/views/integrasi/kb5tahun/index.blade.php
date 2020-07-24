@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN 5 TAHUNAN ({{$rpjmn['start']}} -  {{$rpjmn['finish']}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<div class="box box-solid 	">
	<div class="box-body ">

		<button onclick="showFormCreateKondisi()" class="btn btn-success btn-xs text-uppercase">Tambah Kondisi saat ini</button>
		<a href="" class="btn btn-success btn-xs text-uppercase">DWONLOAD DATA</a>

	</div>
</div>
<hr>

<div class="table-responsive">
	<table class="table bg-white table-bordered">
		<thead class="bg-navy">
			<tr>
				<th rowspan="2" style="width: 170px;">ACTION</th>
				<th colspan="5">KONDISI</th>
				<th rowspan="2">URAIAN ISU STRATEGIS</th>
				<th rowspan="2">URAIAN ARAH KEBIJAKAN</th>
				<th rowspan="2">SASARAN</th>
				<th colspan="5">INDIKATOR</th>
				<th colspan="3">KEWENANGAN</th>
				<th rowspan="2">PELAKSANA</th>


			</tr>
			<tr>
				<th >KODE</th>

				<th>URAIAN KONDISI</th>
				<th>TAHUN DATA</th>

				<th>NILAI</th>
				<th>SATUAN</th>


				<th>SUB URUSAN</th>

				<th>KODE INDIKATOR</th>

				<th>URAI INDIKATOR</th>
				<th>TARGET</th>
				<th>SATUAN</th>

				<th>KEWENANGAN PUSAT</th>
				<th>KEWENANGAN PROVINSI</th>
				<th>KEWENANGAN KOTA/KAB</th>
			</tr>
		</thead>
		<tbody class="bg-white">
		@foreach($data as $kn)
			<tr class=" ">
					<td class="bg-white">
						<div class=" pull-right  ">
							<button collapse-btn-nested="false" data-target=".kn-{{$kn['id']}}"  class="btn btn-info btn-xs kn">
								<i data-toggle="tooltip" data-placement="top" title="DETAIL KONDISI SAAT INI" class="fa fa-eye"></i> ({{count($kn['_children'])}})</button>
							<button class="btn btn-success  btn-xs" data="TAMBAH ISU STRATEGIS" onclick="showFormCreateisu({{$kn['id']}})">
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH ISU STRATEGIS" class="fa fa-plus"></i>
							</button>
							<button class="btn btn-warning  btn-xs"  onclick="showFormUpdateKondisi({{$kn['id']}})"><i class="fa fa-pen"></i></button>
							<button class="btn btn-danger  btn-xs" onclick="showFormDeleteKondisi({{$kn['id']}})"><i class="fa fa-trash"></i></button>
						</div>
					</td>
					<td><b>{{$kn['kode']}}</b></td>
					<td>{{$kn['uraian']}}</td>
					<td>{{$kn['tahun_data']}}</td>
					<td>
						@if($kn['tipe_value']==1)
							{{number_format($kn['nilai'],2)}}
						@else
							{{$kn['nilai']}}
						@endif

						
					</td>
					<td>
						{{$kn['satuan']}}
					</td>


				</tr>

				@foreach($kn['_children'] as $isu)
					<tr class="collapse  kn-{{$kn['id']}}">
						<td class="bg-white" colspan="6">
								<div class=" pull-right">
									<button  collapse-btn-nested="false" data-target=".isu-{{$isu['id']}}"  class="btn btn-info btn-xs ">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL ISU STRATEGIS" class="fa fa-eye"></i>
									 ({{count($isu['_children'])}})</button>
								<button class="btn btn-success  btn-xs" onclick="showFormCreateAk({{$isu['id']}})">
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH ARAH KEBIJAKAN" class="fa fa-plus"></i></button>
								<button class="btn btn-warning  btn-xs" onclick="showFormUpdateeisu({{$isu['id']}})"><i class="fa fa-pen"></i></button>
								<button class="btn btn-danger  btn-xs" onclick="showFormDeleteisu({{$isu['id']}})"><i class="fa fa-trash"></i></button>
								</div>
						</td>
						<td>{{$isu['uraian']}}</td>

					</tr>
					@foreach($isu['_children'] as $ak)
						<tr class="collapse kn-{{$kn['id']}} isu-{{$isu['id']}}">
						
						
							<td class="bg-white" colspan="7">
								<div class=" pull-right">
									<button   collapse-btn-nested="false" data-target=".ak-{{$ak['id']}}"  class="btn btn-info btn-xs ">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL ARAH KEBIJAKAN" class="fa fa-eye"></i>
									 ({{count($ak['_children'])}})</button>
								<button class="btn btn-success  btn-xs" onclick="showFormCreateSasaran({{$ak['id']}})" >
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH SASARAN" class="fa fa-plus"></i></button>
								<button class="btn btn-warning  btn-xs" onclick="showFormUpdateAk({{$ak['id']}})"><i class="fa fa-pen"></i></button>
								<button class="btn btn-danger  btn-xs" onclick="showFormDeleteAk({{$ak['id']}})"><i class="fa fa-trash"></i></button>
								</div>
							</td>
							<td>{{$ak['uraian']}}</td>
						</tr>

						@foreach($ak['_children'] as $s)
								<tr class="collapse kn-{{$kn['id']}} isu-{{$isu['id']}} ak-{{$ak['id']}}">
						
						
								<td class="bg-white" colspan="8">
									<div class=" pull-right">
										<button   collapse-btn-nested="false" data-target=".s-{{$s['id']}}"  class="btn btn-info btn-xs ">
											<i data-toggle="tooltip" data-placement="top" title="DETAIL SASARAN" class="fa fa-eye"></i>
										 ({{count($s['_children'])}})</button>
									<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$s['id']}})" >
									<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>
									<button class="btn btn-warning  btn-xs" onclick="showFormUpdateSasaran({{$s['id']}})"><i class="fa fa-pen"></i></button>
									<button class="btn btn-danger  btn-xs" onclick="showFormDeleteSasaran({{$s['id']}})"><i class="fa fa-trash"></i></button>
									</div>
								</td>
								<td>{{$s['uraian']}}</td>
							</tr>


								@foreach($s['_children'] as $i)
							<tr class="collapse kn-{{$kn['id']}} isu-{{$isu['id']}} ak-{{$ak['id']}} s-{{$s['id']}}">
								
								<td colspan="9">
									<div class=" pull-right">
										<button  class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$i['id']}})"><I class="fa fa-eye"  data-toggle="tooltip" data-placement="top" title="DETAIL INDIKATOR" ></I> </button>
										<button class="btn btn-warning  btn-xs" onclick="showFormUpdateIndikator({{$i['id']}})"><i class="fa fa-pen"></i></button>
										<button class="btn btn-danger  btn-xs" onclick="showFormDeleteIndikator({{$i['id']}})"><i class="fa fa-trash"></i></button>

										</div>
								</td>
								<td>{{$i['_sub_urusan']['nama']}}</td>

								<td><b>{{$i['kode']}}</b></td>

								<td>{{$i['uraian']}}</td>
								<td>
									@if(($i['tipe_value']==1)OR($i['tipe_value']==2))
										{{number_format($i['target'],2)}}
									@else
										{{$i['target']}}

									@endif

									@if($i['tipe_value']==2)
										<-> {{number_format($i['target_1'],2)}}

									@endif


								</td>
								<td>{{$i['satuan']}}</td>

								<td>
									@if($i['kw_nas'])
										<i class="fa text-success fa-check"></i> BERWENANG
									@else
										<i class="fa text-danger fa-times"></i> TIDAK BERWENANG
										

									@endif


								</td>
								<td>
									@if($i['kw_p'])
										<i class="fa text-success fa-check"></i> BERWENANG
									@else
										<i class="fa text-danger fa-times"></i> TIDAK BERWENANG

									@endif


								</td>
								<td>
									@if($i['kw_k'])
										<i class="fa text-success fa-check"></i> BERWENANG
									@else
										<i class="fa text-danger fa-times"></i> TIDAK BERWENANG

									@endif


								</td>
								<td style="min-width: 200px;">
									@php
										$pelaksana=[];
										preg_match_all("/@\w+/",$i['pelaksana'],$pelaksana);
									
									@endphp
									@foreach($pelaksana[0] as $kp=> $p)
										<p><b>{{$kp+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

									@endforeach
								</td>


							</tr>
							
						@endforeach


						@endforeach
					
					@endforeach

				@endforeach
			@endforeach

		</tbody>
	</table>
</div>







@stop


@section('js')


<script type="text/javascript">
function init_dss_js_f(){
		$('[collapse-btn-nested]').on('click',function(){
		var nes_status=(this.getAttribute('collapse-btn-nested').toLowerCase()==='true');
		var target=this.getAttribute('data-target');

		if(nes_status){
			$(this.getAttribute('data-target')).css('display','none');
			this.setAttribute('collapse-btn-nested','false');
			$(target+' [collapse-btn-nested]').each(function(i,d){
				$(d).attr('collapse-btn-nested','false');
			});


		}else{

			$(this.getAttribute('data-target')).css('display','revert');
			this.setAttribute('collapse-btn-nested','true');
			$(target+' [collapse-btn-nested]').each(function(i,d){
				$(d).attr('collapse-btn-nested','true');
			});
		}

	});
}


init_dss_js_f();

$('.kn[collapse-btn-nested]').trigger('click');






	function showFormCreateKondisi(){
		API_CON.get("{{route('int.kb5tahun.kondisi.create')}}").then(function(res){
			$('#modal-global .modal-header .modal-title').html('TAMBAH KONDISI {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}

	function showFormUpdateKondisi(id){
		API_CON.get("{{route('int.kb5tahun.kondisi.view',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global .modal-header .modal-title').html('UBAH DATA KONDISI {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}

	function showFormDeleteKondisi(id){
		API_CON.get("{{route('int.kb5tahun.kondisi.form.delete',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global .modal-header .modal-title').html('HAPUS DATA KONDISI {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}
	

	function showFormCreateisu(id){
		API_CON.get("{{route('int.kb5tahun.isu.create',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('TAMBAH ISU STRATEGIS {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}

	function showFormUpdateeisu(id){
		API_CON.get("{{route('int.kb5tahun.isu.view',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('UBAH DATA ISU STRATEGIS {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}


	function showFormDeleteisu(id){
		API_CON.get("{{route('int.kb5tahun.isu.form.delete',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global .modal-header .modal-title').html('HAPUS DATA ISU STRATEGIS {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}
	

	function showFormCreateAk(id){
		API_CON.get("{{route('int.kb5tahun.ak.create',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('TAMBAH ARAH KEBIJAKAN {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}

	function showFormUpdateAk(id){
		API_CON.get("{{route('int.kb5tahun.ak.view',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('UBAH DATA ARAH KEBIJAKAN {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}

	function showFormDeleteAk(id){
		API_CON.get("{{route('int.kb5tahun.ak.form.delete',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('HAPUS DATA ARAH KEBIJAKAN {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}

	function showFormCreateIndikator(id){
		API_CON.get("{{route('int.kb5tahun.indikator.create',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormUpdateIndikator(id){
		API_CON.get("{{route('int.kb5tahun.indikator.view',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormDeleteIndikator(id){
		API_CON.get("{{route('int.kb5tahun.indikator.form.delete',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('HAPUS INDIKATOR {{Hp::fokus_tahun()}}');
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


		function showFormCreateSasaran(id){
		API_CON.get("{{route('int.kb5tahun.sasaran.create',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('TAMBAH ISU STRATEGIS {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}

	function showFormUpdateSasaran(id){
		API_CON.get("{{route('int.kb5tahun.sasaran.view',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('UBAH DATA ISU STRATEGIS {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}


	function showFormDeleteSasaran(id){
		API_CON.get("{{route('int.kb5tahun.sasaran.form.delete',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global .modal-header .modal-title').html('HAPUS DATA ISU STRATEGIS {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}
	


</script>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-global">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal-global-lg">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  

@stop