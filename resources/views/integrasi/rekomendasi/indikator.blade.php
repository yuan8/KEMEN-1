@php
	$domid='dom'.date('s');
@endphp
<h5><b>{{$jenis}}: {{$parent['uraian']}}</b></h5>
<hr>
<form action="{{route('int.rekomendasi.store_indikator',['kodepemda'=>$kodepemda,'id'=>$reko['id']])}}" method="post">
	@csrf
	<table class="table table-bordered " id="list_indikator_to_add_{{$domid}}">
		<thead class="bg-green">
			<tr>
			<th>ACTION</th>
			<th>SUB URUSAN</th>
			<th>JENIS</th>
			<th>KODE</th>
			<th>INDIKATOR</th>
			<th>TARGET</th>
			<th>SATUAN</th>
		</tr>
		</thead>
		<tbody>
			<tr id="kosong">
				<td colspan="7" class="text-center">Tidak Terdapat Data Indikator Yang Akan ditambahkan</td>
			</tr>
		</tbody>
	</table>

<div class="row">
	<div class="col-md-12">
	<div class="pull-right">
	<button class="btn btn-success  btn-xs"  type="submit">
		<i  class="fa fa-plus"></i> Tambah Indikator</button>
	</div>


</div>
</div>
</form>

<hr>
<H5><b>LIST INDIKATOR TERSEDIA KEWENANGAN {{$kewenangan}}</b></H5>

<table class="table table-bordered" id="table-indikator-{{$domid}}" style="width:100%">
	<thead>
		<tr>
			<th>ACTION</th>
			<th>SUB URUSAN</th>
			<th>JENIS</th>
			<th>KODE</th>
			<th>INDIKATOR</th>
			<th>TARGET</th>
			<th>SATUAN</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>

</table>

<script type="text/javascript">
	var data_{{$domid}}=[];
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
				render:function(data,type,datarow){
					if(datarow._sub_urusan){
						return datarow._sub_urusan.nama;
					}else{
						return '-';
					}
				}
			},
			{
				data:"_sumber"
			},
			{
				data:'kode'
			},
			{
				data:"uraian"
			},
			{
				render:function(data,type,datarow){
				if((parseInt(datarow.tipe_value)==1)||(parseInt(datarow.tipe_value)==2)){


						target=datarow.target;
				}else{
					target=datarow.target;
				}
				
				if(parseInt(datarow.tipe_value)==2){
					target+=' <-> '+datarow.target_1;
				}

				return target;
				}
			},
			{
				data:"satuan"
			}
		]
	});



	function checkIndikatorList_{{$domid}}(dom){
		$(dom).parent().parent().parent().remove();

		var kosong='<tr id="kosong"><td colspan="7" class="text-center" >Tidak Terdapat Data Indikator Yang Akan ditambahkan</td></tr>';
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


				var dom ='<tr id="key_ind_'+id+'"><td><div class="pull-right"><button type="button" class="btn btn-danger btn-xs" onclick="checkIndikatorList_{{$domid}}(this)"><i class="fa fa-trash"></i></button></div></td><td>'+(data._sub_urusan?data._sub_urusan.nama:'-')+'</td><td>'+data._sumber+'</td><td>'+data.kode+'</td><td><p><b>'+data.tipe.toUpperCase()+'</b></p>'+data.uraian+'</td><td>'+target+'</td><td>'+data.satuan+'<input type="hidden" name="id_indikator[]" value="'+id+'"></td></tr>';
				$('#list_indikator_to_add_{{$domid}} tbody').prepend(dom);
			}


		}
	}

	@php

	$meta=[];
	if(isset($for_kewenangan)){
		$meta['id_kewenangan']=null;
	}

	if(isset($for_integrasi_program)){
		$meta['id_kewenangan']=['id_kewenangan','!=',null];
	}

	if(isset($for_integrasi_program_child)){
		$meta['id_kewenangan']=['id_kewenangan','!=',null];
		$meta['tag']=[1,2,3];
	}

	if(isset($for_kebijakan)){
		$meta['id_kebijakan']=null;
	}

	if(isset($for_pp)){
		$meta['tag']=[1];
		$meta['id_kebijakan']=['id_kebijakan','!=',null];
	}
	if(isset($for_pp_child)){
		$meta['tag']=[2,3];
	}

	if(isset($only_sub_urusan)){
		$meta['id_sub_urusan']=$only_sub_urusan;
	}

	if(isset($have_tag)){
		$meta['tag']=$have_tag;
	}

	if(isset($tipe_indikator)){
		$meta['tipe_indikator']=['tipe','=',$tipe_indikator];
	}

	if(isset($ak_not_null)){
		$meta['id_kebijakan']=['id_kebijakan','!=',null];
	}


	if(isset($indikator_from_rkp_id)){
		$ids=\App\RKP\RKPINDIKATOR::where('id_rkp',$indikator_from_rkp_id)->get()->pluck('id_indikator');
		$meta['id']=$ids;
	}



	
@endphp
	function updateSourceRKPINDIKATOR(){
		API_CON.post('{{route('api.get.master_indikator')}}',<?php echo json_encode($meta,true) ?>).then(function(res){
			
			if(parseInt(res.data.kode)==200){
				res=res.data.data;
				data_{{$domid}}=res;
				table_{{$domid}}.clear();
				table_{{$domid}}.rows.add(res).draw();
			}
		
		});
	}

	updateSourceRKPINDIKATOR();

	
</script>
</script>

