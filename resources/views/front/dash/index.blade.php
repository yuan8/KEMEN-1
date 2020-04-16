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
							<th>STATUS</th>
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
				data:'nama_daerah',
				type:'string'
			},
			{
				data:'status_data_sipd',
				type:'html',
				render:function(data,type,data_meta){
					var status='';
					var exist='';

					if(data!=0){
						status='TERDAPAT DATA';
					}else{
						staus='TIDAK TERDAPAT DATA';
					}

					if(data_meta.tertaging_supd){
						 exist='<span class="btn btn-primary btn-xs">TERCOPY</span>';
					}

					return status+'<br>'+exist;
				}
			},
			{
				data:'urusan',
				type:'html',
				render:function(data){
						var str='';

						if(data!={}){
							for(var i in data){
								var sipd=0;
								if(data[i].existing_data_sipd){
									sipd=1
								}
								var tertaging=0;
								if(data[i].tertaging_supd){
									tertaging=1;
								}

								str+='<span class="btn '+(sipd?(tertaging?'btn-success':'btn-warning'):'btn-danger')+' btn-xs " style="margin-bottom:5px;">'+data[i].nama+' '+
									(sipd?(tertaging?'[TERTAGGING]':'[BELUM TAGGING]'):'[DATA TIDKA TERSEDIA]')
									+'</span><br>';
							}
						}else{
							return '';
						}

						return str;
				}
			},
			
			{
				data:'status_data_sipd',
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
					var kelengkapan='';
					if(data_meta.lengkap){
						kelengkapan='(LENGKAP)';	
					}else{
						
					}

					return status+'<br>'+kelengkapan;


				}
			},
			
			{
				data:'id',
				type:'html',
				render:function(data,type,data_meta){
						return '<a target="_blank" href="{{url('program-kegiatan-data').'/'}}'+data+'" class="btn btn-warning btn-xs ">Detail</a>';
					
				}
			}
		]
	});

	tb_data{{$mix}}.rows.add(data{{$mix}}).draw();






</script>
@stop