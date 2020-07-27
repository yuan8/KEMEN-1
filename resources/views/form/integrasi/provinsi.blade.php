@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">INTEGRASI PROVINSI </h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box-warning box">
			
			<div class="box-body">
				<table class="table table-bordered" id="rpjmn">
					<thead>
						<tr>
							<th>ACTION</th>
							<th >
								LOGO
							</th>
							<th>
								NAMA
							</th>
							<th>
								JUMLAH INDIKATOR TERTARGET ({{HP::fokus_tahun()}})
							</th>
							
						</tr>
					</thead>
					<tbody>
						@foreach($provinsi as $d)
						<tr>
							<td>
								<a href="{{route('integrasi.provinsi.detail',['id'=>$d->id])}}" class="btn btn-warning btn-xs">DETAIL</a>
							</td>
							<td class="text-center">
								<img src="{{asset($d->logo)}}" style="max-width: 50px;">
							</td>
							<td>
								<b>{{$d->nama}}</b>
							</td>
							<td>
								{{$d->jumlah_ind?$d->jumlah_ind:0}} / {{$d->total_ind}}
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
		$('#rpjmn').DataTable({
			sort:false
		});
		

	</script>

@stop