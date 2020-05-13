<table class="table-bordered table">
	<thead>
		<tr>
			<th>KODE</th>
			<th>NAMA INDIKATOR</th>
			<th>TARGET NASIONAL</th>
			<th>TARGET DAERAH</th>
			<th>KEGIATAN PENDUKUNG</th>



		</tr>
	</thead>
	@foreach($data as $d)
	<?php $d=(array)$d; ?>
		<tr class="">
			<td class="bg">{{$d['kode_indikator']}}</td>
			<td>{{$d['nama_indikator']}}</td>
			<td>{{$d['target_nasional']}} {{$d['nama_satuan']}}</td>
			<td>{{$d['target_daerah']}} {{$d['nama_satuan']}} </td>	
			<td>
				@if($d['jumlh_pendukung'])
				<button class="btn btn-warning btn-xs" onclick="kegiatan_pendukung_iku('{{$d['kodepemda']}}','{{$d['kode_indikator']}}','#k_pendukung_{{$d['kode_indikator']}}')">{{$d['jumlh_pendukung']}} Kegiatan </button>
				@else
				{{$d['jumlh_pendukung']}}
				@endif
			</td>		
		</tr>

		<tr class=" tr_data bg bg-success" id="tr_data_{{$d['kode_indikator']}}" >
			<td colspan="5">
				{!! nl2br($d['catatan'])!!} 
				<div style="margin-left: 15px;" class="bg bg-yellow data_k_pendukung " id="k_pendukung_{{$d['kode_indikator']}}"></div>
			</td>
		</tr>
	@endforeach
</table>