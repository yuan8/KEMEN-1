@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>PEMETAAN SPM TAHUN {{Hp::fokus_tahun()}}</h3>
      </div>
      
    </div>
@stop

@section('content')
<div class="btn-group" style="margin-bottom: 10px;">
	<button class="btn btn-primary btn-sum" onclick="$('#modal-tabah-jenis-pelayanan').modal()">TAMBAH JENIS PELAYANAN</button>
</div>


<div class="box-solid box">
	<div class="box-body table-responsive">
		<table class="table table-bordered">
			<tbody>
				@foreach($data as $d)
        
					<tr>
						<td rowspan="{{count($d['_indikator'])+1}}">{!!($d['_sub_urusan']['nama']?$d['_sub_urusan']['nama']:'-')!!}</td>
						<td rowspan="{{count($d['_indikator'])+1}}" style="min-width: 150px;">{!!nl2br($d['uraian'])!!}</td>
						<td rowspan="{{count($d['_indikator'])+1}}" style="width: 50px;">
							<script type="text/javascript">
								var _data_{{$d['id']}}=<?php echo json_encode($d) ?>;
							</script>
							<div class="btn-group-vertical">
								<button class="btn btn-warning btn-xs" onclick="edit_jenis_pelayanan('{{url('')}}',_data_{{$d['id']}})">								
								<i class="fa fa-pen"></i>
							</button>
							<button class="btn btn-success btn-xs" onclick="tambah_indikator('{{route('int.spm.indikator',['id'=>$d['id']])}}')">
								<i class="fa fa-plus"></i>
							</button>
							<button class="btn btn-danger btn-xs">
								<i class="fa fa-trash"></i>
							</button>
							</div>
						</td>
						<td colspan="7" class="text-center {{$d['_indikator']?'bg bg-warning':''}}">
							@if($d['_indikator'])
							<b>INDIKATOR JENIS PELAYANAN</b>
							@endif
						</td>


					</tr>
					@foreach($d['_indikator'] as $i)
					<tr>
						
						<td>{{$i['kode']}}</td>
						<td style="width: 50px">
							<div class="btn-group-vertical">
								<button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$i['id']}})"><i class="fa fa-eye"></i>
                                </button>
                                 <button class="btn btn-warning btn-xs" onclick="showFormUpdateIndikator({{$i['id']}})"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-danger btn-xs" onclick="showFormDeleteIndikator({{$i['id']}})"><i class="fa fa-trash"></i>
                                </button>
							</div>
						</td>
						<td style="min-width: 120px;">{!!nl2br($i['uraian'])!!}</td>
						 <td >
                        @if(($i['tipe_value']==1)OR($i['tipe_value']==2))
                            {{number_format($i['target'],2)}}
                            @else
                                {{$i['target']}}

                            @endif

                            @if($i['tipe_value']==2)
                                <-> {{number_format($i['target_1'],2)}}

                            @endif

                       <b> {{$i['satuan']}}</b>

                    </td>
	                    
	                    <td class="{{$i['kw_p']?'':'bg-danger'}}" >
	                        {!!$i['kw_p']?'<i class="fa fa-check text-success"></i> BERWENANG':'<i class="fa fa-times text-danger"></i> TIDAK BERWENANG'!!}
	                    </td>
	                    <td class="{{$i['kw_k']?'':'bg-danger'}}" >
	                           {!!$i['kw_k']?'<i class="fa fa-check text-success"></i>  BERWENANG':'<i class="fa fa-times text-danger"></i> TIDAK BERWENANG'!!}
	                    </td>





					</tr>
					@endforeach
				@endforeach
			</tbody>
			<thead class="bg-navy">
				<tr>
					<th rowspan="2">SUB URUSAN</th>
					<th rowspan="2" colspan="2">JENIS PELAYANAN</th>
					<th colspan="4">INDIKATOR</th>
					<th colspan="2">KEWENANGAN</th>					
				</tr>
				<tr>
					<th colspan="2">KODE</th>
					<th>URAIAN</th>
					<th>TARGET</th>	
					<th >PROVINSI</th>	
					<th >KOTA / KABUPATEN</th>					
				</tr>
			</thead>
		</table>
	</div>
</div>

@stop


@section('js')

   <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-tabah-jenis-pelayanan">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
         <form action="{{route('int.spm.store')}}" method="post">
         	@csrf
         	 <div class="modal-body">
          	<div class="form-group">
          		<label>SUB URUSAN</label>
          		<select class="form-control init-use-select-2" name="sub_urusan">
          			<option value="">- TIDAK TERDEFINISI -</option>
          			@foreach($sub_urusan as $s)
          			<option value="{{$s['id']}}">{{$s['nama']}}</option>	
          			@endforeach
          		</select>
          	</div>

          	<div class="form-group">
          		<label>URAIAN JENIS PELAYANAN</label>
          		<textarea class="form-control" required="" name="uraian"></textarea>
          	</div>
            
          </div>
          <div class="modal-footer">
          	<button class="btn btn-primary">TAMBAH</button>
          </div>
         </form>
         
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-edit-jenis-pelayanan">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
            	EDIT JENIS PELAYANAN
            </h4>
          </div>
         <form action="{{route('int.spm.update')}}" method="post">
         	@csrf
         	 <div class="modal-body">
        <input type="hidden" name="id_spm" value="">

          	<div class="form-group">
          		<label>SUB URUSAN</label>
          		<select class="form-control init-use-select-2" name="sub_urusan">
          			<option value="">- TIDAK TERDEFINISI -</option>
          			@foreach($sub_urusan as $s)
          			<option value="{{$s['id']}}">{{$s['nama']}}</option>	
          			@endforeach
          		</select>
          	</div>

          	<div class="form-group">
          		<label>URAIAN JENIS PELAYANAN</label>
          		<textarea class="form-control" required="" name="uraian"></textarea>
          	</div>
            
          </div>
          <div class="modal-footer">
          	<button class="btn btn-primary">UPDATE</button>
          </div>
         </form>
         
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<script type="text/javascript">

	$('.init-use-select-2').select2();

	
	function edit_jenis_pelayanan(url,data){
		$('#modal-edit-jenis-pelayanan [name="sub_urusan"]').val(data.id_sub_urusan);
		// $('#modal-edit-jenis-pelayanan [name="sub_urusan"]').val(data);
		// $('#modal-edit-jenis-pelayanan [name="sub_urusan"] option[selected]').removeAttr('selected');
		// $('#modal-edit-jenis-pelayanan [name="sub_urusan"] option[value="'+data.id_sub_urusan+'"]').attr('selected','');

		$('#modal-edit-jenis-pelayanan [name="uraian"]').html(data.uraian);

		$('#modal-edit-jenis-pelayanan').modal();
			$('.init-use-select-2').trigger('change');


	}

	function tambah_indikator(url,data){
		API_CON.post(url,data).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('INDIKATOR SPAM {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}

	 function showFormDeleteIndikator(id){

        API_CON.get("{{route('int.m.indikator.form_delete',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('HAPUS INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }


    function showFormDetailIndikator(id){

        API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }

     function showFormUpdateIndikator(id){
        API_CON.get("{{route('int.m.indikator.form_edit',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('UPDATE INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }

</script>
@stop