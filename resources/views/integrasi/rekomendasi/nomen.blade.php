@php
	$domid='dom'.date('s');
@endphp
<hr>
<form action="{{route('int.rekomendasi.store_program',['kodepemda'=>$kodepemda])}}" method="post">
	@isset($id_parent)
		<input type="hidden" name="id_parent" value="{{$id_parent}}">
	@endisset	
	@csrf
	<table class="table table-bordered" id="list_indikator_to_add_{{$domid}}">
		<thead>
			<tr>
				<th>ACTION</th>
				<th>KODE</th>
				<th>URAIAN</th>
				
			</tr>
		</thead>
		<tbody>
			<tr id="kosong">
				<td colspan="5" class="text-center">Tidak Terdapat Data </td>
			</tr>
		</tbody>
	</table>

<div class="row">
	<div class="col-md-12">
	<div class="pull-right">
	<button class="btn btn-success  btn-xs"  type="submit">
			<i  class="fa fa-plus"></i> TAMBAH NOMENKLATUR</button>
	</div>


</div>
</div>
</form>

<hr>
<H5><b>LIST NOMENKLATUR TERSEDIA</b></H5>
<table class="table table-bordered" id="table-indikator-{{$domid}}" style="width:100%">
	<thead>
		<tr>
			<th>ACTION</th>
			<th>KODE</th>
			<th>URAIAN</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $key_ind =>$d)

		<tr>
			<td>
				<div class="btn-group pull-right">
					<button class="btn btn-success  btn-xs" onclick="tambahNomen_{{$domid}}({{$key_ind}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH NOMENKLATUR" class="fa fa-plus"></i></button>
				</div>
			</td>
			<td>{{$d->kode}}</td>
			<td>{{$d->nomenklatur}}</td>
			

		</tr>


		@endforeach
	</tbody>

</table>

<script type="text/javascript">
	
	var table_{{$domid}}=$('#table-indikator-{{$domid}}').DataTable({
		sort:false
	});

	var data_{{$domid}}=<?php echo json_encode($data) ?>;


	function checkIndikatorList_{{$domid}}(dom){
		$(dom).parent().parent().parent().remove();
		var kosong='<tr id="kosong"><td colspan="5" class="text-center" >Tidak Terdapat Data </td></tr>';
		setTimeout(function(){
			console.log($('#list_indikator_to_add_{{$domid}} tbody tr').html());
			if($('#list_indikator_to_add_{{$domid}} tbody tr').html()==undefined){
				$('#list_indikator_to_add_{{$domid}} tbody').prepend(kosong);
			}
		},300);
	}


	function tambahNomen_{{$domid}}(key){
		var data=data_{{$domid}}[key];
		var kosong='<tr><td colspan="5" id="kosong">Tidak Terdapat Data </td></tr>';

		if(data){
			if($('#list_indikator_to_add_{{$domid}} #key_ind_'+key).html()==undefined){
				var target=null;

				if((data.tipe_value==2)){
					target=data.target+' <-> '+data.target_1;
				}else{
					target=data.target;
				}

				if($('#list_indikator_to_add_{{$domid}} #kosong').html()!=undefined){
					$('#list_indikator_to_add_{{$domid}} #kosong').remove();
				}

				var dom ='<tr id="key_ind_'+key+'"><td><div class="pull-right"><button type="button" class="btn btn-danger btn-xs" onclick="checkIndikatorList_{{$domid}}(this)"><i class="fa fa-trash"></i></button></div></td><td>'+data.kode+'</td><td>'+data.nomenklatur+'<input type="hidden" name="id_nomen[]" value="'+data.id+'"></td></tr>';
				$('#list_indikator_to_add_{{$domid}} tbody').prepend(dom);
			}

		}
	}



</script>