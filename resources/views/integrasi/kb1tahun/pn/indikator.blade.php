@php
	$domid='dom'.date('s');
@endphp

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#normal" id="nav-indikator">FORM TAMBAH INDIKATOR </a></li>
  <li><a data-toggle="tab" href="#add-indikator">TAMBAH BARU INDIKATOR {{Hp::tag_ind($tag)}}</a></li>
</ul>



<hr>
	<h5><b>{{$jenis}}: {!!$rkp['uraian']!!}</b></h5>
<hr>
<div class="tab-content">

<div class="tab-pane fade" id="add-indikator">
	@include('integrasi.indikator.create')
	
</div>

<div class="tab-pane fade in active" id='normal'>
@php
	if(!isset($route_add)){
	
		$route_add=route('int.kb1tahun.store_indikator',['id'=>$rkp->id]);
	}

@endphp
<form action="{{$route_add}}" method="post">
	@csrf
	<table class="table table-bordered" id="list_indikator_to_add_{{$domid}}">
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
<H5><b>LIST INDIKATOR RPJMN</b></H5>
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
				data:"_sub_urusan.nama"
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


				var dom ='<tr id="key_ind_'+id+'"><td><div class="pull-right"><button type="button" class="btn btn-danger btn-xs" onclick="checkIndikatorList_{{$domid}}(this)"><i class="fa fa-trash"></i></button></div></td><td>'+data._sub_urusan.nama+'</td><td>'+data._sumber+'</td><td>'+data.kode+'</td><td>'+data.uraian+'</td><td>'+target+'</td><td>'+data.satuan+'<input type="hidden" name="id_indikator[]" value="'+id+'"></td></tr>';
				$('#list_indikator_to_add_{{$domid}} tbody').prepend(dom);
			}


		}
	}
</script>


</div>
</div>


<script type="text/javascript">
	
	function showFormCreateIndikator(){
		API_CON.get("{{route('int.kb5tahun.indikator.create',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR {{Hp::fokus_tahun()}}');
			$('#modal-glo bal-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}
	var form_value_def={};
	$('#add-indikator form input[name],#add-indikator form textarea[name]').each(function(i,d){
		form_value_def[$(d).attr('name')]=$(d).val();
	});


	$( "#add-indikator form" ).submit(function( event ) {
		event.preventDefault();
		var dta={};
		var fields= $(this).serializeArray();
	 	jQuery.each( fields, function( i, field ) {
	 		dta[field.name]=field.value;
	    });

		API_CON.post("{{route('int.m.indikator.store')}}",dta).then(function(res){
			var res=res.data;
			if(parseInt(res.kode)==200){
				var data=res.data;
				var target=null;

				if((data.tipe_value==2)){
					target=data.target+' <-> '+data.target_1;
				}else{
					target=data.target;
				}


				var dom ='<tr id="key_ind_'+data.id+'"><td><div class="pull-right"><button type="button" class="btn btn-danger btn-xs" onclick="checkIndikatorList_{{$domid}}(this)"><i class="fa fa-trash"></i></button></div></td><td>'+data._sub_urusan.nama+'</td><td>'+data._sumber+'</td><td>'+data.kode+'</td><td>'+data.uraian+'</td><td>'+target+'</td><td>'+data.satuan+'<input type="hidden" name="id_indikator[]" value="'+data.id+'"></td></tr>';

				if($('#list_indikator_to_add_{{$domid}} #kosong').html()!=undefined){
					$('#list_indikator_to_add_{{$domid}} #kosong').remove();
				}

				$('#list_indikator_to_add_{{$domid}} tbody').prepend(dom);
				$('#nav-indikator').click();

				Swal.fire({
				  title: "Success",
				  text: res.message,
				  icon: "success",
				});
				$('#add-indikator form select[name]').val(null);
				for(var i in form_value_def){
					$('#add-indikator form [name="'+i+'"]').val(form_value_def.i);
				}

				updateSourceRKPINDIKATOR();


			}else{
				Swal.fire({
				  title: "Error",
				  text: res.message,
				  icon: "error",
				});

			}
		});
	});	

@php
	$meta=[];

	if(isset($for_kewenangan)){
		$meta['id_kewenangan']=null;
	}
	if(isset($for_sasaran)){
		$meta['id_sasaran']=null;
	}

	if(isset($only_sub_urusan)){
		$meta['id_sub_urusan']=$only_sub_urusan;
	}
	if(isset($have_tag)){
		$meta['tag']=$have_tag;
	}else{
		$meta['tag']=[1,2,3,4,0];
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
