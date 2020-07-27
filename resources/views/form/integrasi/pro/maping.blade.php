@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">MAP INTEGRASI PROGRAM, KEGIATAN PROVINSI </h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')



<div class="row no-gutter">
	<div class="col-md-7">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h5><b>NOMENKLATUR PROVINSI</b></h5>
			</div>
			<div class="box-body">
				<table class="table table-bordered" id="container-nomen">
					<thead>
						<tr>
							<th>NOMENKLATUR</th>
							<th>TINGKAT</th>
							<th>URIAN</th>
							<th>JUMLAH INDIKATOR</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>	

		</div>


	</div>
	<div class="col-md-5">
		<div class="box box-warning">
			<form action="{{route('map.provinsi.store',['id'=>$ind->id])}}" method="post">
				@csrf
				<div class="box-header with-border">
				<h5><b>TAGGING NOMENKLATUR PROVINSI KE INDIKATOR</b></h5>
				<i>{{$ind->uraian}}</i>
			</div>
			<div class="box-body">
				<table class="table-bordered table" >
					<thead>
						<tr>
							<th>NOMEN</th>
							<th>TINGKAT</th>
							<th>URAIAN</th>
							<th>ACTION</th>

						</tr>
					</thead>
					<tbody id="tagging-nomen-con">
						
					</tbody>
				</table>
				
			</div>
			<div class="box-footer modal-footer">
				<button type="submit" class="btn btn-warning btn-sm">SUBMIT</button>
			</div>
			</form>
		</div>
	</div>
</div>

@stop

@section('js')

<script type="text/javascript">
	var data_list=<?php echo json_encode($nomenklatur); ?>;

	var data_list_for_add=$('#container-nomen').DataTable({
		'sort':false,
		'columns':[

			{
				data:'kode',
				type:'string'

			},
			{
				data:'jenis',
				type:'string',
				render:function(data){
					return data.replace(/_/g,' ').toUpperCase();
				}

			},
			{
				data:'nomenklatur',
				type:'string'

			},
			{
				data:'jumlah_ind',
				type:'nume',
				render:function(data){
					if(data==null){
						return 0;
					}else{
						return data
					}
				}

			},
			{
				type:'html',
				render:function(data,type,row,meta){
					return '<button class="btn btn-warning btn-xs" onclick="tambahNomen('+meta.row+')">TAMBAHKAN</button>';
				}

			},
		],
		autoWidth:false,
		 "lengthMenu": [[5, 10], [5,10]],
        data:[]
	});

	API_CON.get('{{route('api.int.get.nomen.pro')}}').then(function(res){
			data_list_for_add.rows.add(res.data);
			data_list=res.data;
			data_list_for_add.draw();
	});

	var cart_list=[];

	function tambahNomen(index){
		var data=data_list[index]!=undefined?data_list[index]:null;
		if(data){
			var dom='<tr>'+
				'<td>'+data.kode+'</td>'+
				'<td>'+data.jenis.replace(/_/g,' ').toUpperCase()+'</td>'+
				'<td>'+data.nomenklatur+'</td>'+
				'<td><input type="hidden" name="id['+data.kode+']" value="'+data.id+'"> <button class="btn btn-danger btn-xs" type="button" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash"></i></button></td></tr>';

			$('#tagging-nomen-con').prepend(dom);

			console.log(dom);

		}else{

		}

	}




</script>

@stop