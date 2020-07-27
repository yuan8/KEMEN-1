@extends('adminlte::page')


@section('content_header')
     <div class="row">
     	
    	<div class="col-md-12">
    			
    			<h3 class="text-uppercase"><img src="{{asset($daerah->logo)}}" style="height:30px;">  {{$daerah->nama}} <small>INTEGRASI NOMENKLATUR {{Hp::fokus_tahun()}} </small>  </h3>
    		
    		
    	</div>
    	
    </div>
@stop
@section('content')
<style type="text/css">
	td{
		font-size: 10px;

	}
</style>
<div class="row">
	<div class="col-md-12 modal-footer">
		<button type="button" class="btn btn-warning btn-xs" onclick="showDataSource()" >
		  TAMBAH DATA
		</button>
</div>
</div>
<div class="row no-gutter collapse " id="form_col">
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
			<form action="{{route('pel.pro',['id'=>$daerah->id])}}" method="post">
				@csrf
				<div class="box-header with-border">
				<h5><b>TAGGING PELAKSANAAN NOMENKLATUR PROVINSI </b></h5>
				<i></i>
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



<div class="box box-success">
	<div class="box-header with-border">
		<form action="{{route('nomen.pro.detail',['id'=>$daerah->id])}}" method="get">
			<input type="text" name="q" placeholder="search nomeklatur daerah ..." class="form-control" value="{{isset($_GET['q'])?$_GET['q']:''}}">
		</form>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					
					<th>KODE</th>
					<th>PROGRAM</th>
					<th>KEGIATAN</th>
					<th>SUB KEGIATAN</th>
					<th>PRIORITAS NASIOANAL / PROYEK</th>
					<th>INDIKATOR</th>
					<th>TARGET PUSAT {{Hp::fokus_tahun()}}</th>

				</tr>
			</thead>
			<tbody>
				<?php
				
				$psn=null;
				$ind=null;
				$nomen=null;
				
				?>
				@foreach($data as $d)
			
				@if(($nomen!=$d->id_nomen)&&(null!=$d->id_nomen))
				<tr>
					<td>{{$d->kode}}</td>
					<td>{{$d->nama_program}}</td>
					<td>{{$d->nama_kegiatan}}</td>
					<td>{{$d->nama_sub_kegiatan}}</td>
					<td colspan="3"></td>
				</tr>
				<?php $nomen=$d->id_nomen; ?>
				@endif

				@if(($psn!=($d->id_psn))&&(null!=($d->id_psn)))
					<tr>
						@if($d->id_psn!=null)
							<td colspan="4"></td>
							<td>
								<p><B>(PN)</B> {{$d->nama_pn}}</p>
								<p><B>(PP)</B> {{$d->nama_pp}}</p>
								<p><B>(KP)</B> {{$d->nama_kp}}</p>
								<p><B>(PROPN)</B> {{$d->nama_propn}}</p>
								<p><B>(PROYEK)</B> {{$d->nama_psn}}</p>
							</td>
						@else
							<td colspan="4"></td>
							<td class="bg bg-danger">
								Tidak Terdapat Dukungan Pusat 
							</td>
						@endif
						</tr>
				<?php $psn=$d->id_psn; ?>

				@endif
				@if(($ind!=$d->id_ind) and ($d->id_ind!=null) )
					<tr >
						<td colspan="5"></td>
						<td>{{$d->nama_indikator}}</td>
						<td>{!!nl2br($d->target_pusat)!!} ({{$d->satuan}})</td>
					</tr>
					<?php $ind=$d->id_ind; ?>
				@endif
 
				@endforeach
			</tbody>
		</table>
		{{$data->links()}}

	</div>
</div>


@stop

@section('js')
<script>

	function showDataSource(){
			if($('#form_col').hasClass('in')){
				$('#form_col').collapse('hide');

			}else{
				$('#form_col').collapse('show');

				
			}
		}

	var data_list=[];

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