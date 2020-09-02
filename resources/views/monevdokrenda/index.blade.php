@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>MONITORING DAN EVALUASI PELAKSANAAN RENCANA PEMBANGUNAN DAERAH LINGKUP SUPD 2 </h3>
      </div>
      
    </div>
@stop

@section('content')
  <a href=""><button class="btn btn-success btn-xs" > KEMBALI</button></a>

  <div class="row">
      <div class="col-md-12">
        <div class="box box-solid box-info-gradient">
            <div class="box-body">
                   <table class="table table-borded" id="table-daerah">
              <thead>
                  <tr class="bg bg-navy">
                    <th>KODE PEMDA</th>
                    <th>PROVINSI</th>
                    <th>NAMA PEMDA</th>
					<th>ACTION</th>
										
                  </tr>
                      </thead>
						<tbody>
						@foreach($data as $key=>$d)
					<tr>
                    <td>{{$d->id}}</td>
                    <td>{{$d->provinsi}}</td>
                    <td>{{$d->nama}}</td>
					@if($d->jumlah>0)
					<td><a href="{{route('monev.dokrenda.monev',['kodepemda'=>$d->id])}}"><button class="btn btn-success btn-xs" onclick="#">MONEV
					</button></a></td>
					@else
					<td><a href="{{route('monev.dokrenda.monev',['kodepemda'=>$d->id])}}"><button class="btn btn-warning btn-xs" onclick="#">MONEV
					</button></a></td>	
					@endif	
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
        $('#table-daerah').DataTable({
             pageLength: 15,
			 ordering:false
        });

    </script>
@stop