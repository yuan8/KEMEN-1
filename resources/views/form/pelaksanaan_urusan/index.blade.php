@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">DATA PELAKSANAAN URUSAN   </h3>
    		
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
								<th>NAMA SUBURUSAN</th>
								<th>JUMLAH INDIKATOR</th>

							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								<tr class="cursor-link" onclick="window.location='{{route('pelaksanaan.urusan.view',['id'=>$d->id])}}'">
									<td>
										<b>{{$d->nama}}</b>
									</td>
									<td>{{$d->count_indikator}}</td>
								</tr>

							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div> 	
	</div>

@stop