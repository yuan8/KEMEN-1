@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">

    		<h3 class="text-uppercase">INTEGRASI NOMENKLATUR PROVINSI {{Hp::fokus_tahun()}} </h3>
    		
    	</div>
    	
    </div>
@stop
@section('content')

<div class="box box-warning">
	<div class="box-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ACTION</th>
					<th>LOGO</th>
					<th>NAMA DAERAH</th>
					<th>JUMLAH KEGIATAN</th>

				</tr>
			</thead>
			<tbody>
				@foreach($data as $d)
				<tr>
					<td>
						<a href="{{route('nomen.pro.detail',['kode_daerah'=>$d->id])}}" target="_blank" class="btn btn-warning btn-sm">DETAIL</a>
					</td>
					<td class="text-center">
						<img src="{{asset($d->logo)}}" style="max-width: 50px;">
					</td>
					<td>
						<b>{{$d->nama}}</b>
					</td>
					<td>
						{{number_format($d->jumlah_kegiatan,0,',','.')}} KEGIATAN
					</td>
				</tr>

				@endforeach
			</tbody>
		</table>
		{{$data->links()}}

	</div>
</div>


@stop