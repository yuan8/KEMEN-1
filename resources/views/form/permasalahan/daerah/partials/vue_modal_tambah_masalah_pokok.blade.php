<div class="modal fade" id="plus_{{$tag}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form v-bind:action='action' method="post">
				@csrf

				<div class="modal-header">
					<h5 class="text-center"><b>@{{title_modal}}</b></h5>
				</div>
				<div class="modal-body">
						<div class="form-group" v-if="parent!=''">
							<p>@{{parent}}</p>
							<hr>
						</div>
						<div class="form-group" v-if="!source">
							<label>Uraian</label>
							<textarea class="form-control" required="" v-model='uraian' name="uraian"></textarea>
						</div>

						<div v-if="source">
						<div class="form-group" >
							<label>Uraian</label>
							<select class="form-control" required="" v-model="uraian" id="permasalahan_source_{{$tag}}" name="uraian"></select>
						</div>

						</div>
				</div>
				<div class="modal-footer">
						<button v-if="source_mode" type="button" onclick="plus_pokok.source?plus_pokok.source=false:plus_pokok.source=true;" class="btn btn-sm btn-info">
							<i class="fa fa-plus"></i> Tambah DB
						</button>
						<button type="submit" class="btn btn-sm btn-warning">
							<i class="fa fa-plus"></i> {{isset($update)?'UPDATE':'TAMBAH'}}
						</button>
				</div>

			</form>
		</div>
	</div>
</div>
	@if(!isset($update))
<div class="modal fade" id="delete_{{$tag}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<form v-bind:action='action' method="post">
				@csrf

				<div class="modal-header">
					<h5 class="text-center"><b>@{{title_modal}}</b></h5>
				</div>
				<div class="modal-body">
					<h5 class="text-center">KONFIRMASI PENGHAPUSAN</h5>
					<hr>
						<div class="form-group" v-if="parent!=''">
							<p>@{{parent}}</p>
							<hr>
						</div>
						
				</div>
				<div class="modal-footer">
						
						<button type="submit" class="btn btn-sm btn-danger">
							<i class="fa fa-trah"></i> SETUJU
						</button>
				</div>

			</form>
		</div>
	</div>
</div>
@endif



<script type="text/javascript">

	@if(!isset($update))
	var delete_{{$tag}}=new Vue({
		el:'#delete_{{$tag}}',
		data:{
			title_modal:'',
			parent:'',
			action:'',
		},
		methods:{
			build:function(title_modal,parent,link){
				this.action=link;
				this.title_modal=title_modal;
				this.parent=parent;

				setTimeout(function(){
					$('#delete_{{$tag}}').modal();
				},400);

			}
		}
	});


	@endif

	var plus_{{$tag}}=new Vue({
		el:'#plus_{{$tag}}',
		data:{
			title_modal:'',
			uraian:'',
			parent:'',
			action:'',
			source:false,
			source_mode:false
		},
		watch:{
			source:function(new_data,old_data){
				this.uraian=null;
				this.buildselect();
			}
		},
		methods:{
			buildselect:function(){
				setTimeout(function(){
					$('#permasalahan_source_{{$tag}}').val(null);
					$('#permasalahan_source_{{$tag}}').select2({
						ajax: {
				              url: '{{route('api.permasalahan.daerah.get.masalah.pokok')}}',
				              dataType: 'json',
				              headers:{
				                Authorization:TOKEN_KN
				              }
				        }
					});

				},300);
			},
			build:function(title_modal,parent,link,source_mode=false){
				this.action=link;
				this.uraian={{isset($update)?'parent':'null'}};
				this.title_modal=title_modal;
				this.parent=parent;
				this.source_mode=source_mode;
				if((title_modal=='Tambah Masalah Pokok')||(title_modal=='Update Masalah Pokok')){
					this.source=true;


				}else{
					this.source=false;
				}



	
				
				setTimeout(function(){

					$('#permasalahan_source_{{$tag}}').val(null);
					if(title_modal=='Update Masalah Pokok'){
						$('#permasalahan_source_{{$tag}}').html('<option selected value="'+parent+'">'+parent+'</option>');
						$('#permasalahan_source_{{$tag}}').val(parent);
						$('#permasalahan_source_{{$tag}}').trigger('change');
					}
				
					$('#permasalahan_source_{{$tag}}').select2({
						ajax: {
				              url: '{{route('api.permasalahan.daerah.get.masalah.pokok')}}',
				              dataType: 'json',
				              headers:{
				                Authorization:TOKEN_KN
				              }
				        }
					});


					$('#plus_{{$tag}}').modal();
				},400);
			}
		}
	});


</script>
