@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PELAKSANAAN URUSAN TAHUN {{Hp::fokus_tahun()}}</h3>
    	
    	</div>
    	<div class="col-md-4">
    		<br>
    		
    	</div>
    	
    </div>
       <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.theme.default.css')}}">
	<script type="text/javascript" src="{{asset('bower_components/jquery-treetable/jquery.treetable.js')}}"></script>
	<style type="text/css">
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
			vertical-align:middle!important;
		}
	</style>
@stop


@section('content')
	<div class="btn-group btn-group" style="margin-bottom: 10px;">
    			<button class="full-w btn btn-sm btn-primary" onclick="showFromCreateKewenangan()">TAMBAH KEWENANGAN</button>

    			<a href="{{route('int.pelurusan.download',['pdf'=>'export'])}}" class="full-w btn btn-success btn-sm" >DOWNLOAD  DATA</a>
    		
    		</div>
	<table class="table bg-white table-bordered table-hover" id="data_pelaksanaan_table">
	
		<tbody>
			@foreach($data as $k)
			<tr data-tt-id="kn-{{$k['id']}}" >
				<td class="bg-primary">
					<h5><b>KEWENANGAN</b></h5>
				</td>
				<td>
					<div class=" btn-group">
						<button   collapse-btn-nested="false" data-target=".k-{{$k['id']}}"  class="btn btn-info btn-xs ">
								<i data-toggle="tooltip" data-placement="top" title="DETAIL INDIKATOR KEWENANGAN" class="fa fa-eye"></i>
							 ({{count($k['_indikator'])}})</button>

					
						<button class="btn btn-warning  btn-xs" onclick="showFormUpdateKw({{$k['id']}})" ><i class="fa fa-pen"></i></button>

						<button class="btn btn-danger  btn-xs" onclick="showFormDeleteKw({{$k['id']}})"><i class="fa fa-trash"></i></button>

						<button class="btn btn-success  btn-xs" onclick="showFormCreateKewenanganIndikator({{$k['id']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i> Indikator</button>


					</div>
				</td>
				<td>{{$k['_sub_urusan']['nama']}}</td>
				<td>{!!nl2br($k['kewenangan_nas'])!!}</td>
				<td>{!!nl2br($k['kewenangan_p'])!!}</td>
				<td colspan="6">{!!nl2br($k['kewenangan_k'])!!}</td>




			</tr>

			@foreach($k['_indikator'] as $i)
			@php	

			@endphp
				<tr class="k-{{$k['id']}}" data-tt-id="i-{{$i['id']}}" data-tt-parent-id="kn-{{$i['id_kewenangan']}}">
					<td class="bg-primary">
					<h5><b>INDIKATOR</b></h5>
				</td>
					<td colspan="">
						<div class="btn-group">
							 <button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$i['id']}})"><i class="fa fa-eye"></i></button>
							 <button class="btn btn-warning btn-xs" onclick="showFormUpdateIndikator({{$i['id']}})"><i class="fa fa-pen"></i></button>
							<button class="btn btn-danger  btn-xs" onclick="showFormDeleteIndikatorKW({{$i['id']}})"><i class="fa fa-trash"></i></button>
						</div>
					</td>
					<td colspan="4"></td>
					<td>{{$i->_sumber()}}</td>
					
					<td>{{$i->kode}}</td>
					<td>{{$i->uraian}}</td>
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
					<td>{{$i->satuan}}</td>



				</tr>
			@endforeach



			@endforeach
		</tbody>
			<thead class="bg-navy">
			<tr>
				<th rowspan="2"></th>
				<th rowspan="2" style="width: 250px;" >ACTION</th>
				<th rowspan="2" >SUB URUSAN</th>
				<th rowspan="2">KEWENANGAN PUSAT</th>
				<th rowspan="2">KEWENANGAN PROVINSI</th>
				<th rowspan="2">KEWENANGAN KOTA / KAB</th>
				<th colspan="5">INDIKATOR</th>
			</tr>
			<tr>
				<th >JENIS</th>
				<th >KODE</th>
				<th >INDIKATOR</th>
				<th >TARGET</th>
				<th >SATUAN</th>

			</tr>
			
		</thead>
	</table>

@stop

@section('js')

<script type="text/javascript">
	
	$("#data_pelaksanaan_table").treetable({ expandable: true,column:1,initialState: 'Expand'},true);
	$("#data_pelaksanaan_table").reveal();




	function showFormDetailIndikator(id){

        API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }

	function showFromCreateKewenangan(){
		API_CON.get("{{route('int.pelurusan.create_kewenangan')}}").then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH KEWENANGAN {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}


	function showFormCreateKewenanganIndikator(id){
		API_CON.get("{{route('int.pelurusan.create',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormDeleteKw(id){
		API_CON.get("{{route('int.pelurusan.form_delete',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('HAPUS KEWENANGAN');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormUpdateKw(id){
		API_CON.get("{{route('int.pelurusan.form_update',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('HAPUS KEWENANGAN');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormDeleteIndikatorKW(id){

		API_CON.get("{{route('int.pelurusan.form_delete_indikator',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('HAPUS INDIKATOR');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});

	}

	function showFormUpdateIndikator(id){
        API_CON.get("{{route('int.m.indikator.form_edit',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('UPDATE INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }

	

</script>
@stop