@extends('adminlte::page_front')


@section('content_header')
     <div class="row">
    	<div class="col-md-12">
    		<h3 class="text-uppercase text-center">KAWASAN PERBATASAN NEGARA 2021</h3>
    	</div>
    </div>
   

@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-body">
				<table class="table-bordered table">
					<thead>
						<tr>
							<th>KODE DAERAH</th>
							<th>
								NAMA DAERAH
							</th>
							<th>CATATAN</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $d)
							<tr>
								<td>
									{{$d->kode_daerah}}
								</td>
								<td>
									{{$d->nama_daerah}}
								</td>
								<td>
									{!! nl2br(str_replace(';','<br>',$d->catatan))!!}
								</td>
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
	$('table').dataTable({
		sort:false
	})
</script>

@stop