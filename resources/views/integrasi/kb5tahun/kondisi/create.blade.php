<form action="{{route('int.kb5tahun.store')}}" method="post">
	@csrf

	@php
	$domid=rand(0,1000).date('i');
	@endphp
	{{-- 		<small>
				<b>* KODE DATA : </b>
				<br>
				kode digunakan untuk merefrensikan kondisi pada tahun sebelumnya dan tahun sesudahnya.
				<br>
				jika anda memiliki kode data pada tahun sebelumnya mohon untuk menyamakan kode
				<br>
				jika anda tidak memiliki kode pada data sebelumnya silahkan untuk membuat kode unique sendiri contoh <b>({{Hp::fokus_urusan()['singkat'].'.KN.'}}.0001)</b>
			</small>
			<hr>
			<div class="form-group">
			<label>KODE <span id="kode-check-unique-{{$domid}}-text"></span></label>
			<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">{{Hp::fokus_urusan()['singkat'].'.KN.'}}</span>
		  <input type="text" class="form-control" placeholder="000" name="kode" required="" id="kode-check-unique-{{$domid}}" aria-describedby="basic-addon1">
		</div>
		</div>
	</div> --}}
	<div class="form-group">
		<label>URAIAN KONDISI {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required=""></textarea>
	</div>
	<hr>
	<div class="box box-solid ">
		<div class="box-header with-border">
			<label>TIPE DATA</label>
			<select class="form-control" name="tipe_value" required="" id="check-tipe-data-{{$domid}}" target='#input-nilai-{{$domid}}'>
				<option value="1">NUMERIC</option>
				<option value="0">TEXT / STRING</option>
			</select>
		</div>
		<div class="box-body">
			<div class="form-group">
				<label>TAHUN DATA</label>
				<select class="form-control" name="tahun_data" required="">
					<option value="">-- TAHUN DATA --</option>
					<option value="{{Hp::fokus_tahun()-1}}">{{Hp::fokus_tahun()-1}}</option>
					<option value="{{Hp::fokus_tahun()-2}}">{{Hp::fokus_tahun()-2}}</option>
					<option value="{{Hp::fokus_tahun()-3}}">{{Hp::fokus_tahun()-3}}</option>
					<option value="{{Hp::fokus_tahun()-4}}">{{Hp::fokus_tahun()-4}}</option>
					<option value="{{Hp::fokus_tahun()-5}}">{{Hp::fokus_tahun()-5}}</option>
				</select>
			
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label>NILAI</label>
						<input id="input-nilai-{{$domid}}" type="number" step="0.001" class="form-control" name="nilai" required="">
					</div>
				</div>
			
			</div>
			<div class="form-group">
				<label>SATUAN</label>
				<select class="form-control" name="satuan" required="">
					@foreach($satuan as $s)
						<option value="{{$s}}">{{$s}}</option>
					@endforeach


				</select>
			
			</div>
		</div>
	</div>

	<hr>
	<button class="btn btn-success btn-xs">TAMBAH</button>

	<script type="text/javascript">
		
		$('#check-tipe-data-{{$domid}}').on('change',function(){
			var target=$(this).attr('target');
			var type='number';
			console.log(this.value);
			switch(parseInt(this.value)){
				case 0:
				 type='text';
				break;
				case 1:

				 type='number';
				break;


			}

			console.log(type);
		
			$(target).attr('type',type);
		});



		$('#check-tipe-data-{{$domid}}').trigger('change');


	</script>


</form>