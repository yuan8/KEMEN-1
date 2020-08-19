@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">MASALAH POKOK TAHUNAN ({{Hp::fokus_tahun()}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-striped table-hover bg-white">
			<thead class="bg-navy">
				<tr>
					<th>ACTION</th>
					<th>MASALAH POKOK</th>
					<th>JUMLAH PEMDA</th>

				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
					<tr>
						<td>
							<a href="{{route('int.permasalahan.resume',['id'=>$d['id'],'pdf'=>'export'])}}" class="btn btn-success btn-xs" target="_blank">RESUME</a>
						</td>
						<td>{!!$d['uraian']!!}</td>
						<td>{{number_format($d['jumlah_pemda'])}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop