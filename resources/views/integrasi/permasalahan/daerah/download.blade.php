@extends('layouts.export')


@section('content_header')


@stop

@section('content')
@include('layouts.header-export',['context'=>$sub_title.' -'])

<table class="table table-bordered">
						<thead class="bg-primary">
							<tr>
								<th class="text-center">MASALAH POKOK</th>
								<th class="text-center">MASALAH</th>
								<th class="text-center">AKAR MASALAH</th>
								<th class="text-center">DATA DUKUNG</th>
							</tr>
						</thead>
						<tbody>
									
							
							<?php 
							$id_pokok=0;
							$id_ms=0;
							$id_akar=0;
							$id_data=0;
							?>
							@foreach($data as $d)
								@if(($id_pokok!=$d->id_pokok)&&(!empty($d->id_pokok)))
										
									<tr>
										
										<td colspan="">
											 {!!nl2br($d->pokok_uraian)!!}
										</td>
										<td colspan="3"></td>
										
									</tr>
									<?php $id_pokok=$d->id_pokok; ?>
								@endif
								@if(($id_ms!=$d->id_ms)&&(!empty($d->id_ms)))
									
									<tr class="">
										<td colspan="1"></td>
										
										<td colspan="1">
											{!!nl2br($d->ms_uraian)!!}
										</td>
										<td colspan="2"></td>

									
									</tr>
									<?php $id_ms=$d->id_ms; ?>

								@endif
								@if(($id_akar!=$d->id_akar)&&(!empty($d->id_akar)))
										
									<tr>
										<td colspan="2"></td>
										
										<td colspan="1">
											{!!nl2br($d->akar_uraian)!!}
										</td>
										<td colspan="1"></td>

										
									</tr>
									<?php $id_akar=$d->id_akar; ?>

								@endif
								@if(($id_data!=$d->id_data)&&(!empty($d->id_data)))
								
									<tr>
										<td colspan="3"></td>
										
										<td>
											{!!nl2br($d->data_uraian)!!}

										</td>
										
									</tr>
									<?php $id_data=$d->id_data; ?>

								@endif

							@endforeach
						</tbody>
					</table>

@stop