<form action="{{route('int.kb5tahun.kondisi.update',['id'=>$kondisi['id']])}}" method="post">
	@csrf
	@method('PUT')
	@php
	$domid=rand(0,1000).date('i');
	@endphp
{{-- 			<small>
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
		  <input type="text" class="form-control" placeholder="000" name="kode" required="" id="kode-check-unique-{{$domid}}" aria-describedby="basic-addon1" value="{{str_replace(Hp::fokus_urusan()['singkat'].'.KN.','',$kondisi['kode'])}}">
		</div>
		</div>
	</div> --}}
	<div class="form-group">
		<label>URAIAN KONDISI {{Hp::fokus_tahun()}}</label>
		<textarea class="form-control" name="uraian" style="min-height: 70px;" required="">{!!$kondisi['uraian']!!}</textarea>
	</div>
	{{-- <hr> --}}
{{-- 	<div class="box box-solid ">
		<div class="box-header with-border">
			<label>TIPE DATA</label>
			<select class="form-control" name="tipe_value" required="" id="check-tipe-data-{{$domid}}" target='#input-nilai-{{$domid}}'>
				<option value="1" {{$kondisi['tipe_value']==1?'selected':''}}>NUMERIC</option>
				<option value="0" {{$kondisi['tipe_value']==0?'selected':''}}>TEXT / STRING</option>
			</select>
		</div>
		<div class="box-body">
			<div class="form-group">
				<label>TAHUN DATA</label>
				<select class="form-control" name="tahun_data">
					<option value="">-- TAHUN DATA --</option>
					@php
					for($i=Hp::fokus_tahun()-1;$i>(Hp::fokus_tahun()-5);$i--){
					@endphp
						<option value="{{$i}}" {{$kondisi['tahun_data']==$i?'selected':''}}>{{$i}}</option>
					@php

				}

					@endphp
				</select>
			
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label>NILAI</label>
						<input id="input-nilai-{{$domid}}" type="number" step="0.001" class="form-control" name="nilai" required="" value="{{$kondisi['nilai']}}">
					</div>
				</div>
			
			</div>
			<div class="form-group">
				<label>SATUAN</label>
				<select class="form-control" name="satuan" required="">
					@foreach($satuan as $s)
						<option value="{{$s}}" {{$kondisi['satuan']==$s?'selected':''}}>{{$s}}</option>
					@endforeach


				</select>
			
			</div>
		</div>
	</div> --}}

	<hr>
	<button class="btn btn-warning btn-xs">UPDATE</button>

{{-- 	<script type="text/javascript">
		
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
 --}}

</form>