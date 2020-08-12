@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PELAKSANAAN URUSAN TAHUN {{Hp::fokus_tahun()}}</h3>
    	
    	</div>
    	<div class="col-md-4">
    		<br>
    		<div class="btn-group pull-right">
    			<button class="full-w btn btn-xs btn-success" onclick="showFromCreateKewenangan()">TAMBAH KEWENANGAN</button>
    			{{-- <button class="full-w btn btn-success btn-xs" onclick="showFromCreateIndikator()">TAMBAH INDIKATOR</button> --}}
    		</div>
    	</div>
    	
    </div>
@stop


@section('content')
	
	<table class="table bg-white table-bordered table-hover" id="data_pelaksanaan_table">
		<thead class="bg-navy">
			<tr>
				<th rowspan="2" >ACTION</th>
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
		<tbody>
			@foreach($data as $k)
			<tr>
				<td>
					<div class=" pull-right">
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
				<tr class="k-{{$k['id']}}">
					<td colspan="5">
						<div class="pull-right">
							 <button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$i['id']}})"><i class="fa fa-eye"></i></button>
							<button class="btn btn-danger  btn-xs" onclick="showFormDeleteIndikatorKW({{$i['id']}})"><i class="fa fa-trash"></i></button>
						</div>
					</td>
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
	</table>

@stop

@section('js')

<script type="text/javascript">
	$('#data_pelaksanaan_table').dataTable({
		sort:false
	});



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

	

</script>
@stop