@extends('layouts.export')


@section('content_header')
<style type="text/css">
	
	th{
		text-align: center!important;
	}
</style>

@stop

@section('content')


@include('layouts.header-export',['context'=>$sub_title.' -'])

	<table class=" table-bordered table">
	<thead class="bg-primary">
		<tr>
			<th rowspan="2"  class="text-center">PN / MAJOR PROJECT</th>
			<th rowspan="2" class="text-center">PP</th>
			<th rowspan="2" class="text-center">KP</th>
			<th rowspan="2" class="text-center">PROPN</th>
			<th rowspan="2" class="text-center">PROYEK KL</th>
			<th colspan="3" class="text-center">INDIKATOR</th>
			<th rowspan="2" class="text-center">LOKUS</th>
			<th rowspan="2" class="text-center">PELAKSANA</th>

		</tr>
		<tr>
			<th class="text-center">URAIAN</th>
			<th class="text-center">TARGET</th>
			<th class="text-center">SATUAN</th>
		</tr>

	</thead>
	<tbody>
		@foreach($data as $pn)
			<tr>
				
				<td>
					<b>{{$pn['jenis']==-1?'MAJOR PROJECT':'PN'}}: </b>{{$pn['uraian']}}
				</td>
				<td class="bg-info"></td>
				<td></td>
				<td class="bg-info"></td>
				<td></td>
				<td colspan="5"></td>


			</tr>
			@foreach($pn['_tag_indikator'] as $tagpni)
					@php
						$pni=$tagpni['_indikator'];
					@endphp
					<tr class="pn-{{$pn['id']}}">
					
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
								$i=$pni;
								$i['pelaksana_nas']=json_decode($pni['pelaksana_nas']);
								$i['pelaksana_p']=json_decode($pni['pelaksana_p']);
								$i['pelaksana_k']=json_decode($pni['pelaksana_k']);
							@endphp
							<b>PUSAT</b>
							<ul>
							@foreach($i['pelaksana_nas'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
							<b>PROVINSI</b>
							<ul>
							@foreach($i['pelaksana_p'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
							<b>KOTA/KAB</b>
							<ul>
							@foreach($i['pelaksana_k'] as $p)
								<li>{{$p}}</li>
							@endforeach
							</ul>
						
						</td>

			</tr>

			@endforeach
			@foreach($pn['_child_pp'] as $pp)
				<tr class="pn-{{$pn['id']}}">
					
					<td></td>
					<td class="bg-info"><b>PP: </b>{{$pp['uraian']}}</td>
					<td></td>
					<td class="bg-info"></td>
					<td></td>
					<td colspan="5"></td>

				</tr>
				@foreach($pp['_tag_indikator'] as $tagppi)
					<tr class="pp-{{$pp['id']}} pn-{{$pn['id']}} ">	
						@php
							$ppi=$tagppi['_indikator'];
						@endphp
						<td ></td>
						<td class="bg-info"></td>
						<td ></td>
						<td class="bg-info"></td>
						<td ></td>

						
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
								$i=$ppi;
								$i['pelaksana_nas']=json_decode($ppi['pelaksana_nas']);
								$i['pelaksana_p']=json_decode($ppi['pelaksana_p']);
								$i['pelaksana_k']=json_decode($ppi['pelaksana_k']);
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

				@endforeach

				@foreach($pp['_child_kp'] as $kp)
					<tr class="pp-{{$pp['id']}} pn-{{$pn['id']}}">
					
						<td colspan=""></td>
						<td class="bg-info"></td>
						<td colspan=""><b>KP: </b>{{$kp['uraian']}}</td>
						<td class="bg-info"></td>
						<td></td>
						<td colspan="5"></td>

					</tr>
					@foreach($kp['_tag_indikator'] as $tagkpi)
					<tr class=" kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}}">
						@php
							$kpi=$tagkpi['_indikator'];
						@endphp
					
						<td ></td>
						<td class="bg-info"></td>
						<td ></td>
						<td class="bg-info"></td>
						<td ></td>
						
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
								$i=$kpi;
								$i['pelaksana_nas']=json_decode($kpi['pelaksana_nas']);
								$i['pelaksana_p']=json_decode($kpi['pelaksana_p']);
								$i['pelaksana_k']=json_decode($kpi['pelaksana_k']);
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

					@endforeach
					@foreach($kp['_child_propn'] as $propn)
						<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}}">
						
							<td colspan=""></td>
							<td class="bg-info"></td>
							<td colspan></td>
							<td class="bg-info"><b>PROPN: </b>{{$propn['uraian']}}</td>
							<td></td>
							<td colspan="5"></td>
								


						</tr>

						@foreach($propn['_tag_indikator'] as $tagpropni)
							<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}}">
								@php
									$propni=$tagpropni['_indikator'];
								@endphp
								

								<td ></td>
								<td class="bg-info"></td>
								<td ></td>
								<td class="bg-info"></td>
								<td ></td>
									
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
									$i=$propni;
									$i['pelaksana_nas']=json_decode($propni['pelaksana_nas']);
									$i['pelaksana_p']=json_decode($propni['pelaksana_p']);
									$i['pelaksana_k']=json_decode($propni['pelaksana_k']);
									@endphp
									<b>PUSAT</b>
									<ul>
									@foreach($i['pelaksana_nas'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									<b>PROVINSI</b>
									<ul>
									@foreach($i['pelaksana_p'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
									<b>KOTA/KAB</b>
									<ul>
									@foreach($i['pelaksana_k'] as $p)
										<li>{{$p}}</li>
									@endforeach
									</ul>
								
								</td>




							</tr>

						@endforeach
						@foreach($propn['_child_proyek'] as $proyek)
							<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}}">
								
								<td colspan=""></td>
								<td class="bg-info"></td>
								<td colspan></td>
								<td class="bg-info"></td>
								<td><b>PROYEK: </b>{{$proyek['uraian']}}</td>
								<td colspan="5"></td>


							</tr>
							@foreach($proyek['_tag_indikator'] as $tagproyeki)
								<tr class="kp-{{$kp['id']}} pp-{{$pp['id']}} pn-{{$pn['id']}} propn-{{$propn['id']}} proyek-{{$proyek['id']}} ">
									@php
										$proyeki=$tagproyeki['_indikator'];
									@endphp
							

									<td ></td>
									<td class="bg-info"></td>
									<td ></td>
									<td class="bg-info"></td>
									<td ></td>
									
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
											$i=$proyeki;
											$i['pelaksana_nas']=json_decode($proyeki['pelaksana_nas']);
											$i['pelaksana_p']=json_decode($proyeki['pelaksana_p']);
											$i['pelaksana_k']=json_decode($proyeki['pelaksana_k']);
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

							@endforeach

						@endforeach


					@endforeach

				@endforeach

			@endforeach

		@endforeach
	</tbody>
</table>

@stop