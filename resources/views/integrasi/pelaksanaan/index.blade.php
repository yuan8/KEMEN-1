@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PELAKSANAAN URUSAN TAHUN {{Hp::fokus_tahun()}}</h3>
    		
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
				<th colspan="3">KEWENANGAN</th>
			</tr>
			<tr>
				<th>DATA DUKUNG PUSAT</th>
				<th>DATA DUKUNG PROVINSI</th>
				<th>DATA DUKUNG KOTA/KAB</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $i)
			@php $i=(array)$i; @endphp
				<tr>
					<td>{{$i['nama_sub_urusan']}}</td>
					<td>
						<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$i['id']}})"><i class="fa fa-eye"></i></button>
					</td>

					<td><b>{{$i['kode']}}</b></td>
					<td>{{$i['uraian']}}</td>
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




	function showFormDetailIndikator(id){
		API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

</script>
@stop