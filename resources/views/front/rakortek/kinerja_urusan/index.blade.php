@extends('adminlte::page_front')


@section('content_header')
     <div class="row">
    	<div class="col-md-12">
    		<h3 class="text-uppercase text-center">KINERJA URUSAN DAERAH 2021</h3>
    	</div>
    </div>
   	<style type="text/css">
   		.hover-bg-td:hover{
   			background: #ddd;
   		}
   	</style>

@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
					<div class="col-md-4">
					<div class="form-group">
						<label>PROVINSI / KOTA</label>
						<select class="form-control tgr_td" id="cat_daerah">
							<option value="" >SEMUA</option>
							<option value="P" >PROVINSI</option>
							<option value="K" >KOTA</option>

						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>TERDAPAT BIDANG</label>
						<select class="form-control use-select-2 tgr_td" id="avaible_u" multiple="">
							@foreach($urusan as $k=> $u)
								<option value="{{$k}}" >{{$u['nama']}}</option>	
							@endforeach

						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>TIDAK TERDAPAT BIDANG</label>
					<select class="form-control use-select-2 tgr_td" id="un_avaible_u" multiple="">
							@foreach($urusan as $k=> $u)
								<option value="{{$k}}" >{{$u['nama']}}</option>	
							@endforeach

						</select>
					</div>
				</div>
			</div>
			<div class="box-body">
			
				<table class="table-bordered table" id="data_iku">
					<thead>
						<tr>
							<th>KODE DAERAH</th>
							<th>NAMA DARAH</th>
							@foreach($urusan as $u)
								<th>
									{{$u['nama']}}
								</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
			
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

@stop


@section('js')


<script type="text/javascript">
	function detail_data(link,dom_id){
		API_CON.get(link).then(function(data){
			$('.tr_data').addClass('hidden');
			$(dom_id+' td')[0].innerHTML=(data.data);
			$(dom_id).removeClass('hidden');

		});
	}
</script>


<script type="text/javascript">
	$('.use-select-2').select2();

	var data_iku=$('#data_iku').DataTable({
		sort:false,
		createdRow:function(row,data,dataIndex,cells){
			if(data.kat=='P'){
				$(row).addClass("bg-primary");
			}
		},
		 
		
		columns:[
			{
				data:'kode_daerah',
				type:'string'
			},

			{
				data:'nama',
				type:'string'
			}
			@foreach($urusan as $k=>$u)
			,{
				data:'urusan.{{$k}}',
				type:'html',
				render:function(data,key){
					return '<p><b>'+data.value+'</b></p><small style="font-size:8px;">'+data.nama+'<small>';
				},
				"createdCell": function (td, cellData, rowData, row, col) {

					$(td).addClass('text-dark hover-bg-td '+(cellData.value?'bg-success':'bg-danger'));
					$(td).attr('onclick','detail_urusan(this,'+rowData.kode_daerah+')');
			    },
				
			}

			@endforeach
		]
		

		});


		data_iku.rows.add(<?php echo json_encode($data) ?>).draw();

		$.fn.dataTable.ext.search.push(
			 function( settings, dt, index,data ) {
			 	var approve=true;
			 	if(settings.nTable.id='data_iku'){
			 		if($('#cat_daerah').val()!=''){
				 		if($('#cat_daerah').val()==data.kat){
				 			approve=true;
				 		}else{
				 			approve=false;
				 			
				 		}
			 		}else{
				 			approve=true;
			 		}
			 	}


			 	if(approve){
			 		var avaible_u=$('#avaible_u').val();
			 		for(var i in avaible_u){
			 			if(approve){
			 				if(data.urusan[avaible_u[i]].value==0){
			 					approve=false;
			 				}
			 			}
			 		}

			 	}

			 	if(approve){
			 		var un_avaible_u=$('#un_avaible_u').val();
			 		for(var i in un_avaible_u){
			 			if(approve){
			 				if(data.urusan[un_avaible_u[i]].value!=0){
			 					approve=false;
			 				}
			 			}
			 		}

			 	}

			 	if(approve){
			 		return true;
			 	}else{
			 		return false;
			 	}

			 }
		);

		$('.tgr_td').on('change',function(){
			data_iku.draw();
		});

		function detail_urusan(dom,kode_daerah){
			var data=data_iku.cell(dom).data();
			var url='{{route('front.r.iku.daerah')}}/';
			API_CON.post(url+kode_daerah,{kode_ind:data.i_id}).then(function(datar,err){
				$('#modal-detailing .modal-body').html(datar.data);
				var row=data_iku.row($(dom).parent()).data();

				
				$('#modal-detailing .modal-header').html('<h5><b>'+row.nama+'</b></h5><p>'+data.nama+'</p>');

				$('#modal-detailing').modal();
			});
		}

		function kegiatan_pendukung_iku(kode_daerah,kode_ind,dom_append){
			API_CON.post('{{route('front.r.iku.pendukung')}}/'+kode_daerah+'/'+kode_ind).then(function(datar,err){
				$(dom_append).html(datar.data);
			});
		}

</script>
<div class="modal fade in" id="modal-detailing">
	<div class="modal-dialog modal-lg" style="width: 95%;">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				
			</div>
		</div>
	</div>
</div>


@stop