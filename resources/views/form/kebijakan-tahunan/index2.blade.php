@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN </h3>
    		
    	</div>
    	
    	
    </div>
@stop


@section('content')
	
	<div class="row">
		<div class="col-md-12 modal-footer">
		<button type="button" class="btn btn-warning btn-xs" onclick="showDataSource()" >
		  TAMBAH DATA
		</button>
		</div>
		<div class="col-md-12 collapse" id="source-psn">
			<div class="box box-warning">
				<div class="box-header with-border">
					<div class="row no-gutters">
						<form id="form-filter">
							<div class="col-md-3">
							<label>PROYEK NASIONAL</label>
							<select type="text" class=" form-control filter-data" name="pn" v-model='value' v-on:change="change(this)" id="pn_scr">
								<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
								</select>
							</div>
							<div class="col-md-3">
							<label>PROYEK PRIORITAS</label>
								<select type="text" placeholder="PILIH PP" class=" form-control  filter-data" name="pp" id="pp_scr" v-model='value' v-on:change="change(this)">
									<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
								</select>
							</div>
							<div class="col-md-3">
							<label>KEGIATAN PRIORITAS</label>
								<select type="text" class=" form-control  filter-data" name="kp" id="kp_scr" v-model='value' v-on:change="change(this)">
									<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
								</select>
							</div>
							<div class="col-md-3">
							<label>PROYEK PROGRAM PRIORITAS</label>

								<select type="text" class=" form-control  filter-data" name="propn" v-model='value' id="propn_scr"  v-on:change="change(this)">
									<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
								</select>
							</div>
						</form>
					</div>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-8 table-responsive">
							<table class="table table-bordered" id="container-psn">
							<thead>
								<tr>
									<th>KODE</th>
									<th>DETAIL</th>
									<th>TAMBAH</th>
									<th>PROYEK</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
					</table>
					</div>
					<div class="col-md-4 ">
						<form action="{{route('kebijakan.pusat.tahunan.proyek.store')}}" method="post">
							@csrf
							<div class="bg bg-info" style="padding:10px;">
								<div class="form-group">
								<label>Sub Urusan</label>
								<select class="form-control" id="select-sub" name="sub_urusan">
									@foreach($master_sub_urusan as $sub)
										<option value="{{$sub->id}}">{{$sub->nama}}</option>
									@endforeach
								</select>
								</div>
								<table class="table table-bordered bg bg-default">
									<thead>
										<tr>
											<th>KODE</th>
											<th>PROYEK</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody id="cart-list"></tbody>
								</table>
								<div class="col-md-12 text-center">
									<button type="submit" class="btn btn-warning btn-sm">SUBMIT</button>
								</div>
							</div>
						</form>
					</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-body">
					<table class="table table-bordered">
						<thead>
							<thead>
								<tr>
									<th>KODE</th>
									<th>DETAIL</th>
									<th>SUB URUSAN</th>
									<th>PROYEK</th>
									<th>INDIKATOR</th>
								</tr>
							</thead>
							<tbody >
								@foreach($data as $d)
									<tr>
										<td>{{$d->id}}</td>
										<td><button type="button" class="btn btn-info btn-xs" onclick=" viewDetailPSN({{$d->id}},event) ">Detail</button></td>
										<td>{{$d->nama_sub_urusan}}</td>
										<td>
											<p><b>PN</b> {{$d->nama_pn}}</p>
											<p><b>PP</b> {{$d->nama_pp}}</p>
											<p><b>KP</b> {{$d->nama_kp}}</p>
											<p><b>PROPN</b> {{$d->nama_propn}}</p>
											<p class="text-success"><b>{{$d->nama}}</b></p>
										</td>
										<td>
											<a href="{{route('kebijakan.pusat.tahunan.proyek.indikator.index',['id'=>$d->id])}}" class="btn btn-warning btn-xs">{{$d->jumlah_ind_targeted?$d->jumlah_ind_targeted:0}}/{{$d->jumlah_ind?$d->jumlah_ind:0}} Targeted Indikator</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</thead>
					</table>
					{{$data->links()}}

				</div>
			</div>
		</div>
	</div>



@stop


@section('js')



