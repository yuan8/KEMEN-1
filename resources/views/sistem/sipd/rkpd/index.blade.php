@extends('adminlte::page_front')



@section('content')
	<div class="box box-primary">
		<div class="box-header">
			<form method="get" action="{{url()->current()}}" id="form">
				<div class="col-md-4">
				<label>Provinsi</label>
				<select class="form-control" name="provinsi" id="select_provinsi">
					<option value="">--SEMUA--</option>
					@foreach($provinsi as $pro)
						<option {{isset($_GET['provinsi'])?($_GET['provinsi']==$pro->id?'selected':''):''}} value="{{$pro->id}}">{{$pro->nama}}</option>
					@endforeach
				</select>
			</div>
			</form>

			<script type="text/javascript">
				$('#select_provinsi').on('change',function(){
					$('#form').submit();
				});
			</script>
		</div>
		<div class="box-body">

			<h5><b>TAHUN {{$tahun}}</b></h5>

			<table class="table table-condensed table-bordered">
				<thead>
					<tr>
						<th>
							KODE
						</th>
						<th>
							NAMA DAERAH
						</th>
						<th>
							STATUS SIPD 
						</th>
						<th>
							STATUS APLIKASI
						</th>
						<th>
							JUMLAH KEGIATAN
						</th>
						<th>
							ACTION
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $d)
					<tr class="{{$d->status_sipd!=$d->status?'bg-danger':'bg-success'}}">
						<td>
							{{$d->id}}
						</td>
						<td>
							{{$d->nama_daerah}}
						</td>
						<td>
							{{$d->status_sipd}}
						</td>
						<td>
							{{$d->status==null?0:$d->status}}
						</td>
						<td>
							{{$d->exist}}
						</td>
						<td>
							<a href="{{route('bot.sipd.rkpd.store',['tahun'=>$tahun,'id'=>$d->id])}}" class="btn btn-primary btn-xs" >GET DATA</a>
							
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{$data->links()}}
		</div>
	</div>

@stop