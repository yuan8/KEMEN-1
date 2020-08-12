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
						<div class="form-group">
							<label>Uraian</label>
							<textarea class="form-control" required="" v-model='uraian' name="uraian"></textarea>
						</div>
						<div v-if="show_anggaran" class="form-group">
							<label>Anggaran</label>
							<input type="number" name="anggaran" v-model="anggaran" class="form-control" required="" min="0">
						</div>
				</div>
				<div class="modal-footer">
					
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
			anggaran:'',
			show_anggaran:true
		},
		methods:{
			
			build:function(title_modal,parent,link,show_anggaran=true){
				this.action=link;
				this.uraian='';
				this.title_modal=title_modal;
				this.parent=parent;
				
				this.anggaran=0;
				this.show_anggaran=show_anggaran;
				setTimeout(function(){
					$('#plus_{{$tag}}').modal();
				},300);

						
			}
		}
	});


</script>
