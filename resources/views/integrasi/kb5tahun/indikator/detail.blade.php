<div class="row text-dark">
	
	<h4 class="bg-navy text-center" style="margin: 0px; padding: 10px;"><b>{{$i['_kondisi']['_urusan']['nama'].' -> '.$i['_sub_urusan']['nama']}}</b></h4>
	<P class="bg bg-yellow-gradient text-center text-dark"><b>{{$i['kode']}}</b></P>
	<div class="col-md-12">
		<p class="text-blue text-capitalize"><b>{{$i['uraian']}}</b></p>
	 </div>
	 <div class="col-md-12">
	 	<table class="table table-bordered bg-with">
	 		<thead class="bg-navy">
	 			<tr>
	 				<th rowspan="2">TARGET PUSAT {{Hp::fokus_tahun()}}</th>
	 				<th rowspan="2">SATUAN</th>
	 				<th colspan="3">KEWENANGAN</th>
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
	 				<td>
								@if(($i['tipe_value']==1)OR($i['tipe_value']==2))
									{{number_format($i['target'],2)}}
								@else
									{{$i['target']}}

								@endif

								@if($i['tipe_value']==2)
									<-> {{number_format($i['target_1'],2)}}

								@endif


							</td>
							<td>{{$i['satuan']}}</td>

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
							<td style="min-width: 200px;">
								@php
									$pelaksana=[];
									preg_match_all("/@\w+/",$i['pelaksana'],$pelaksana);
								
								@endphp
								@foreach($pelaksana[0] as $kp=> $p)
									<p><b>{{$kp+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

								@endforeach
							</td>
	 			</tr>
	 			<tr >
	 				<td colspan="2" rowspan="2"></td>
	 				<th class="bg-navy">DATA DUKUNG</th>
	 				<th class="bg-navy">DATA DUKUNG</th>
	 				<th class="bg-navy">DATA DUKUNG</th>
	 				<td colspan="1" rowspan="2"></td>
	 			</tr>
	 			<tr>
	 				<td class="{{$i['kw_nas']?'':'bg-danger'}}">{!!$i['data_dukung_nas']!!}</td>
	 				<td class="{{$i['kw_p']?'':'bg-danger'}}">{!!$i['data_dukung_p']!!}</td>
	 				<td class="{{$i['kw_k']?'':'bg-danger'}}">{!!$i['data_dukung_k']!!}</td>
	 			</tr>
	 		</tbody>
	 	</table>
	 </div>
	
	<div class="col-md-12">
		<h4>LATAR BELAKANG</h4>
		<table class="table table-bordered">
			<thead class="bg-navy">
				<tr>
					<th colspan="2">KONDISI</th>
					<th rowspan="2">ISU STARTEGIS</th>
					<th rowspan="2">ARAH KEBIJAKAN</th>
					<th rowspan="2">SASARAN</th>
				</tr>
				<tr>
					<th>KODE</th>
					<th>URAIAN</th>

				</tr>
			</thead>
			<tbody>
				<tr>
					<td><b>{!!$i['_kondisi']['kode']!!}</b></td>
					<td>{!!$i['_kondisi']['uraian']!!}</td>
					<td>{!!$i['_kebijakan']['_isu']['uraian']!!}</td>
					<td>{!!$i['_kebijakan']['uraian']!!}</td>
					<td>{!!$i['_sasaran']['uraian']!!}</td>
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