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
<style type="text/css">
	.select2-container--default .select2-selection--multiple .select2-selection__choice{
		background-color:#00a65a!important; 
	}

</style>
<?php $mix=date('m_s'); ?>
<div class="row" style="margin-bottom: 15px;">
	<div class="col-md-12">
		<div class="row">
	<div class="col-md-3">
		<label>PROVINSI</label>
		<select class="form-control use-select-2" id="provinsi">
			<option value="" >-SEMUA-</option>
			<?php foreach ($provinsi as $key => $p): ?>
				<option value="{{'@'.$p->id}}">{{$p->nama}}</option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="col-md-3">
		<label>EXISTING SIPD</label>
		<select class="form-control use-select-2" id="exist_sipd">
			<option value="" >-SEMUA-</option>
			<option value="1" >TERDAPAT DATA</option>
			<option value="0" >TIDAK TERDAPAT DATA</option>
		</select>
	</div>
	<div class="col-md-3">
		<label>EXISTING SUPD</label>
		<select class="form-control use-select-2" id="exist_supd">
			<option value="" >-SEMUA-</option>
			<option value="1" >TERDAPAT DATA</option>
			<option value="0" >TIDAK TERDAPAT DATA</option>
		</select>
	</div>
	<div class="col-md-3">
		<label>STATUS</label>
		<select class="form-control use-select-2" id="status_sipd">
			<option value="" >-SEMUA-</option>
			<option value="1" >PERENCANAAN</option>
			<option value="2" >RANRKPD</option>
			<option value="3" >RANWAL</option>
			<option value="4" >RANHIR</option>
			<option value="5" >FINAL</option>
		</select>
	</div>
		</div>
	</div>
	<div class="col-md-3">
		<label>EXISTING DATA URUSAN</label>
		<select class="form-control use-select-2" multiple="" id="multiple">
			@foreach($urusan as $u)
			<option value="{{$u->id}}">{{$u->nama}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-3">
		<label>UNEXISTING DATA URUSAN</label>

		<select class="form-control use-select-2" multiple="" id="multiple_negasi">
			@foreach($urusan as $u)
			<option value="{{$u->id}}">{{$u->nama}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-3">
		<label>TAGGED</label>

		<select class="form-control use-select-2" multiple="" id="multiple_taged">
			@foreach($urusan as $u)
			<option value="{{$u->id}}">{{$u->nama}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-3">
		<label>UNTAGGED</label>

		<select class="form-control use-select-2" multiple="" id="multiple_taged_negasi">
			@foreach($urusan as $u)
			<option value="{{$u->id}}">{{$u->nama}}</option>
			@endforeach
		</select>
	</div>
	
</div>
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
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
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
						status='TIDAK TERDAPAT DATA';
					}

					if(data_meta.exist_data){
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
									(sipd?(tertaging?'[TERTAGGING]':'[BELUM TAGGING]'):'[DATA TIDAK TERSEDIA]')
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
				data:'kode_daerah',
				type:'html',
				render:function(data,type,data_meta){
						return '<a target="_blank" href="{{url('program-kegiatan-data').'/'}}'+data+'" class="btn btn-warning btn-xs ">Detail</a>';
					
				}
			}
		]
	});

	tb_data{{$mix}}.rows.add(data{{$mix}}).draw();

	$.fn.dataTable.ext.search.push(
		    function( settings, data, dataIndex ) {

		    	var validate=1;
		    	var list_data_urusan=[];
		    	var list_in=$('#multiple').val();
		    	var list_out=$('#multiple_negasi').val();
		    	var list_in_tagged=$('#multiple_taged').val();
		    	var list_out_tagged=$('#multiple_taged_negasi').val();

		    	var list_data_urusan_taging=[];
		    	var validate_out=1;
		    	var validate_taged=1;
		    	var validate_out_tagged=1;
		    	var status_sipd=$('#status_sipd').val();
		    	var exist_sipd=$('#exist_sipd').val();
		    	var exist_supd=$('#exist_supd').val();
		    	var validate_exist_sipd=1;
		    	var validate_exist_supd=1;
		    	var validate_status_sipd=1;
		    	var provinsi=$('#provinsi').val();
		    	var validate_pro=1;
		    	var pro='@'+data{{$mix}}[dataIndex].kode_daerah;
		    	
		    	if(provinsi!=''){
		    		

		    		if(!pro.includes(provinsi)){
		    			validate_pro=0;
		    		}
		    	}

		    	if(exist_sipd!=''){
		    		if(exist_sipd==0){
		    			if(data{{$mix}}[dataIndex].status_data_sipd!=0){
		    				validate_exist_sipd=0;
			    		}
		    		}else{
		    			if(data{{$mix}}[dataIndex].status_data_sipd==0){
		    				validate_exist_sipd=0;
			    		}
		    		}

		    	}

		    	if(exist_supd!=''){
		    		if(data{{$mix}}[dataIndex].exist_data!=exist_supd){
		    			validate_exist_supd=0;
		    		}
		    	}

		    	if(status_sipd!=''){
		    		if(data{{$mix}}[dataIndex].status_data_sipd!=status_sipd){
		    			validate_status_sipd=0;
		    		}
		    	}



		    	for(var i in data{{$mix}}[dataIndex].urusan){
		    		if(data{{$mix}}[dataIndex].urusan[i].existing_data_sipd){
		    			list_data_urusan.push(parseInt(i));

		    			if((data{{$mix}}[dataIndex].urusan[i].tertaging_supd)){
		    				list_data_urusan_taging.push(parseInt(i));
		    			}
		    		}

		    		
		    	}


		    	for(var i in list_in){
		    		if(!list_data_urusan.includes(parseInt(list_in[i]))){
		    			validate=0;
		    		}
		    	}

		    	for(var i in list_in_tagged){
		    		if(!list_data_urusan_taging.includes(parseInt(list_in_tagged[i]))){
		    			validate_taged=0;
		    		}
		    	}

		    	for(var i in list_out_tagged){
		    		if(list_data_urusan.includes(parseInt(list_out_tagged[i]))){
			    		if((list_data_urusan_taging.includes(parseInt(list_out_tagged[i])))){
			    			validate_out_tagged=0;
			    		}
			    	}else{
			    		validate_out_tagged=0; 
			    	}
		    	}

		   	

		    	if(validate_out && (list_out.length>0)){
		    		for(var i in list_out){
		    			if(list_data_urusan.includes(parseInt(list_out[i]))){
		    				validate_out=0;
		    			}
		    		}
		    	}

		
		    	if(((validate && validate_out)&&(validate_taged && validate_out_tagged ))&&(( validate_exist_sipd && validate_status_sipd)&&(validate_exist_supd && validate_pro) ) ){
		    		return true;
		    	}else{
		    		return false;
		    	}
		    }
		);

	$('.use-select-2').select2();

	$('.use-select-2').on('change',function(){
				tb_data{{$mix}}.draw();
	});







</script>
@stop