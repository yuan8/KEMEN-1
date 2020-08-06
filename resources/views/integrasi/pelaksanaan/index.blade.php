@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PELAKSANAAN URUSAN TAHUN {{Hp::fokus_tahun()}}</h3>
    	
    	</div>
    	<div class="col-md-4">
    		<br>
    		<div class="btn-group pull-right">
    			<button class="full-w btn btn-success btn-xs" onclick="showFromCreateIndikator()">TAMBAH INDIKATOR</button>
    		</div>
    	</div>
    	
    </div>
@stop


@section('content')
	
	<table class="table bg-white table-bordered" id="data_pelaksanaan_table">
		<thead class="bg-navy">
			<tr>
				<th rowspan="2">SUB URUSAN</th>
				<th rowspan="2" colspan="2">KODE</th>
				<th rowspan="2" >INDIKATOR</th>
				<th colspan="3"></th>
			</tr>
			
		</thead>
		<tbody>
			@foreach($data as $i)
			@php $i=(array)$i; @endphp
				
				<tr>
					
					<td rowspan="5">{{$i['nama_sub_urusan']}}</td>
					<td rowspan="5">
						<div class="btn-group pull-right">
							<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$i['id']}})"><i class="fa fa-eye"></i></button>
							<button class="btn btn-warning btn-xs" onclick="showFormUpdateIndikator({{$i['id']}})"><i class="fa fa-pen"></i></button>
							<button class="btn btn-danger btn-xs" onclick="showFormDeleteIndikator({{$i['id']}})"><i class="fa fa-trash"></i></button>
						</div>
					</td>
					<td rowspan="5"><b>{{$i['kode']}}</b></td>
					<td rowspan="5">{{$i['uraian']}}</td>

				</tr>
				<tr class="bg-navy"> 
					<th>KEWENANGAN PUSAT</th>
					<th>KEWENANGAN PROVINSI</th>
					<th>KEWENANGAN KOTA/KAB</th>
				</tr>
				<tr>
					

					
					<td class="{{$i['kw_nas']?'':'bg-danger'}}" >{!!$i['kewenangan_nas']!!}</td>
					<td class="{{$i['kw_p']?'':'bg-danger'}}" >{!!$i['kewenangan_p']!!}</td>
					<td class="{{$i['kw_k']?'':'bg-danger'}}" >{!!$i['kewenangan_k']!!}</td>

				</tr>
				
				<tr class="bg-navy"> 
					<th>DATA DUKUNG PUSAT</th>
					<th>DATA DUKUNG PROVINSI</th>
					<th>DATA DUKUNG KOTA/KAB</th>
				</tr>
				<tr>
					<td class="{{$i['kw_nas']?'':'bg-danger'}}" >{!!$i['data_dukung_nas']!!}</td>
					<td class="{{$i['kw_p']?'':'bg-danger'}}" >{!!$i['data_dukung_p']!!}</td>
					<td class="{{$i['kw_k']?'':'bg-danger'}}" >{!!$i['data_dukung_k']!!}</td>
				</tr>


			@endforeach
		</tbody>
	</table>

@stop

@section('js')

<script type="text/javascript">
	$('#data_pelaksanaan_table').dataTable({
		sort:false
	});



	function showFromCreateIndikator(){
		API_CON.get("{{route('int.pelurusan.create',['id'=>null])}}").then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	function showFormDeleteIndikator(id){
		API_CON.get("{{route('int.pelurusan.show_form_delete',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DELETE INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#modal-global-lg').modal();
		});
	}

	function showFormDetailIndikator(id){
		API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};

			$('#modal-global-lg').modal();
		});
	}

	function showFormUpdateIndikator(id){
		API_CON.get("{{route('int.pelurusan.view',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('UPDATE INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};

			$('#modal-global-lg').modal();
		});

	}

</script>
@stop