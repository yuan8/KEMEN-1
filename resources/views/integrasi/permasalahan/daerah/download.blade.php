@extends('layouts.export')


@section('content_header')


@stop

@section('content')
<table class="table-bordred table">
	<thead>
		<tr>
			<th colspan="4" class="text-center">{{$sub_title}}</th>
		</tr>
		<tr>
			<th colspan="4" class="text-center">{{Hp::fokus_urusan()['nama'].' TAHUN '.Hp::fokus_tahun()}}</th>
		</tr>
	</thead>
</table>
<table class="table table-bordered">
						<thead>
							<tr>
								<th>MASALAH POKOK</th>
								<th>MASALAH</th>
								<th>AKAR MASALAH</th>
								<th>DATA DUKUNG</th>
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
										
										<td colspan="4">
											 {{$d->pokok_uraian}}
										</td>
										
									</tr>
									<?php $id_pokok=$d->id_pokok; ?>
								@endif
								@if(($id_ms!=$d->id_ms)&&(!empty($d->id_ms)))
									
									<tr class="">
										<td colspan="1"></td>
										
										<td colspan="3">
											{{$d->ms_uraian}}
										</td>
									
									</tr>
									<?php $id_ms=$d->id_ms; ?>

								@endif
								@if(($id_akar!=$d->id_akar)&&(!empty($d->id_akar)))
										
									<tr>
										<td colspan="2"></td>
										
										<td colspan="2">
											{{$d->akar_uraian}}
										</td>
										
									</tr>
									<?php $id_akar=$d->id_akar; ?>

								@endif
								@if(($id_data!=$d->id_data)&&(!empty($d->id_data)))
								
									<tr>
										<td colspan="3"></td>
										
										<td>
											{{$d->data_uraian}}
										</td>
										
									</tr>
									<?php $id_data=$d->id_data; ?>

								@endif

							@endforeach
						</tbody>
					</table>

@stop