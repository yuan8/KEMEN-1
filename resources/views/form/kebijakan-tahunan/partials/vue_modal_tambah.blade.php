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
						<div   v-if="source_mode" class="form-group">
							<label>Anggaran</label>
							<input type="number" name="anggaran" v-model="anggaran" class="form-control" required="" min="0">
						</div>
				</div>
				<div class="modal-footer">
						<button v-if="source_mode" type="button" onclick="plus_{{$tag}}.source?plus_{{$tag}}.source=false:plus_{{$tag}}.source=true;" class="btn btn-sm btn-info">
							<i class="fa fa-plus"></i> Tambah DB
						</button>
						<button type="submit" class="btn btn-sm btn-warning">
							<i class="fa fa-plus"></i> Tambah
						</button>
				</div>

			</form>
		</div>
	</div>
</div>


<script type="text/javascript">
	var plus_{{$tag}}=new Vue({
		el:'#plus_{{$tag}}',
		data:{
			title_modal:'',
			uraian:'',
			parent:'',
			action:'',
			source:false,
			source_mode:false,
			action_source:'',
			anggaran:'',

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
				              url: this.action_source,
				              dataType: 'json',
				              headers:{
				                Authorization:TOKEN_KN
				              }
				        }
					});

				},300);
			},
			build:function(title_modal,parent,link,link_source=null){
				this.action=link;
				this.uraian='';
				this.title_modal=title_modal;
				this.parent=parent;
				this.action_source=link_source;
				this.anggaran=0;

				
				if(link_source!=null){
					this.source=true;
					this.source_mode=true;
				}else{
					this.source=false;
				}

	
				
				setTimeout(function(){

					$('#permasalahan_source_{{$tag}}').val(null);
					$('#permasalahan_source_{{$tag}}').select2({
						ajax: {
				              url: link_source,
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
