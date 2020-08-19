@extends('layouts.export')


@section('content_header')


@stop

@section('content')
<table class="table table-bordred table-striped">
	<thead>
		<tr>
			<th colspan="10">REKOMENDASI {{$meta['_urusan']['nama']}} - {{$meta['tahun']}}</th>
		</tr>
		<tr>
			<th class="text-center">
				@if($daerah['logo'])
					<img src="{{asset($daerah['logo'])}}" style="max-width: 100px;">
				@endif
			</th>

			<th>EXPORT DATE</th>
			<th>{{\Carbon\Carbon::now()->format('d F Y')}}</th>
			<th>KODE PEMDA</th>
			<th>{{$daerah['id']}}</th>
			<th>NAMA PEMDA</th>
			<th colspan="4">{{$daerah['nama']}}</th>
		</tr>
		<tr>
			<th colspan="10"></th>
		</tr>
		<tr>
			<th rowspan="2">PROPN</th>
			<th colspan="4">NOMEN</th>
			<th colspan="5">INDIKATOR</th>



		</tr>
		<tr>
			<th>KODE</th>
			<th>PROGRAM</th>
			<th>KEGIATAN</th>
			<th>SUBKEGIATAN</th>
			<th>JENIS</th>
			<th>INDIKATOR</th>
			<th>TARGET PUSAT</th>
			<th>TARGET DAERAH</th>
			<th>TARGET SATUAN</th>

		</tr>
	</thead>
	<tbody>
		@foreach($data as $d)
		@php 
				$kolom=isset($d['_nomen_pro'])?'_nomen_pro':'_nomen_kab';

		@endphp
		<tr>
			<td colspan="10">{{$d['uraian']}}</td>
		</tr>
			@foreach($d[$kolom] as $p)
				@php $pn=$p['_nomen']; @endphp
				<tr>
					<td></td>
					<td>{{$pn['kode']}}</td>
					<td colspan="8">{{$pn['nomenklatur']}}</td>

				</tr>
				@foreach($p['_tag_indikator'] as $pi)
					@php $pii=$pi['_indikator'];  @endphp
					<tr>
						<td></td>
						<td>{{$pii['kode']}}</td>
						<td colspan="3"></td>
						<td>{{$pii['_sumber']}}</td>
						<td>{{$pii['uraian']}}</td>
						<td>
							
							@if(($pii['tipe_value']==1)OR($pii['tipe_value']==2))
								{{number_format($pii['target'],2)}}
							@else
								{{$pii['target']}}

							@endif

							@if($pii['tipe_value']==2)
								 - 
								{{number_format($pii['target_1'],2)}}

							@endif

						</td>
						<td>
							{{$pi['target']}}
							@if($pii['tipe_value']==2)
								{{' - '.number_format($pi['target_1'])}}

							@endif
						</td>
						<td>
							{{$pii['satuan']}}
						</td>



					</tr>
				@endforeach
				@foreach($p['_child_kegiatan'] as $k)
					@php $kn=$k['_nomen']; @endphp
					<tr>
						<td></td>
						<td>{{$kn['kode']}}</td>
						<td></td>
						<td colspan="7">{{$kn['nomenklatur']}}</td>

					</tr>
					@foreach($k['_child_sub_kegiatan'] as $s)
						@php $sn=$s['_nomen']; @endphp
						<tr>
							<td></td>
							<td>{{$sn['kode']}}</td>
							<td colspan="2"></td>
							<td colspan="7">{{$sn['nomenklatur']}}</td>

						</tr>
					@endforeach
				@endforeach

			@endforeach
		@endforeach
	</tbody>
</table>
@stop