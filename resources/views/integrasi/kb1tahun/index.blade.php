@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN ({{Hp::fokus_tahun()}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')

<table class="table-bordered table bg-white">
	<thead class="bg-navy">
		<tr>
			<th rowspan="2" colspan="2">PN</th>
			<th rowspan="2">PP</th>
			<th rowspan="2">KP</th>
			<th rowspan="2">PROPN</th>
			<th rowspan="2">PROYEK KL</th>
			<th colspan="4">INDIKATOR</th>
			<th rowspan="2">LOKUS</th>
			<th rowspan="2">PELAKSANA</th>

		</tr>
		<tr>
			<th>KODE</th>
			<th>URAIAN</th>
			<th>TARGET</th>
			<th>SATUAN</th>
		</tr>

	</thead>
	<tbody>
		@foreach($data as $pn)
			<tr>
				<td>
					<div class=" pull-right">
						<button   collapse-btn-nested="false" data-target=".s-{{$pn['id']}}"  class="btn btn-info btn-xs ">
								<i data-toggle="tooltip" data-placement="top" title="DETAIL SASARAN" class="fa fa-eye"></i>
							 ({{count($pn['_child_pp'])}})</button>
						<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$pn['id']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>
						<button class="btn btn-warning  btn-xs" onclick="showFormUpdateSasaran({{$pn['id']}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="showFormDeleteSasaran({{$pn['id']}})"><i class="fa fa-trash"></i></button>
					</div>
				</td>
				<td>{{$pn['uraian']}}</td>

			</tr>
			@foreach($pn['_indikator'] as $pni)
				<tr>

					<td colspan="5"></td>
					
					<td><b>{{$pni['kode']}}</b></td>
					<td>{{$pni['uraian']}}</td>
					<td>
						@if(($pni['tipe_value']==1)OR($pni['tipe_value']==2))
						{{number_format($pni['target'],2)}}
						@else
							{{$pni['target']}}

						@endif

						@if($pni['tipe_value']==2)
							<-> {{number_format($pni['target_1'],2)}}

						@endif
							
					</td>
					<td>{{$pni['satuan']}}</td>
					<td>
						{!!$pni['lokus']!!}
					</td>
					<td>
						@php
							$pelaksana=[];
							preg_match_all("/@\w+/",$pni['pelaksana'],$pelaksana);
						
						@endphp
						@foreach($pelaksana[0] as $idexmacth=> $p)
							<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

						@endforeach
					</td>


				</tr>

			@endforeach
			@foreach($pn['_child_pp'] as $pp)
				<tr>
					<td colspan="2">
							<div class=" pull-right">
							<button   collapse-btn-nested="false" data-target=".s-{{$pp['id']}}"  class="btn btn-info btn-xs ">
									<i data-toggle="tooltip" data-placement="top" title="DETAIL SASARAN" class="fa fa-eye"></i>
								 ({{count($pp['_child_kp'])}})</button>
							<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$pp['id']}})" >
							<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>
							<button class="btn btn-warning  btn-xs" onclick="showFormUpdateSasaran({{$pp['id']}})"><i class="fa fa-pen"></i></button>
							<button class="btn btn-danger  btn-xs" onclick="showFormDeleteSasaran({{$pp['id']}})"><i class="fa fa-trash"></i></button>
						</div>
					</td>
					<td>{{$pp['uraian']}}</td>

				</tr>
				@foreach($pp['_indikator'] as $ppi)
					<tr>

						<td colspan="5"></td>
						<td><b>{{$ppi['kode']}}</b></td>
						<td>{{$ppi['uraian']}}</td>
						<td>
							@if(($ppi['tipe_value']==1)OR($ppi['tipe_value']==2))
							{{number_format($ppi['target'],2)}}
							@else
								{{$ppi['target']}}

							@endif

							@if($ppi['tipe_value']==2)
								<-> {{number_format($ppi['target_1'],2)}}

							@endif
								
						</td>
						<td>{{$ppi['satuan']}}</td>
						<td>
							{!!$ppi['lokus']!!}
						</td>
						<td>
							@php
								$pelaksana=[];
								preg_match_all("/@\w+/",$ppi['pelaksana'],$pelaksana);
							
							@endphp
							@foreach($pelaksana[0] as $idexmacth=> $p)
								<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

							@endforeach
						</td>

					</tr>

				@endforeach

				@foreach($pp['_child_kp'] as $kp)
					<tr>
						<td colspan="4">
								<div class=" pull-right">
								<button   collapse-btn-nested="false" data-target=".s-{{$kp['id']}}"  class="btn btn-info btn-xs ">
										<i data-toggle="tooltip" data-placement="top" title="DETAIL SASARAN" class="fa fa-eye"></i>
									 ({{count($kp['_child_propn'])}})</button>
								<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$kp['id']}})" >
								<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>
								<button class="btn btn-warning  btn-xs" onclick="showFormUpdateSasaran({{$kp['id']}})"><i class="fa fa-pen"></i></button>
								<button class="btn btn-danger  btn-xs" onclick="showFormDeleteSasaran({{$kp['id']}})"><i class="fa fa-trash"></i></button>
							</div>
						</td>
						<td>{{$kp['uraian']}}</td>

					</tr>
					@foreach($kp['_indikator'] as $kpi)
					<tr>

						<td colspan="5"></td>
						<td><b>{{$kpi['kode']}}</b></td>
						<td>{{$kpi['uraian']}}</td>
						<td>
							@if(($kpi['tipe_value']==1)OR($kpi['tipe_value']==2))
							{{number_format($kpi['target'],2)}}
							@else
								{{$kpi['target']}}

							@endif

							@if($kpi['tipe_value']==2)
								<-> {{number_format($kpi['target_1'],2)}}

							@endif
								
						</td>
						<td>{{$kpi['satuan']}}</td>
						<td>
							{!!$kpi['lokus']!!}
						</td>
						<td>
							@php
								$pelaksana=[];
								preg_match_all("/@\w+/",$kpi['pelaksana'],$pelaksana);
							
							@endphp
							@foreach($pelaksana[0] as $idexmacth=> $p)
								<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

							@endforeach
						</td>


					</tr>

					@endforeach
					@foreach($kp['_child_propn'] as $propn)
						<tr>
							<td colspan="6">
												<div class=" pull-right">
										<button   collapse-btn-nested="false" data-target=".s-{{$propn['id']}}"  class="btn btn-info btn-xs ">
												<i data-toggle="tooltip" data-placement="top" title="DETAIL SASARAN" class="fa fa-eye"></i>
											 </button>
										<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$propn['id']}})" >
										<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>
										<button class="btn btn-warning  btn-xs" onclick="showFormUpdateSasaran({{$propn['id']}})"><i class="fa fa-pen"></i></button>
										<button class="btn btn-danger  btn-xs" onclick="showFormDeleteSasaran({{$propn['id']}})"><i class="fa fa-trash"></i></button>
									</div>
								</td>
							<td>{{$propn['uraian']}}</td>

						</tr>

						@foreach($propn['_indikator'] as $propni)
							<tr>

								<td colspan="5"></td>
								<td><b>{{$propni['kode']}}</b></td>
								<td>{{$propni['uraian']}}</td>
								<td>
									@if(($propni['tipe_value']==1)OR($propni['tipe_value']==2))
									{{number_format($propni['target'],2)}}
									@else
										{{$propni['target']}}

									@endif

									@if($propni['tipe_value']==2)
										<-> {{number_format($propni['target_1'],2)}}

									@endif
										
								</td>
								<td>{{$propni['satuan']}}</td>
								<td>
									{!!$propni['lokus']!!}
								</td>
								<td>
									@php
										$pelaksana=[];
										preg_match_all("/@\w+/",$propni['pelaksana'],$pelaksana);
									
									@endphp
									@foreach($pelaksana[0] as $idexmacth=> $p)
										<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

									@endforeach
								</td>




							</tr>

						@endforeach
						@foreach($propn['_child_proyek'] as $proyek)
							<tr>
								<td colspan="8">
												<div class=" pull-right">
										<button   collapse-btn-nested="false" data-target=".s-{{$proyek['id']}}"  class="btn btn-info btn-xs ">
												<i data-toggle="tooltip" data-placement="top" title="DETAIL SASARAN" class="fa fa-eye"></i>
											 </button>
										<button class="btn btn-success  btn-xs" onclick="showFormCreateIndikator({{$proyek['id']}})" >
										<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>
										<button class="btn btn-warning  btn-xs" onclick="showFormUpdateSasaran({{$proyek['id']}})"><i class="fa fa-pen"></i></button>
										<button class="btn btn-danger  btn-xs" onclick="showFormDeleteSasaran({{$proyek['id']}})"><i class="fa fa-trash"></i></button>
									</div>
								</td>

								<td>{{$proyek['uraian']}}</td>

							</tr>
							@foreach($proyek['_indikator'] as $proyeki)
								<tr>

									<td colspan="5"></td>
									<td><b>{{$proyeki['kode']}}</b></td>
									<td>{{$proyeki['uraian']}}</td>
									<td>
										@if(($proyeki['tipe_value']==1)OR($proyeki['tipe_value']==2))
										{{number_format($proyeki['target'],2)}}
										@else
											{{$proyeki['target']}}

										@endif

										@if($proyeki['tipe_value']==2)
											<-> {{number_format($proyeki['target_1'],2)}}

										@endif

									</td>
									<td>{{$proyeki['satuan']}}</td>
									<td>
										{!!$proyeki['lokus']!!}
									</td>
									<td>
										@php
											$pelaksana=[];
											preg_match_all("/@\w+/",$proyeki['pelaksana'],$pelaksana);
										
										@endphp
										@foreach($pelaksana[0] as $idexmacth=> $p)
											<p><b>{{$idexmacth+1}}.</b>{{str_replace(['_','@'],' ',$p)}}</p>

										@endforeach
									</td>


								</tr>

							@endforeach

						@endforeach


					@endforeach

				@endforeach

			@endforeach

		@endforeach
	</tbody>
</table>

@stop