@extends('adminlte::page')


@section('content_header')
 <div class="row">
    	<div class="col-md-12">
    		<h3 class="text-uppercase">DATA PELAKSANAAN  SUBURUSAN  </h3>
    		<small><span class="text-warning">
    			{{$sub->nama}}
    		</span> </small>
    		
    	</div>
    	
    </div>
    
@stop

@section('content')
<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>SUMBER DATA</th>
								<th>INDIKATOR</th>
								<th></th>
								<th>DATA</th>

							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td colspan="4" class="bg bg-navy">
									<button class="btn btn-warning btn-xs" onclick="plus_indikator.build('Tambah Indikator','','{{route('pelaksanaan.urusan.store.indikator',['id_sub'=>$sub->id])}}')">
										<i class="fa fa-plus"></i> Tambah Indikator
									</button>
								</td>
							</tr>
							<?php
								$plu_id=0;
								$plud_id=0;

							 ?>
							@foreach($data as $d)
								@if(($d->plu_id!=$plu_id)&&(!empty($d->plu_id)))
									<tr class="bg bg-warning">
										<td>
											<button class="btn btn-info btn-xs">
												<i class="fa fa-down"></i> Detail
											</button>

										</td>
										<td class="pull-right">
											<button class="btn btn-warning btn-xs">
												<i class="fa fa-edit"></i> Edit
											</button>
										</td>
										<td>
											{{$d->plu_uraian}}
										</td>
										<td colspan="2">
											<button class="btn btn-warning btn-xs" onclick="plus_data.build('Tambah Data','{{$d->plu_uraian}}','{{route('pelaksanaan.urusan.store.data',['id_sub'=>$sub->id,'id_indikator'=>$d->plu_id])}}')">
												<i class="fa fa-plus"></i> Tambah Data
											</button>
										</td>
									</tr>
									<?php $plu_id=$d->plu_id; ?>

								@endif
								@if(($d->plud_id!=$plud_id)&&(!empty($d->plud_id)))
									<tr>
										<td colspan="2"></td>
										<td class="pull-right">
											<button class="btn btn-warning btn-xs">
												<i class="fa fa-edit"></i> Edit
											</button>
										</td>
										<td>
											{{$d->plud_uraian}}
										</td>
										
									</tr>

									<?php $plud_id=$d->plud_id; ?>

								@endif

							@endforeach
						
						</tbody>
					</table>
				</div>
			</div>
		</div> 	
	</div>

@stop

@section('js')

@include('form.pelaksanaan_urusan.partials.vue_modal_tambah_indikator',['tag'=>'indikator'])
@include('form.pelaksanaan_urusan.partials.vue_modal_tambah_indikator',['tag'=>'data'])


@stop