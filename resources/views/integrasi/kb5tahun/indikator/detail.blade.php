<div class="row text-dark">
	
	<h4 class="bg-navy text-center" style="margin: 0px; padding: 10px;"><b>{{$i['_urusan']['nama'].($i['_sub_urusan']?' -> '.$i['_sub_urusan']['nama']:'')}}</b></h4>
	<P class="bg bg-yellow-gradient text-center text-dark"><b>{{$i['kode']}}</b></P>
	
	 <div class="col-md-12">
	 	<table class="table table-bordered bg-white">
	 		<thead class="bg-navy">
		
	 			<tr class="bg-white">
	 				<th colspan="7" class="bg-white">
	 					<p class="text-blue text-capitalize"><b>{{$i['uraian']}}</b></p>
	 				</th>
	 			</tr>
	 			<tr>
	 				<th rowspan="2">TARGET PUSAT {{Hp::fokus_tahun()}}</th>
	 				<th rowspan="2">SATUAN</th>
	 				<th colspan="3">KEWENANGAN</th>
	 				<th rowspan="2">LOKUS</th>

	 				<th rowspan="2">PELAKSANA</th>
	 			</tr>
	 			<tr>
	 				<th>PUSAT</th>
	 				<th>PROVINSI</th>
	 				<th>KOTA/KABUPATEN</th>
	 			</tr>
	 		</thead>
	 		<tbody>
	 			<tr>
	 				<td rowspan="3">
						@if(($i['tipe_value']==1)OR($i['tipe_value']==2))
							{{number_format($i['target'],2)}}
						@else
							{{$i['target']}}

						@endif

						@if($i['tipe_value']==2)
							<-> {{number_format($i['target_1'],2)}}

						@endif


						</td>
						<td rowspan='3'>{{$i['satuan']}}</td>

						<td>
						@if($i['kw_nas'])
							<i class="fa text-success fa-check"></i> BERWENANG
						@else
							<i class="fa text-danger fa-times"></i> TIDAK BERWENANG
						@endif


						</td>
						<td>
						@if($i['kw_p'])
							<i class="fa text-success fa-check"></i> BERWENANG
						@else
							<i class="fa text-danger fa-times"></i> TIDAK BERWENANG

						@endif


						</td>
						<td>
						@if($i['kw_k'])
							<i class="fa text-success fa-check"></i> BERWENANG
						@else
							<i class="fa text-danger fa-times"></i> TIDAK BERWENANG
						@endif


						</td>
						<td rowspan="3">{!!$i['lokus']!!}</td>
						<td rowspan="3" style="min-width: 200px;">
							@php
								$i=$i;
								$i['pelaksana_nas']=json_decode($i['pelaksana_nas']);
								$i['pelaksana_p']=json_decode($i['pelaksana_p']);
								$i['pelaksana_k']=json_decode($i['pelaksana_k']);
							@endphp
							@if($i['kw_nas'])
							<b>PUSAT</b>
							<ul>
							@foreach($i['pelaksana_nas'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
							@endif
							@if($i['kw_p'])

							<b>PROVINSI</b>
							<ul>
							@foreach($i['pelaksana_p'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
							@endif
							@if($i['kw_k'])

							<b>KOTA/KAB</b>
							<ul>
							@foreach($i['pelaksana_k'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
							@endif
						</td>
	 			</tr>
	 			<tr>
	 				<th class="bg-navy">DATA DUKUNG</th>
	 				<th class="bg-navy">DATA DUKUNG</th>
	 				<th class="bg-navy">DATA DUKUNG</th>
	 			</tr>
	 			<tr>
	 				<td class="{{$i['kw_nas']?'':'bg-danger'}}">{!!$i['data_dukung_nas']!!}</td>
	 				<td class="{{$i['kw_p']?'':'bg-danger'}}">{!!$i['data_dukung_p']!!}</td>
	 				<td class="{{$i['kw_k']?'':'bg-danger'}}">{!!$i['data_dukung_k']!!}</td>
	 			</tr>
	 		</tbody>
	 	</table>
	 </div>

	 <div class=" col-md-12 table-responsive">
		<h4 class="text-center">DATA KEWENANGAN PELAKSANAAN URUSAN</h4>
	 	<table class="table table-bordered">
	 		<thead class="bg-navy">
	 			<tr>
	 				<th>KEWENANGAN PUSAT</th>
	 				<th>KEWENANGAN PROVINSI</th>
	 				<th>KEWENANGAN KOTA/KAB</th>


	 			</tr>
	 		</thead>
	 		<tbody>
	 			<tr>
	 				<td class="{{!!$i['kw_nas']?'':'bg bg-danger'!!}">{!!$i['kw_nas']?$i['kewenangan_nas']:''!!}</td>
	 					<td class="{{!!$i['kw_p']?'':'bg bg-danger'!!}">{!!$i['kw_p']?$i['kewenangan_p']:''!!}</td>
	 						<td class="{{!!$i['kw_k']?'':'bg bg-danger'!!}">{!!$i['kw_k']?$i['kewenangan_k']:''!!}</td>
	 			</tr>
	 		</tbody>
	 	</table>
	 </div>
	
	<div class="col-md-12">
		<h4 class="text-center">INDENTIFIKASI DARI KEBIJAKAN 5 TAHUNAN</h4>
		<table class="table table-bordered">
			<thead class="bg-navy">
				<tr>
					<th colspan="2">KONDISI</th>
					<th rowspan="2">ISU STARTEGIS</th>
					<th rowspan="2">ARAH KEBIJAKAN</th>
				</tr>
				<tr>
					<th>KODE</th>
					<th>URAIAN</th>

				</tr>
			</thead>
			<tbody>
				<tr>
					
					<td><b>{!!$i['_kondisi']['kode']!!}</b></td>
					<td>{!!$i['_kondisi']['uraian']!!} - Tahun {{$i['_kondisi']['tahun_data']}} <br> 
					<b class="text-success">{{$i['_kondisi']['nilai']}} {{$i['_kondisi']['satuan']}}</b> </td>
					<td>{!!$i['_kebijakan']['_isu']['uraian']!!}</td>
					<td>{!!$i['_kebijakan']['uraian']!!}</td>
				</tr>

			</tbody>
		</table>

	</div>
	
	  <div class="col-md-12">
	 	<p class="bg-navy text-center"><b>KETERANGAN</b></p>
	 	<p>{!!$i['keterangan']!!}</p>
	 </div>
	 <hr>
</div>