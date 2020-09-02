@extends('adminlte::page')
@php
	$domid='dom'.date('s');
@endphp

@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>PROGRAM KEGIATAN {{$namapemda}} TAHUN ANGGARAN {{$tahun}}</h3>
		<h4>PROGRAM RPJMD--> {{$program_rpjmd}}</h4>
      </div>
      
    </div>
@stop

@section('content')

<a href="{{route('prokeg.detail',['kodepemda'=>$kodepemda,'namapemda'=>$namapemda])}}"><button class="btn btn-success btn-xs" > KEMBALI</button></a>

<form action="{{route('prokeg.pemetaan.program.insert')}}" method="post">
	@csrf
	<table class="table table-bordered" id="list_indikator_to_add_{{$domid}}">
		<thead>
			<tr>
				<th>BIDANG</th>
				<th>PROGRAM</th>
				<th>KODE</th>
				
			</tr>
		</thead>
		<tbody>
			<tr id="kosong">
			@if(count($exist)<>0)
			@foreach($exist as $ex=>$e)
			<tr id="key_ind_"><td><div class="pull-right"><button type="button" class="btn btn-danger btn-xs" onclick="delete_mandat.build('{{route('prokeg.hapus.program_rkpd',['id'=>$e->id])}}','Program','{{$e->uraiprogram}}')"><i class="fa fa-trash"></i></button></div></td><td>{{$e->uraiprogram}}</td><td>{{$e->kodeprogram}} <input type="hidden" name="id_rkpd[]" value="{{$e->id_rkpd}}"><input type="hidden" name="id_rpjmd[]" value="{{$e->id_rpjmd}}"></td></tr>
			@endforeach
			@else
				<td colspan="5" class="text-center">Tidak Terdapat Data Indikator Yang Akan ditambahkan</td>
			@endif
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


  <div class="row">
      <div class="col-md-12">
        <div class="box box-solid box-info-gradient">
            <div class="box-body">
                   <table class="table table-borded" id="table-daerah">
              <thead>
                  <tr class="bg bg-navy">
                      <th>BIDANG</th>
                      <th>PROGRAM</th>
                      <th>KODE PROGRAM</th>
                      <th>DATA RKPD</th>

                  </tr>
                      </thead>
                      <tbody>
					  
                          @foreach($program as $key_ind =>$d)
                            <tr>
                                <td>
								{{$d->uraibidang}}								
								</td>
                                <td>
								{{$d->uraiprogram}}
								</td>
                                <td> 
								{{$d->kodeprogram}}
							</td>
                                <td>
								        <div class="btn-group pull-right">
					<button class="btn btn-success  btn-xs" onclick="tambahIndikator_{{$domid}}('{{$key_ind}}',{{$id}})" >
						<i  data-toggle="tooltip" data-placement="top" title="TAMBAH INDIKATOR" class="fa fa-plus"></i></button>
				</div>
								</td>
                            </tr>

                          @endforeach
                      </tbody>
                  </table>
            </div>
        </div>
      </div>
  </div>
@stop

@section('js')

    <script type="text/javascript">
        $('#table-daerah').DataTable({
             pageLength: 15,
    ordering: false
        });
		
var table_{{$domid}}=$('#table-indikator-{{$domid}}').DataTable({
		sort:false
	});

	var data_{{$domid}}=<?php echo json_encode($program); ?>;

		
function checkIndikatorList_{{$domid}}(dom){
		$(dom).parent().parent().parent().remove();
		var kosong='<tr id="kosong"><td colspan="5" class="text-center" >Tidak Terdapat Data Indikator Yang Akan ditambahkan</td></tr>';
		setTimeout(function(){
			console.log($('#list_indikator_to_add_{{$domid}} tbody tr').html());
			if($('#list_indikator_to_add_{{$domid}} tbody tr').html()==undefined){
				$('#list_indikator_to_add_{{$domid}} tbody').prepend(kosong);
			}
		},300);
	}


	function tambahIndikator_{{$domid}}(key,ids){
		var data=data_{{$domid}}[key];
		var mandat=ids;
		var kosong='<tr><td colspan="5" id="kosong">Tidak Terdapat Data Indikator Yang Akan ditambahkan</td></tr>';

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

				var dom ='<tr id="key_ind_'+key+'"><td><div class="pull-right"><button type="button" class="btn btn-danger btn-xs" onclick="checkIndikatorList_{{$domid}}(this)"><i class="fa fa-trash"></i></button></div></td><td>'+data.uraiprogram+'</td><td>'+data.kodeprogram+' <input type="hidden" name="id_rkpd[]" value="'+data.id+'"><input type="hidden" name="id_rpjmd[]" value="'+{{$id}}+'"></td></tr>';
				$('#list_indikator_to_add_{{$domid}} tbody').prepend(dom);
			}

		}
	}
	 
         


    </script>

@include('prokeg.partials.vue_modal_delete_sasaran');

<script type="text/javascript">
		</script>
@stop