@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN 5 TAHUNAN</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
 <div class="row">
		<div class="col-md-6">
			<div class="box box-warning">
				<div class="box-body">
					<table class="table" id="data">
						<thead>
							<tr>
								<th>NAMA SUBURUSAN @{{text}}</th>

							</tr>
						</thead>
						<tbody>
							@foreach($data as $d)
								<tr class="cursor-link" onclick="window.location='{{route('pelaksanaan.urusan.view',['id'=>$d->id])}}'">
									<td>
										{{$d->nama}}
									</td>
								</tr>

							@endforeach
							<tr>
								<td>
									<input type="" class="form-control" v-model="text" name="">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div> 	
	</div>

	


@stop


@section('js')


<script type="text/javascript">
	var app=new Vue({
		el:'#data',
		data:{
			text:''
		}
	});

</script>
  

@stop