<script type="text/javascript">
	var data_list=[];

	$('#select-sub').select2();

	var propn_scr=new Vue({
		el:'#propn_scr',
		data:{
			items:[],
			value:0
		},
		methods:{
			change:function(dom){
				
			},
			default:function(){
				this.items=[];

				this.items.push({
					id:0,
					nama:'PILIH PROPN'
				});
				

			}
		}

	});

		var kp_scr=new Vue({
			el:'#kp_scr',
			data:{
				items:[],
				value:0

			},
			methods:{
				change:function(dom){

					API_CON.get('{{route('api.kbt.get.propn')}}',{params:{'id':this.value}}).then(function(res){
						propn_scr.items=res.data;
					});

					console.log('berubah nilai Kp');

					// propn_scr.default();
				},
				default:function(){
					this.items=[];
					this.items.push({
						id:0,
						nama:'PILIH KP'
					});
					

				}
			}

		});
		var pp_scr=new Vue({
			el:'#pp_scr',
			data:{
				items:[],
				value:0
			},
			methods:{
				change:function(dom){

					API_CON.get('{{route('api.kbt.get.kp')}}',{params:{'id':this.value}}).then(function(res){
						kp_scr.items=res.data;
					});
					console.log('berubah nilai pp');


					propn_scr.default();
				},
				default:function(){

					this.items=[];
					this.items.push({
						id:0,
						nama:'PILIH PP'
					});
					

				}
			}

		});

		var pn_scr=new Vue({
			el:'#pn_scr',
			data:{
				items:<?php echo json_encode($master_pn);?>,
				value:0
			},
			watch:{
				items:function(){

					pp_scr.default();
					kp_scr.default();
					propn_scr.default();
					

				}
			},
			methods:{
				change:function(dom){
					

					API_CON.get('{{route('api.kbt.get.pp')}}',{params:{'id':this.value}}).then(function(res){
						pp_scr.items=res.data;
					});


					kp_scr.default();
					propn_scr.default();
					console.log('berubah nilai pn');
					
				},
				init:function() {
					pp_scr.default();
					kp_scr.default();
					propn_scr.default();
					
				}
			}

		});


		var data_list_for_add=$('#container-psn').DataTable({
				'sort':false,
				'columns':[
					{
						data:'id',
						type:'num'

					},
					{
						data:'btn_detail',
						type:'html',
						render:function(data){
							return data.replace(/%22/g,'"');
						}

					},
					{
						data:'btn_add',
						type:'html',
						render:function(data,type,row,meta){
							data=data.replace(/%22/g,'"');
							return data.replace('this',meta.row);

						}
					},
					{
						data:'nama',
						type:'string'

					}
				],
				autoWidth:false,
				 "lengthMenu": [[5, 10], [5,10]],
				// 'createdRow':function (row, data, dataIndex) {
		  //           $(row).attr('class','cursor-link');
		  //           $(row).attr('onclick', 'add_cart(this)');
		  //       },
		        data:[]
			});

		$.fn.dataTable.ext.search.push(
		    function( settings, data, dataIndex ) {

		    	var data=data_list[dataIndex];
		   		var string_id='@'+data.id_pn+'.'+data.id_pp+'.'+data.id_kp+'.'+data.id_propn;
		   		
		   		var filter='@'+(parseInt($('#pn_scr').val())?$('#pn_scr').val():'')+
		   		(parseInt($('#pp_scr').val())?'.'+$('#pp_scr').val():'')+
		   		(parseInt($('#kp_scr').val())?'.'+$('#kp_scr').val():'')+
		   		(parseInt($('#propn_scr').val())?'.'+$('#propn_scr').val():'')+'';

		   		if(filter){
		   			if(string_id.includes(filter)){
		   			return true;
		   		}else{
		   			return false;
		   		}
		   	}else{
		   		return true;
		   	}

		    }
		);

		$('.filter-data').on('change',function(){
			data_list_for_add.draw();
		});


		function showDataSource(){
			if($('#source-psn').hasClass('in')){
				$('#source-psn').collapse('hide');

			}else{
				$('#source-psn').collapse('show');

				
			}
		}

		API_CON.get('{{route('api.kbt.get.psn')}}').then(function(res){
			data_list_for_add.rows.add(res.data);
			data_list=res.data;
			data_list_for_add.draw();
		});

		pn_scr.init();


		function viewDetailPSN(id,e){
			e.preventDefault();
			API_CON.post('{{route('glob.det.psn')}}/'+id).then(function(res){
				console.log(res);
				$('#modal-detail-psn .modal-body').html(res.data);
				$('#modal-detail-psn').modal();

			});

		}

		var cart_list=[];
		function add_card(i){
			if(data_list[i]!=undefined){
				var data=data_list[i];
					
				if(cart_list[data.id]==undefined){
					var dom='<tr>'+
					'<td>'+data.id+'</td>'+
					'<td>'+data.nama+
					'<input type="hidden" value="'+data.id+'" name="proyek_id[]">'+
					'</td>'+
					'<td><button type="button" class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove(); remove_cart_list('+data.id+')"><i class="fa fa-trash"></i></button></td>'+
					'<tr>';

					$('#cart-list').prepend(dom);

					cart_list[data.id]=data;
				}
			}else{

			}
		}

		function remove_cart_list(id){
			delete  cart_list[id];
		}



		
</script>

<div class="modal fade " id="modal-detail-psn">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>

@stop