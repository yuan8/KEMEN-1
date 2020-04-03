@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PERMASALAHAN URUSAN  <span class="text-success">{{$daerah->nama}}</span> </h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
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
									<tr>
										<td>
											<button class="btn btn-xs btn-warning">
												<i class="fa fa-edit"></i> Edit
											</button>
										</td>
										<td colspan="1">
											{{$d->pokok_uraian}}
										</td>
										<td colspan="6">
											<button class="btn btn-success btn-xs" onclick="plus_ms.build('Tambah Masalah Daerah','{{$d->pokok_uraian}}','{{route('permasalahan.daerah.store.masalah',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok])}}')">
												<i class="fa fa-plus"></i> Tambah Masalah
											</button>
										</td>
									</tr>
									<?php $id_pokok=$d->id_pokok; ?>
								@endif
								@if(($id_ms!=$d->id_ms)&&(!empty($d->id_ms)))
									<tr class="bg bg-success">
										<td colspan="2"></td>
										<td>
											<button class="btn btn-xs btn-warning">
												<i class="fa fa-edit"></i> Edit
											</button>
										</td>

										<td colspan="1">
											{{$d->ms_uraian}}
										</td>
										<td colspan="4">
											<button class="btn btn-success btn-xs" onclick="plus_ms_akar.build('Tambah Akar Masalah Daerah','{{$d->ms_uraian}}','{{route('permasalahan.daerah.store.akar_masalah',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok,'id_masalah'=>$d->id_ms])}}')">
												<i class="fa fa-plus"></i> Tambah Akar Masalah
											</button>
										</td>
									</tr>
									<?php $id_ms=$d->id_ms; ?>

								@endif
								@if(($id_akar!=$d->id_akar)&&(!empty($d->id_akar)))
									<tr>
										<td colspan="4"></td>
										<td>
											<button class="btn btn-xs btn-warning">
												<i class="fa fa-edit"></i> Edit
											</button>
										</td>
										<td colspan="1">
											{{$d->akar_uraian}}
										</td>
										<td colspan="2">
											<button class="btn btn-success btn-xs" onclick="plus_ms_dt.build('Tambah Data Dukung Daerah','{{$d->akar_uraian}}','{{route('permasalahan.daerah.store.data_dukung',['kode_daerah'=>$daerah->id,'id_ms_pokok'=>$d->id_pokok,'id_masalah'=>$d->id_ms,'íd_akar'=>$d->id_akar])}}')">
												<i class="fa fa-plus"></i> Tambah Data Dukung
											</button>
										</td>
									</tr>
									<?php $id_akar=$d->id_akar; ?>

								@endif
								@if(($id_data!=$d->id_data)&&(!empty($d->id_data)))
									<tr>
										<td colspan="6"></td>
										<td>
											<button class="btn btn-xs btn-warning">
												<i class="fa fa-edit"></i> Edit
											</button>
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



@stop