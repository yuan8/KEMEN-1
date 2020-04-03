@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">

    		<h3 class="text-uppercase"><img src="{{asset($daerah->logo)}}" style="width: 50px;"> INTEGRASI  {{strtoupper($daerah->nama)}} </h3>
    		
    	</div>
    	
    </div>
@stop






@section('content')

<div class="box box-warning">
	<div class="box-header">
		<div class="col-md-2">
			<label>SUB URUSAN</label>
				<select type="text" class=" form-control filter-data" name="sub" v-model='value' v-on:change="change(this)" id="sub_scr">
					<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
					</select>
		</div>
		<div class="col-md-2">
			<label>PROYEK NASIONAL</label>
				<select type="text" class=" form-control filter-data" name="pn" v-model='value' v-on:change="change(this)" id="pn_scr">
					<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
					</select>
		</div>
				<div class="col-md-2">
				<label>PROYEK PRIORITAS</label>

					<select type="text" placeholder="PILIH PP" class=" form-control  filter-data" name="pp" id="pp_scr" v-model='value' v-on:change="change(this)">
						<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
					</select>
				
				</div>
				<div class="col-md-2">
				<label>KEGIATAN PRIORITAS</label>

					<select type="text" class=" form-control  filter-data" name="kp" id="kp_scr" v-model='value' v-on:change="change(this)">
						<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
					</select>
				
				</div>
				<div class="col-md-2">
				<label>PROPN</label>

					<select type="text" class=" form-control  filter-data" name="propn" v-model='value' id="propn_scr"  v-on:change="change(this)">
						<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
					</select>
				</div>
				<div class="col-md-2">
					<label>PROYEK</label>
					<select type="text" class=" form-control  filter-data" name="psn" v-model='value' id="psn_scr"  v-on:change="change(this)">
						<option v-for="i in items " v-bind:value='i.id' >@{{i.nama}}</option>
					</select>
				</div>

	</div>
	<div class="box-body">
		<table class="table table-bordered" id="container-ind">
			<thead>
				<tr>
					<th>
						KODE
					</th>
					<th>
					INDIKATOR
				</th>
				<th>ACTION</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

@stop

@section('js')

<script type="text/javascript">
	var data_list=[];

	// $('#select-sub').select2();

	var psn_scr=new Vue({
		el:'#psn_scr',
		data:{
			items:[],
			value:0
		},
		methods:{
			change:function(dom){
				
			},
			default:function(){
				this.items=[];
				this.value=0;

				this.items.push({
					id:0,
					nama:'PILIH PSN'
				});
				

			}
		}

	});

	var propn_scr=new Vue({
		el:'#propn_scr',
		data:{
			items:[],
			value:0
		},
		methods:{
			change:function(dom){
				psn_scr.default();
				
			},
			default:function(){
				this.items=[];
				this.value=0;

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

					propn_scr.default();
				},
				default:function(){
					this.items=[];
					this.value=0;
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
					psn_scr.default();

				},
				default:function(){

					this.items=[];
					this.value=0;
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
				items:[],
				value:0
			},
			watch:{
				items:function(){

					pp_scr.default();
					kp_scr.default();
					propn_scr.default();
					psn_scr.default();

					

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
				
				default:function(){

					this.items=[];
					this.value=0;
					this.items.push({
						id:0,
						nama:'PILIH PN'
					});
					

				}
			}

		});

		var sub_scr=new Vue({
			el:'#sub_scr',
			data:{
				items:<?php echo json_encode($sub_urusan); ?>,
				value:0
			},
			watch:{
				items:function(){

					pp_scr.default();
					kp_scr.default();
					propn_scr.default();
					psn_scr.default();


					

				}
			},
			methods:{
				change:function(dom){

					API_CON.get('{{route('api.kbt.get.pn')}}',{params:{'id':this.value}}).then(function(res){
						pn_scr.items=res.data;
					});


					kp_scr.default();
					propn_scr.default();
					
				},
				init:function() {
					pn_scr.default();
					pp_scr.default();
					kp_scr.default();
					propn_scr.default();
					psn_scr.default();
					
				}
			}

		});

		sub_scr.init();

		var data_list=[];

			var data_list_for_add=$('#container-ind').DataTable({
				'sort':false,
				'columns':[
					{
						data:'id',
						type:'num'

					},
					{
						data:'uraian',
						type:'string'

					},
					{
						type:'html',
						render:function(data,type,row){
						return '<a href="{{route('integrasi.provinsi.int',['id'=>$daerah->id])}}'+'/'+
							row.id+
							'" target="_blank" class="btn btn-info btn-xs ">DETAIL</a>';
						}

					},
					
					
				],
				autoWidth:false,
				 "lengthMenu": [[5, 10], [5,10]],
	
		        data:[]
			});

		$.fn.dataTable.ext.search.push(
		    function( settings, data, dataIndex ) {

		    	var data=data_list[dataIndex];
		   		var string_id='@'+data.id_pn+'.'+data.id_pp+'.'+data.id_kp+'.'+data.id_propn+'.'+data.id_psn;
		   		
		   		var filter='@'+(parseInt($('#pn_scr').val())?$('#pn_scr').val():'')+
		   		(parseInt($('#pp_scr').val())?'.'+$('#pp_scr').val():'')+
		   		(parseInt($('#kp_scr').val())?'.'+$('#kp_scr').val():'')+
		   		(parseInt($('#propn_scr').val())?'.'+$('#propn_scr').val():'')+
		   		(parseInt($('#psn_scr').val())?'.'+$('#psn_scr').val():'')+'';

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

		API_CON.get('{{route('api.int.get.ind')}}').then(function(res){
			data_list_for_add.rows.add(res.data);
			data_list=res.data;
			data_list_for_add.draw();
		});



		function viewDetailInd(id,e){
			window.location.href='{{route('map.provinsi')}}'+'/'+id;
		}

</script>

@stop