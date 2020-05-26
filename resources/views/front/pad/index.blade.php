
@extends('adminlte::page_front')

@section('content_header')
     <div class="row">
    	<div class="col-md-12">
    		<h3 class="text-uppercase text-center"> PAD 2010 - 2020</h3>
    	</div>
    </div>
   
    <?php
?>
<style type="text/css">
	table tr th,table tr td{
		font-size: 10px;
	}
</style>
@stop

@section('content')
	<div class="row container">
		<form action="{{url()->current()}}" method="get">
			<div class="col-md-4">
			<div class="form-group">
				<label>PROVINSI</label>
				<select class="form-control" id="provinsi_select" name="provinsi">
					<option value="">- NASIONAL -</option>
					@foreach($provinsi as $p)

						<option value="{{$p->id}}" {{isset($_GET['provinsi'])?($_GET['provinsi']==$p->id?'selected':''):''}}>{{strtoupper($p->nama)}}</option>
					
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>KOTA / KAB</label>
				<select class="form-control" id="kota_select" name=daerah>
					<option value="">- SELURUH KOTA KABUPATEN  DAN PROVINSI-</option>
					@foreach($provinsi as $p)
						<option value="{{$p->id}}">{{strtoupper($p->nama)}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<label>ACTION</label>
			<br>
			<button type="submit" id="btn_select" class="btn btn-primary">SUBMIT</button>
		</div>
		</form>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box-warning box">
				<div class="box-body table-responsive">
					<table class="table table-bordered" id="table_data">
							<thead>
								<tr>
									<th colspan="3">AKUN</th>
									<?php 
									for ($i=2010; $i <=2020 ; $i++) { 
									?>
							    		<th colspan="3" >TAHUN {{$i}}</th>
							    	<?php } ?>
									
								</tr>
								<tr>
									<th>BIDANG</th>
									<th>SUB BIDANG</th>
									<th>SUB SUB BIDANG</th>

									<?php
									for ($i=2010; $i <=2020 ; $i++) { 
									?>
							    		<th >ANGGARAN {{$i}}</th>
										<th >REALISASI {{$i}}</th>
										<th >PERSENTASE REALISASI ANGGARAN {{$i}}</th>
							    	<?php } ?>

								</tr>
							</thead>
						<tbody>

							@foreach($data as $d)

							<tr>

								@if(($d['kat_akun']=='')OR($d['kat_akun']==null))

								<td></td>
								<td></td>
								<td>{{$d['nama']}}</td>
								@elseif($d['kat_akun']=='SUB_BIDANG')

								<td></td>
								<td class="bg-yellow">{{$d['nama']}}</td>

								<td></td>

								@else

								<td class="bg-primary">{{$d['nama']}}</td>
								<td></td>
								<td></td>

								@endif
								@foreach($d['tahun'] as $dt)
								<td class="bg-info">{{number_format($dt['total_anggaran'],2)}}</td>
								<td class="bg-success">{{number_format($dt['total_realisasi'],2)}}</td>
								<td class="bg-warning">{{number_format($dt['total_realisasi_persentase'],2)}}%</td>



								@endforeach

							</tr>

							@endforeach

							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


@stop

@section('js')

<script type="text/javascript">
	var kota_selected="{{isset($_GET['daerah'])?$_GET['daerah']:''}}";
	$(function(){

	$('#provinsi_select').on('change',function(){
		$('#btn_select').css('display','none');
		API_CON.post("{{route('pad.api.kode_daerah')}}",{'provinsi':this.value}).then(function(res){
			var dom='';

			for(var i in res.data){
				var nama=res.data[i].nama+'';
				console.log(nama);
				dom+='<option value="'+res.data[i].id+'" '+(kota_selected==res.data[i].id?'selected':'')+' >'+(nama).toUpperCase()+'</option>';
			}

			$('#kota_select').html(dom);
			$('#kota_select').val('');
			if((kota_selected!='')){
				$('#kota_select').val(kota_selected);

				kota_selected='';
			}else{
				console.log('s');
			$('#kota_select').val(res.data[0].id);
			$('#kota_select [value="'+res.data[0].id+'"').attr('selected',true);


			}

			$('#btn_select').css('display','block');


		});
	});

	$('#provinsi_select').trigger('change');



	 $('#table_data').DataTable( {
	 	sort:false,
	 	 "paging": false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
});





</script>
@stop