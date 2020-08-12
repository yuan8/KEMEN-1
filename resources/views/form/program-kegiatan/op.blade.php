@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PROGRAM KEGIATAN  URUSAN </h3>
    		
    	</div>
    	<div class="col-md-4 modal-footer" style="padding-top: 20px;">
    		<div class="btn-group">
    			<a href="{{route('program.kegiatan.download-template')}}" class="btn btn-warning">
    			<i class="fa fa-download"></i> Download template 
    		</a>
    		<button class="btn btn-warning">
    			<i class="fa fa-upload"></i> Upload Dokument 
    			
    		</button>
    		</div>

    	</div>
    	
    </div>
@stop


@section('content')

<div class="row">
		<div class="col-md-12 hori-list">
			<div class="scrollmenu">
			 @foreach($data as $d)
					<a  class="text-uppercase " href="">{{$d->nama}}</a>
				@endforeach
			</div>
						
		</div>
		<div class="col-md-12">
			
			
			<div class="box box-warning">
				<div class="box-header">
					<h5>PROGRAM KEGIATAN YANG BELUM DI TAGING SUB URUSAN</h5>
				</div>
				<div class="box-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>DAERAH</th>
								<th></th>
								<th>PROGRAM</th>
								<th></th>
								<th>KEGIATAN</th>
								<th>ANGGARAN</th>
								<th>INDIKATOR</th>
								<th>TARGET</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
</div>

@stop