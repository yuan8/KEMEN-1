@php
	if($tag==1){

		$route=route('int.kb5tahun.indikator.store',['id'=>$ak_kondisi['id']]);
		$pre_ind=$meta_urusan['singkat'].'.'.'RKP'.'.'.'IND.';
	}
	else if($tag==2){
		$route=route('int.m.indikator.store');;
		$pre_ind=Hp::pre_ind($tag);
		

	}
	else if($tag==3){
		$route=route('int.m.indikator.store');;
		$pre_ind=Hp::pre_ind($tag);

	}
	else if($tag==0)
	{

		$route=route('int.m.indikator.store');
		$pre_ind='';

	}

	
	
@endphp

<div class="row">
	<form action="{{$route}}" method="post">
	<style type="text/css">
		
	</style>
	@if($tag==2)
	<input type="hidden" name="id_rkp" value="{{$rkp['id']}}" >
	@endif
	<div class="col-md-12" style="max-height: calc(70vh); overflow-y: scroll; overflow-x: hidden;">
		@csrf

		@php
		$domid=rand(0,1000).date('i');
		@endphp
			@if($tag==0)
			<div class="row">
				<div class="col-md-6 form-group">
				<label>SUMBER INDIKATOR</label>
				<select class="form-control init-use-select2" name="tag">
					<option value="1">RPJMN</option>
					<option value="2">RKP</option>
					<option value="3">KL</option>
				</select>
			</div>
			</div>
			@else
				<input type="hidden" name="tag" value="{{$tag}}">
				@if(in_array($tag, [3,2]))
					<input type="hidden" name="for_api" value="ya">
				@endif
				@if($tag==3)
					<input type="hidden" name="id_sub_urusan" value="{{$only_sub_urusan}}">
				@endif

			@endif
			@if(in_array($tag,[0,1,2]))
			<div class="form-group">
					<label>SUB URUSAN *</label>
					<select class="form-control init-use-select2" name="id_sub_urusan" required="" >
						@foreach($sub_urusan as $sub)
						@php 
							$sub=(array)$sub;
						@endphp
							<option value="{{$sub['id']}}">{{$sub['nama']}}</option>
						@endforeach
					</select>
				</div>

			@endif

		<div class="form-group">
			<label>URAIAN INDIKATOR {{Hp::fokus_tahun()}} *</label>
			<textarea class="form-control" name="uraian" style="min-height: 70px;" required=""></textarea>
		</div>
		<hr>
		<div class="box box-solid ">
			<div class="box-header with-border">
				<label>TIPE DATA *</label>
				<select class="form-control init-use-select2" name="tipe_value" required="" id="check-tipe-data-{{$domid}}" target='#input-nilai-{{$domid}}'>
					<option value="1">NUMERIC</option>
					<option value="0">TEXT / STRING</option>
					<option value="2">NUMERIC - RENTANG NILAI</option>
				</select>
			</div>
			<div class="box-body">
				

				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
								<div class="row">
								<div class="col-md-12">
									<label>TARGET *</label>
									<input id="input-nilai-{{$domid}}" type="number" step="0.001" class="form-control" name="target" required="">
								</div>
							</div>
						</div>
						<div class="col-md-6" style="display: none;" id="rentang-nilai-{{$domid}}">
								<div class="row">
								<div class="col-md-12">
									<label>RENTANG TARGET NILAI MAXIMAL</label>
									<input  type="number" step="0.001" class="form-control" name="target_1" >
								</div>
							</div>
						</div>
						<div class="col-md-6">
								<div class="form-group">
						<label>SATUAN *</label>
						<select class="form-control dinamic-select-2" name="satuan" required="">
							@foreach($satuan as $s)

								<option value="{{$s}}">{{$s}}</option>
							@endforeach


						</select>
					
				</div>
						</div>
					</div>
				
				</div>
			
				<div class="row">
					<div class="col-md-12">
							<p class="text-center text-upppercase"><b>KEWENANGAN </b></p>
							<hr>
							<table class="table table-bordered bg-white">
								<tr class="bg-navy">
									<th>PUSAT</th>
									<th>PROVINSI</th>
									<th>KOTA / KAB</th>

								</tr>
								<tr >
									<th><input type="checkbox" target-toggle-checkbox-dss=".kw-nas-{{$domid}}" class="bt-toggle-init" name="kw_nas" data-toggle="toggle" data-on="BERWENANG" data-off="TIDAK " data-width="100%" data-size="small" data-onstyle="success" data-offstyle="danger"></th>
									<th><input type="checkbox" target-toggle-checkbox-dss=".kw-p-{{$domid}}" class="bt-toggle-init" name="kw_p" data-toggle="toggle" data-on="BERWENANG" data-off="TIDAK " data-width="100%" data-size="small"  data-onstyle="success" data-offstyle="danger"></th>
									<th><input type="checkbox" target-toggle-checkbox-dss=".kw-k-{{$domid}}" class="bt-toggle-init" name="kw_k" data-toggle="toggle" data-on="BERWENANG" data-off="TIDAK " data-width="100%" data-size="small" data-onstyle="success" data-offstyle="danger">
									</th>

								</tr>
								<tr>
									<th>URAI KEWENANGAN PUSAT</th>
									<th>URAI KEWENANGAN PROVINSI</th>
									<th>URAI KEWENANGAN KOTA / KAB</th>


								</tr>
								<tr>
									<td>
										<textarea class="form-control kw-nas-{{$domid}}" name="kewenangan_nas"></textarea>
									</td>
									<td>
										<textarea class="form-control kw-p-{{$domid}}" name="kewenangan_p"></textarea>
									</td>
									<td>
										<textarea class="form-control kw-k-{{$domid}}" name="kewenangan_k"></textarea>
									</td>
								</tr>
								<tr>
									<th>PELAKSANA PUSAT</th>
									<th>PELAKSANA PROVINSI</th>
									<th>PELAKSANA KOTA / KAB</th>
								</tr>
								<tr>
									<td>
										<div class="kw-nas-{{$domid}}"> 
											<select class="form-control pelaksana " multiple="" name="pelaksana_nas[]"></select>
										</div>

									</td>
									<td>
										<div class="kw-p-{{$domid}}"> 
											<select class="form-control pelaksana " multiple="" name="pelaksana_p[]"></select>
										</div>
									</td>
									<td>
										<div class="kw-k-{{$domid}}"> 
											<select class="form-control pelaksana " multiple="" name="pelaksana_k[]"></select>
										</div>

									</td>
								</tr>
								<tr>
									<th>DATA DUKUNG PUSAT</th>
									<th>DATA DUKUNG PROVINSI</th>
									<th>DATA DUKUNG KOTA / KAB</th>
								</tr>
								<tr>
									<td>
										<textarea class="form-control kw-nas-{{$domid}}"  name="data_dukung_nas"   style="min-height: 100px;" ></textarea>
									</td>
									<td>
										<textarea class="form-control kw-p-{{$domid}}"  name="data_dukung_p"   style="min-height: 100px;" ></textarea>
									</td>
									<td>
										<textarea class="form-control kw-k-{{$domid}}"  name="data_dukung_k"   style="min-height: 100px;" ></textarea>
									</td>
								</tr>
							</table>
							
						</div>
					
					</div>

						<hr>
					<p class="text-center text-upppercase"><b>INFORMASI TAMBHAAN </b></p>
					
				<hr>
				<div class="form-group">
					<label>Lokus</label>
					<textarea class="form-control" name="lokus"></textarea>
				</div>
				<small>
						* Informasi ini bersifat tidak wajib pada form ini
						<br>
				</small>
				
				<small>
					* keterangan indikator dapet berisi cara perhitungan dan catatan-catatan lain-lain
				</small>
				<div class="form-group">
					<label>KETERANGAN</label>
					<textarea class="form-control" name="keterangan" style="min-height: 70px;" ></textarea>
				</div>

				</div>
			</div>


	</div>
	<hr>
	<hr>
	<div class="col-md-12">
	<button  class="btn btn-success btn-xs" style="margin-top: 15px;">TAMBAH</button>
		
	</div>

	



	<script type="text/javascript">
		$('.bt-toggle-init').bootstrapToggle();
		$('#check-tipe-data-{{$domid}}').on('change',function(){
			var target=$(this).attr('target');
			var type='number';

			var rentang=false;

			switch(parseInt(this.value)){
				case 0:
				 type='text';
				 rentang=false;
				break;
				case 1:
				 type='number';
				 rentang=false;
				break;
				case 2:
				 type='number';
				 rentang=true;
				break;


			}

			if(rentang){
				$('#rentang-nilai-{{$domid}}').css('display','block');
				$('#rentang-nilai-{{$domid}} input').attr('required','true');
			}else{
				$('#rentang-nilai-{{$domid}}').css('display','none');
				$('#rentang-nilai-{{$domid}} input').removeAttr('required');


			}

		
			$(target).attr('type',type);
		});



		$('#check-tipe-data-{{$domid}}').trigger('change');


		$('[target-toggle-checkbox-dss]').on('change',function(){
			if($(this).prop('checked')){
				$($(this).attr('target-toggle-checkbox-dss')).css('display','block');
			}else{
				$($(this).attr('target-toggle-checkbox-dss')).css('display','none');

			}
		});


			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('.pelaksana').each(function(){
				$(this).select2({
				    tags:true,

					// minimumResultsForSearch:2,
	                dropdownParent: $(this).parent(),
            	});


			});
        	$('.init-use-select2').select2();

			$('.dinamic-select-2').each(function () {
				$(this).select2({
			    tags:true,

				// minimumResultsForSearch:2,
                dropdownParent: $(this).parent(),
				  ajax: {
				    url: "{{route('api.global.listing-satuan')}}",
				    dataType: 'json',
				    delay: 250,
                	
				    data: function (params) {
				      return {
				        q: params.term, // search term
				        page: params.page
				      };
				    },
				    processResults: function (data, params) {
				      // parse the results into the format expected by Select2
				      // since we are using custom formatting functions we do not need to
				      // alter the remote JSON data, except to indicate that infinite
				      // scrolling can be used
				      params.page = params.page || 1;

				      return {
				        results: data.data,
				        pagination: {
				          more: (params.page) < data.last_page
				        }
				      };
				    },
				    cache: true
				  },
				  placeholder: 'Search for a repository',

				});


               
            });

		$("[target-toggle-checkbox-dss]").trigger('change');


	</script>

</form>
</div>