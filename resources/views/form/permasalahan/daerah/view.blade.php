@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PERMASALAHAN URUSAN  <span class="text-success">{{$daerah->nama}}</span> </h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<button class="btn btn-info btn-xs" style="margin-bottom: 10px;" data-toggle="collapse" data-target="#info-page"><i class="fa fa-info-circle"></i> INFORMASI TERKAIT CARA PENGISIAN</button>
	<div class="box box box-solid bg-green-gradient collapse in"  id="info-page" >
		<div class="box-body text-dark">
			  <p style="text-align: center;"><strong>Kolom Masalah Pokok</strong></p>
			<p style="text-align: center;">Diisi dengan rumusan masalah pokok. Perumusan Masalah pokok merupakan masalah yang bersifat makro bagi daerah, masalah pokok dipecahkan melalui rumusan misi, tujuan dan sasaran</p>
			<p style="text-align: center;"><strong>Kolom Masalah</strong></p>
			<p style="text-align: center;">Diisi dengan rumusan masalah. Perumusan masalah dengan cara mencari beberapa penyebab dari masalah pokok yang lebih spesifik.Pemecahan masalah melalui strategi</p>
			<p style="text-align: center;"><strong>Kolom&nbsp; Akar Masalah</strong></p>
			<p style="text-align: center;">Diisi dengan rumusan akah masalah. Perumusan akar masalah dengan cara mencari beberapa penyebab dari masalah yang lebih rinci. Pemecahan akar masalah melalui arah kebijakan atau kebijakan</p>
		</div>
	</div>
 
	<div class="row">
		<div class="col-md-12">
			<div class="box box-success">
				<div class="box-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th></th>
								<th>MASALAH POKOK</th>
								<th></th>
								<th>MASALAH</th>
								<th></th>
								<th>AKAR MASALAH</th>
								<th></th>
								<th>DATA DUKUNG</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="8" class="bg bg-navy">
									<button class="btn btn-success btn-xs" onclick="plus_pokok.build('Tambah Masalah Pokok','','{{route('permasalahan.daerah.store.masalah_pokok',['kode_daerah'=>$daerah->id])}}',true)">
										<i class="fa fa-plus"></i> Tambah Masalah Pokok
									</button>
								</td>
							</tr>
							<?php 
							$id_pokok=0;
							$id_ms=0;
							$id_akar=0;
							$id_data=0;
							?>
							@foreach($data as $d)
								@if(($id_pokok!=$d->id_pokok)&&(!empty($d->id_pokok)))
										<script type="text/javascript">
											var pokok_{{$d->id_data}}=<?php echo json_encode($d); ?>;
											var pokok_{{$d->id_data}}=pokok_{{$d->id_data}}['pokok_uraian'];
		 								</script>
									<tr>
										<td>
											<div class=" pull-right">
												<button class="btn btn-danger btn-xs" onclick="delete_pokok.build('Hapus Masalah Pokok',pokok_{{$d->id_data}},'{{route('int.permasalahan.delete_masalah_pokok',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok])}}')"><i class="fa fa-trash"></i></button>

												<button class="btn btn-xs btn-warning" onclick="plus_pokok_updated.build('Update Masalah Pokok',pokok_{{$d->id_data}},'{{route('int.permasalahan.update_masalah_pokok',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok])}}')">
												<i class="fa fa-edit"></i> Edit
												
												</button>
											</div>
										</td>
										<td colspan="1">
											{{$d->pokok_uraian}}
										</td>
										<td colspan="6">
											<button class="btn btn-success btn-xs" onclick="plus_ms.build('Tambah Masalah Daerah',pokok_{{$d->id_data}},'{{route('permasalahan.daerah.store.masalah',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok])}}')">
												<i class="fa fa-plus"></i> Tambah Masalah
											</button>
										</td>
									</tr>
									<?php $id_pokok=$d->id_pokok; ?>
								@endif
								@if(($id_ms!=$d->id_ms)&&(!empty($d->id_ms)))
									<script type="text/javascript">
											var ms_{{$d->id_data}}=<?php echo json_encode($d); ?>;
											var ms_{{$d->id_data}}=ms_{{$d->id_data}}['ms_uraian'];
		 								</script>
									<tr class="bg bg-success">
										<td colspan="2"></td>
										<td>
											<div class="pull-right">
												<button class="btn btn-danger btn-xs" onclick="delete_ms.build('Hapus Masalah',ms_{{$d->id_data}},'{{route('int.permasalahan.delete_masalah',['kode_daerah'=>$daerah->id,'id'=>$d->id_ms])}}')"><i class="fa fa-trash"></i></button>

												<button class="btn btn-xs btn-warning" onclick="plus_ms_update.build('Update Masalah',ms_{{$d->id_data}},'{{route('int.permasalahan.update_masalah',['kode_daerah'=>$daerah->id,'id'=>$d->id_ms])}}')">
												<i class="fa fa-edit"></i> Edit
											</button>
											</div>
										</td>

										<td colspan="1">
											{{$d->ms_uraian}}
										</td>
										<td colspan="4">
											<button class="btn btn-success btn-xs" onclick="plus_ms_akar.build('Tambah Akar Masalah Daerah',ms_{{$d->id_data}},'{{route('permasalahan.daerah.store.akar_masalah',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok,'id_masalah'=>$d->id_ms])}}')">
												<i class="fa fa-plus"></i> Tambah Akar Masalah
											</button>
										</td>
									</tr>
									<?php $id_ms=$d->id_ms; ?>

								@endif
								@if(($id_akar!=$d->id_akar)&&(!empty($d->id_akar)))
										<script type="text/javascript">
											var ak_{{$d->id_data}}=<?php echo json_encode($d); ?>;
											var ak_{{$d->id_data}}=ak_{{$d->id_data}}['akar_uraian'];
		 								</script>
									<tr>
										<td colspan="4"></td>
										<td>
											<div class="pull-right">
												<button class="btn btn-danger btn-xs" onclick="delete_ms_akar.build('Hapus Akar Masalah',ak_{{$d->id_data}},'{{route('int.permasalahan.delete_akar_masalah',['kode_daerah'=>$daerah->id,'id'=>$d->id_akar])}}')"><i class="fa fa-trash"></i></button>

												<button class="btn btn-xs btn-warning" onclick="plus_ms_akar_update.build('Update Akar Masalah',ak_{{$d->id_data}},'{{route('int.permasalahan.update_akar_masalah',['kode_daerah'=>$daerah->id,'id'=>$d->id_akar])}}')">
												<i class="fa fa-edit"></i> Edit
											</button>
											</div>
										</td>
										<td colspan="1">
											{{$d->akar_uraian}}
										</td>
										<td colspan="2">
											<button class="btn btn-success btn-xs" onclick="plus_ms_dt.build('Tambah Data Dukung Daerah',ak_{{$d->id_data}},'{{route('permasalahan.daerah.store.data_dukung',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok,'id_masalah'=>$d->id_ms,'íd_akar'=>$d->id_akar])}}')">
												<i class="fa fa-plus"></i> Tambah Data Dukung
											</button>
										</td>
									</tr>
									<?php $id_akar=$d->id_akar; ?>

								@endif
								@if(($id_data!=$d->id_data)&&(!empty($d->id_data)))
								<script type="text/javascript">
									var data_{{$d->id_data}}=<?php echo json_encode($d); ?>;
									var data_{{$d->id_data}}=data_{{$d->id_data}}['data_uraian'];
 								</script>
									<tr>
										<td colspan="6"></td>
										<td>
											<div class="pull-right">
												<button class="btn btn-danger btn-xs" onclick="delete_ms_dt.build('Hapus Data Dukung',data_{{$d->id_data}},'{{route('int.permasalahan.delete_data_dukung',['kode_daerah'=>$daerah->id,'id'=>$d->id_data])}}')"><i class="fa fa-trash"></i></button>
												
												<button class="btn btn-xs btn-warning" onclick="plus_ms_dt_update.build('Update Data Dukung',data_{{$d->id_data}},'{{route('int.permasalahan.update_data_dukung',['kode_daerah'=>$daerah->id,'id'=>$d->id_data])}}')">
													<i class="fa fa-edit"></i> Edit
												</button>
											</div>
										</td>
										<td colspan="1">
											{{$d->data_uraian}}
										</td>
										
									</tr>
									<?php $id_data=$d->id_data; ?>

								@endif

							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			{{$data->links()}}
		</div>
	</div>



@stop


@section('js')

@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'pokok'])


@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'ms'])
@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'ms_akar'])
@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'ms_dt'])

@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'pokok_updated','update'=>true]);
@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'ms_update','update'=>true]);
@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'ms_akar_update','update'=>true]);
@include('form.permasalahan.daerah.partials.vue_modal_tambah_masalah_pokok',['tag'=>'ms_dt_update','update'=>true])







@stop