@extends('adminlte::page_front')



@section('content')
	<div class="row" style="margin-top: 20px;">
		<div class="col-md-12">
			<h5><b>{{$terambil }} DAERAH TERAMBIL</b></h5>
			<div class="box ">
				<div class="box-body">
					<table class="table-bordered table" id="tbd">
		<thead>
			<th>KODE</th>
			<th>NAMA DAERAH</th>
			<th>DOKUMEN RAKORTEK</th>
			<th>JSON</th>

			<th>ACTION</th>
		</thead>
		<tbody>
			@foreach($data as $d)
				<tr class="{{$d['exist']?'':'bg bg-danger'}}">
					<td>{{$d['id']}}</td>

					<td>{{$d['nama']}}</td>
					<td>{{$d['exist']?'EXIST':''}}</td>
					<td>
						@if($d['exist'])
						<a href="{{url($d['file'])}}" class="btn btn-primary btn-xs">JSON</a>
						@endif
					</td>

					<td>
						<a href="{{route('bot.rakortek',['tahun'=>2021,'kodepemda'=>$d['id']])}}" target="_blank" class="btn btn-warning">AMBIL</a>
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

	$('#tbd').DataTable();
</script>
@stop