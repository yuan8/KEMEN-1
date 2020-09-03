@php
	$domid='dom'.date('s');
@endphp
<h5><b>TAGGING - {{$rekom['_nomen']['uraian']}}</b></h5>
<form action="{{$url_tagging}}" method="post">
	@csrf
	<table class="table table-bordered " id="list_indikator_to_add_{{$domid}}">
		<thead class="bg-green">
			<tr>
			<th>ACTION</th>
			<th>{{$jenis}}</th>
			
		</tr>
		</thead>
		<tbody>
			<tr id="kosong">
				<td colspan="7" class="text-center">Tidak Terdapat Data Yang Akan ditambahkan</td>
			</tr>
		</tbody>
	</table>

<div class="row">
	<div class="col-md-12">
	<div class="pull-right">
	<button class="btn btn-success  btn-xs"  type="submit">
		<i  class="fa fa-plus"></i> TAMBAH {{$jenis}}</button>
	</div>


</div>
</div>
</form>

<hr>
<H5><b>LIST {{$jenis}} TERSEDIA </b></H5>

<table class="table table-bordered" id="table-indikator-{{$domid}}" style="width:100%">
	<thead>
		<tr>
			<th>ACTION</th>
			<th>{{$jenis}}</th>
		</tr>
	</thead>
	<tbody>

		
	</tbody>

</table>

<script type="text/javascript">
	var data_{{$domid}}=<?php echo json_encode($data);?>;
	var table_{{$domid}}=$('#table-indikator-{{$domid}}').DataTable({
		sort:false,
		data:data_{{$domid}},
		columns:[
			{	
				render:function(data,type,datarow){
					return '<div class="btn-group pull-right">'+
					'<button class="btn btn-success  btn-xs" onclick="tambahIndikator_{{$domid}}(this,'+datarow.id+')" >'+
						'<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>'+
				'</div>';
				}
			},
			
			{
				data:"uraian"
			}
			
		]
	});
	

	function checkIndikatorList_{{$domid}}(dom){
		$(dom).parent().parent().parent().remove();

		var kosong='<tr id="kosong"><td colspan="2" class="text-center" >Tidak Terdapat Data  Yang Akan ditambahkan</td></tr>';
		setTimeout(function(){
			if($('#list_indikator_to_add_{{$domid}} tbody tr').html()==undefined){
				$('#list_indikator_to_add_{{$domid}} tbody').prepend(kosong);
			}
		},300);
	}


	function tambahIndikator_{{$domid}}(dom,id){
		var tr=($(dom).parent().parent().parent());
		var data=(table_{{$domid}}.row(tr).data());
		var kosong='<tr><td colspan="7" id="kosong">Tidak Terdapat Data Indikator Yang Akan ditambahkan</td></tr>';

		if(data){
			if($('#list_indikator_to_add_{{$domid}} #key_ind_'+data.id).html()==undefined){
				var target=null;

				if((data.tipe_value==2)){
					target=data.target+' <-> '+data.target_1;
				}else{
					target=data.target;
				}

				if($('#list_indikator_to_add_{{$domid}} #kosong').html()!=undefined){
					$('#list_indikator_to_add_{{$domid}} #kosong').remove();
				}


				var dom ='<tr id="key_ind_'+id+'"><td><input type="hidden" name="id[]" value="'+data.id+'"> <div class="pull-right"><button type="button" class="btn btn-danger btn-xs" onclick="checkIndikatorList_{{$domid}}(this)"><i class="fa fa-trash"></i></button></div></td><td>'+data.uraian+'</td></tr>';

				$('#list_indikator_to_add_{{$domid}} tbody').prepend(dom);
			}


		}
	}

</script>

