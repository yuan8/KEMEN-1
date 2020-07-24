<form action="{{route('int.kb5tahun.indikator.update',['id'=>$indikator['id']])}}" method="post">
	<div class="col-md-12" style="max-height: calc(70vh); overflow-y: scroll; overflow-x: hidden;">
		@csrf
		@method('PUT')
		@php
		$domid=rand(0,1000).date('i');
		@endphp
			<small>
				<b>* KODE INDIKATOR : </b>
				<br>
				kode digunakan sebagai id unique pada sebuah indikator.
				<br>
				id indikator dapat merepresentasikan kondisi yang ada 
				<br>
				contoh penulisan kode indikator <b>({{$ak_kondisi['kode']}}.IND.0001)</b>
			</small>
			<hr>
			<div class="form-group">
				<label>KODE * <span id="kode-check-unique-{{$domid}}-text"></span></label>
				<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1">{{$ak_kondisi['kode']}}.IND.</span>
				  <input type="text" class="form-control" placeholder="000" name="kode" required="" id="kode-check-unique-{{$domid}}" aria-describedby="basic-addon1" value="{{$indikator['kode_realistic']}}">
				</div>
				
			</div>
			<div class="form-group">
					<label>SUB URUSAN *</label>
					<select class="form-control" name="id_sub_urusan" required="" >
						@foreach($sub_urusan as $sub)
							<option value="{{$sub['id']}}" {{$sub['id']==$indikator['id_sub_urusan']?'selected':''}}>{{$sub['nama']}}</option>
						@endforeach
					</select>
				</div>

		<div class="form-group">
			<label>URAIAN INDIKATOR {{Hp::fokus_tahun()}} *</label>
			<textarea class="form-control" name="uraian" style="min-height: 70px;" required="">{!!$indikator['uraian']!!}</textarea>
		</div>
		<hr>
		<div class="box box-solid ">
			<div class="box-header with-border">
				<label>TIPE DATA *</label>
				<select class="form-control" name="tipe_value" required="" id="check-tipe-data-{{$domid}}" target='#input-nilai-{{$domid}}'>
					<option value="1" {{1==$indikator['tipe_value']?'selected':''}}>NUMERIC</option>
					<option value="0"  {{0==$indikator['tipe_value']?'selected':''}}>TEXT / STRING</option>
					<option value="2"  {{2==$indikator['tipe_value']?'selected':''}}>NUMERIC - RENTANG NILAI</option>
				</select>
			</div>
			<div class="box-body">
				

				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
								<div class="row">
								<div class="col-md-12">
									<label>TARGET *</label>
									<input id="input-nilai-{{$domid}}" type="{{0!=$indikator['tipe_value']?'number':'text'}}" step="0.001" class="form-control" name="target" required="" value="{{$indikator['target']}}">
								</div>
							</div>
						</div>
						<div class="col-md-6" style="display: none;" id="rentang-nilai-{{$domid}}">
								<div class="row">
								<div class="col-md-12">
									<label>RENTANG TARGET NILAI MAXIMAL</label>
									<input  type="number" step="0.001" class="form-control" name="target_1" value="{{$indikator['target_1']}}" >
								</div>
							</div>
						</div>
					</div>
				
				</div>
				<div class="form-group">
						<label>SATUAN *</label>
						<select class="form-control" name="satuan" required="">
							@foreach($satuan as $s)
								<option value="{{$s}}" {{$s==$indikator['satuan']?'selected':''}} >{{$s}}</option>
							@endforeach


						</select>
					
				</div>
					<div class="row">
						<div class="col-md-9">
							<p class="text-center text-upppercase"><b>KEWENANGAN </b></p>
						<hr>
							<div class="row">
								<div class="col-md-4">
									<p><b>PUSAT</b></p>
									<input type="checkbox" target-toggle-checkbox-dss="#kw-nas-data-dukung-{{$domid}}" {{$indikator['kw_nas']?'checked':''}} class="bt-toggle-init" name="kw_nas" data-toggle="toggle" data-on="BERWENANG" data-off="TIDAK " data-width="100%" data-size="small" data-onstyle="success" data-offstyle="danger">
									<div id="kw-nas-data-dukung-{{$domid}}" style="margin-top: 10px;">
										<label>DATA DUKUNG TERKAIT KEWENANGAN PUSAT</label>
										<textarea class="form-control "  name="data_dukung_nas"   style="min-height: 100px;" >{!!$indikator['data_dukung_nas']!!}</textarea>
									</div>
								</div>
								<div class="col-md-4">
									<p><b>PROVINSI</b></p>
									<input type="checkbox" target-toggle-checkbox-dss="#kw-p-data-dukung-{{$domid}}" {{$indikator['kw_p']?'checked':''}} class="bt-toggle-init" name="kw_p" data-toggle="toggle" data-on="BERWENANG" data-off="TIDAK " data-width="100%" data-size="small"  data-onstyle="success" data-offstyle="danger">
									<div id="kw-p-data-dukung-{{$domid}}" style="margin-top: 10px;">
										<label>DATA DUKUNG TERKAIT KEWENANGAN PROVINSI</label>
										<textarea class="form-control "  name="data_dukung_p"  style="min-height: 100px;" >{!!$indikator['data_dukung_p']!!}</textarea>
									</div>
								</div>
								<div class="col-md-4">
									<p><b>KOTA/KABUPATEN</b></p>
									<input type="checkbox" target-toggle-checkbox-dss="#kw-k-data-dukung-{{$domid}}" {{$indikator['kw_k']?'checked':''}} class="bt-toggle-init" name="kw_k" data-toggle="toggle" data-on="BERWENANG" data-off="TIDAK " data-width="100%" data-size="small" data-onstyle="success" data-offstyle="danger">
									<div id="kw-k-data-dukung-{{$domid}}" style="margin-top: 10px;">
										<label>DATA DUKUNG TERKAIT KEWENANGAN KOTA/KAB</label>
										<textarea class="form-control " name="data_dukung_k" style="min-height: 100px;" >{!!$indikator['data_dukung_k']!!}</textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<p class="text-center text-upppercase"><b>PELAKSANA </b></p>
							<hr>

								<small>* pisahkan setiap pelaksana dengan tanda <b>@</b> di ikuti nama perlaksana  dan <b>_</b> untuk sepasi<br>
									<b>CONTOH :</b>
									<br>
									<b>@KEMENTRIAN_A </b>
									<br>
									<b>@KEMENTRIAN_B </b>

								</small>
								<br>
								<textarea class="form-control" name="pelaksana" required="">{!!$indikator['pelaksana']!!}</textarea>
							
						</div>
					</div>

						<hr>
					<p class="text-center text-upppercase"><b>INFORMASI TAMBHAAN </b></p>
					
				<hr>
				<small>
						* Informasi ini bersifat tidak wajib pada form ini
						<br>
						
				</small>
				
				<small>
					* keterangan indikator dapet berisi cara perhitungan dan catatan catatan lain-lain
				</small>
				<div class="form-group">
					<label>KETERANGAN</label>
					<textarea class="form-control" name="keterangan" style="min-height: 70px;" >{!!$indikator['keterangan']!!}</textarea>
				</div>

				</div>
			</div>


	</div>
	<hr>
	<hr>

	<button class="btn btn-warning btn-xs" style="margin-top: 15px;">UPDATE</button>

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
			console.log($(this).prop('checked'));
			if($(this).prop('checked')){
				$($(this).attr('target-toggle-checkbox-dss')).css('display','block');
			}else{
				$($(this).attr('target-toggle-checkbox-dss')).css('display','none');

			}
		});

		$("[target-toggle-checkbox-dss]").trigger('change');


	</script>


</form>