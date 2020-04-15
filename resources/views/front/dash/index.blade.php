@extends('adminlte::page_front')

@section('content_header')
     <div class="row">
    	<div class="col-md-12">
    		<h3>DATA RKPD (SUMBER SIPD) {{$tahun}}</h3>
    	</div>
    </div>
   
    <?php
?>
@stop

@section('content')
<?php $mix=date('m_s'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-body">
				<table class="table table-bordered" id="table-rkpd{{$mix}}">
					<thead>
						<tr>
							<th>LOGO</th>
							<th>NAMA DAERAH</th>
							<th>STATUS DATA SIPD</th>
							<th>URUSAN DALAM RKPD</th>
							<th>LAST UPDATE</th>
							<th>STATUS</th>
							<th>URUSAN TERTAGING</th>
							<th>ACTION</th>
						</tr>
					</thead>

				</table>
			</div>
		</div>
	</div>
</div>



@stop

@section('js')
<script type="text/javascript">


	var data{{$mix}}=<?php echo json_encode($data); ?>;

	var tb_data{{$mix}}=$('#table-rkpd{{$mix}}').DataTable({
		sort:false,
		columns:[
			{
				data:'logo',
				type:'html',
				render:function(data){
					return '<img src="{{url('/')}}/'+data+'"  style="max-width:40px">';
				}
			},

			{
				data:'nama',
				type:'string'
			},
			{
				data:'status',
				type:'string',
				render:function(data,type,data_meta){
					var status='';
					var exist='';

					if(data!=0){
						status='TERDAPAT DATA';
					}else{
						staus='TIDAK TERDAPAT DATA';
					}

					if(data_meta.existing_data){
						 exist='<span class="btn btn-primary btn-xs">TERCOPY</span>';
					}

					return status+'<br>'+exist;
				}
			},
			{
				data:'list_id_urusan',
				type:'string',
				render:function(data){
						// console.log(data);
						var str='';

						if(data!=null){
							data= data.split(',');
							for(var i in data){
								str+='<span class="btn btn-info btn-xs col-md-12" style="margin-bottom:5px;">'+data[i]+'</span>';
							}
						}else{
							return '';
						}

						return str;
				}
			},
			{

				type:'string',
				render:function(data,type,data_meta){
					if(data_meta.existing_data){
						return data_meta.last_date;
					}else{
						return 'TIDAK MELAPOR';
					}
				}
			},
			{
				data:'status',
				type:'string',
				render:function(data,type,data_meta){
					var status='';
					switch(data){
						case 0:
						status= '';
						break;
						case 1:
						status= 'PERENCANAAN';
						break;;
						case 2:
						status= 'RANRKPD';
						break;
						case 3:
						status= 'RANWAL';
						break;
						case 4:
						status= 'RANHIR';
						break;
						case 5:
						status= 'FINAL';
						break;
					}

					if(data_meta.existing_data){
						var kelengkapan='';
						// if('{{env('HANDLE_URUSAN')}}'==data_meta.list_id_urusan){
						// 	kelengkapan='<span class="badge badge-primary">7 URUSAN LENGKAP</span>';
						// }else{
						// 	var jumlh=data_meta.list_id_urusan.split(',');
						// 	kelengkapan='<span class="badge badge-info">'+jumlh.length+' URUSAN</span>';
						// }

						return status+'<br>'+kelengkapan;
					}else{
						return '';
					}

				}
			},
			{
				data:'list_id_urusan_taging',
				type:'html',
				render:function(data){
						// console.log(data);
						var str='';

						if(data!=null){
							data= data.split(',');
							for(var i in data){
								str+='<span class="btn btn-info btn-xs col-md-12" style="margin-bottom:5px;">'+data[i]+'</span>';
							}
						}else{
							return '';
						}

						return str;
				}
			},
			{
				data:'id',
				type:'html',
				render:function(data,type,data_meta){
					if(data_meta.existing_data){
						return '<a target="_blank" href="{{url('program-kegiatan-data').'/'}}'+data+'" class="btn btn-warning btn-xs ">Detail</a>';
					}else{
						return '';
					}
					
				}
			}
		]
	});

	tb_data{{$mix}}.rows.add(data{{$mix}}).draw();






</script>
@stop