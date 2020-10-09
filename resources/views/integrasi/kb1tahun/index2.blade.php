@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN ({{Hp::fokus_tahun()}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<div class="box">
	<div class="box-body">
		<table class="table table-bordered">
			@foreach($data as $pn)
			<tr>
			<td><div class=" btn-group ">

					<button   collapse-btn-nested="false" data-target=".pn-{{$pn['id']}}"  class="btn btn-info btn-xs ">
								<i data-toggle="tooltip" data-placement="top" title="DETAIL PP" class="fa fa-eye"> </i> </button>
					@if($pn['jenis']!=-1)

						<button class="btn btn-success  btn-xs" onclick="showFormNested({{$pn['id']}},{{$pn['jenis']}})" >

						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH PP" class="fa fa-plus"></i></button>

					@endif
						<button class="btn btn-warning  btn-xs" onclick="showFormViewPn({{$pn['id']}},{{$pn['jenis']}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="showFormDeletePn({{$pn['id']}},{{$pn['jenis']}})"><i class="fa fa-trash"></i>	</button>

					@if($pn['jenis']==-1)
					<button class="btn btn-success  btn-xs" onclick="showFormCreatePnIndikator({{$pn['id']}},{{$pn['jenis']}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i>

					</button>

					@endif
					</div></td>
					<td>
						<img src="{{asset('component-list/tree_lv2.png')}}">
					</td>
					<td><b>{{($pn['jenis']==-1?'MAJOR PROJECT':'PN')}}: </b>{{$pn['uraian']}}</td>

			</tr>
			@foreach($pn['_tag_indikator'] as $tagpni )
				@php
				$pni=$tagpni['_indikator'];
				@endphp
				<tr class="bg-warning">

					<td>
						<div class="btn-group ">
							<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$pni['id']}})"><i class="fa fa-eye"></i></button>
							<button class="btn btn-danger btn-xs" onclick="showFormDetailDeleteIndikator({{$tagpni['id']}},{{$pni['jenis']}})"><i class="fa fa-trash"></i></button>
						</div>
					</td>
					<td class="float-left" style="min-width: 200px;">
						<img src="{{asset('component-list/tree_lv2.png')}}">
						
						{{$pni['kode']}}

					
					</td>
					
					<td><b>{{($pn['jenis']==-1?'INDIKATOR MAJOR PROJECT':'INDIKATOR PN')}} :</b> {{$pni['uraian']}}</td>
					<p>	<b>{{strtoupper($pni['tipe'])}}</b></p>

					{{$pni['uraian']}}</td>
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
			@foreach($pn['_child_pp'] as $pp )
				
				<tr>
					<td>{{$pp['uraian']}}</td>

				</tr>
				@foreach($pp['_child_kp'] as $kp )
					
					<tr>
						<td>KP-{{$kp['uraian']}}</td>

					</tr>
				@endforeach
			@endforeach


			@endforeach
		</table>
	</div>
</div>

@stop