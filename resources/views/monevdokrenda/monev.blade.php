@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>MONITORING DAN EVALUASI PELAKSANAAN RENCANA PEMBANGUNAN DAERAH LINGKUP SUPD 2 </h3>
		<h4>PEMDA : {{$pemda}}</h4>
      </div>
      
    </div>
@stop

@section('content')
  <a href="{{route('monev.dokrenda.index')}}"><button class="btn btn-success btn-xs" > KEMBALI</button></a>

  <div class="row">
      <div class="col-md-12">
        <div class="box box-solid box-info-gradient">
            <div class="box-body">
                   <table class="table table-borded" id="table-daerah">
              <thead>
                  <tr class="bg bg-navy">
                    <th>PROGRAM</th>
                    <th>KEGIATAN</th>
                    <th>SUB KEGIATAN</th>
                    <th>INDIKATOR</th>
					<th>TARGET</th>
					<th>ACTION</th>
					<th>PROGRES PELAKSANAAN</th>
					<th>PERMASALAHAN</th>
					<th>TINDAK LANJUT</th>
					
                  </tr>
                      </thead>
						<tbody>
@foreach($data as $key=>$d)
					<tr>
                    <td>{{$d->program}}</td>
                    <td>{{$d->kegiatan}}</td>
                    <td></td>
					<td>{{$d->indikator}}</td>
                    <td>{{$d->target}}&nbsp;&nbsp;&nbsp; {{$d->satuan}}</td>
					<td>
					<table><tr><td>
					@if($d->id_progres)
							<span style="float:left;">	
						<button class="btn btn-warning  btn-xs" onclick="editMonev({{$d->id_progres}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="delete_mandat.build('{{route('monev.delete.progres',['id'=>$d->id_progres])}}','Monev','{{$d->permasalahan}}')"><i class="fa fa-trash"></i></button>
							</span>	
					@else		
						<span style="float:left;">	<button class="btn btn-success  btn-xs" onclick="showMonev({{$d->id_indikator_kegiatan}})">
						<i data-toggle="tooltip" data-placement="top" title="TAMBAH PP" class="fa fa-plus"></i></button>
						</span>
					@endif
					</td><td>
								<p style="padding-left:10px"></p>
								</td></tr></table>
					</td>
					<td>{{$d->progres}}</td>
					<td>{{$d->permasalahan}}</td>
					<td>{{$d->tindak_lanjut}}</td>
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
@include('prokeg.partials.vue_modal_delete_sasaran');

    <script type="text/javascript">
        $('#table-daerah').DataTable({
             pageLength: 15,ordering:false
        });
function showMonev(id){
		API_CON.get("{{route('monev.update.insert',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('MONEV PROGRES  {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}
function editMonev(id){
		API_CON.get("{{route('monev.update.update',['id'=>null])}}/"+id,).then(function(res){
			$('#modal-global .modal-header .modal-title').html('MONEV PROGRES  {{Hp::fokus_tahun()}}');
			$('#modal-global .modal-body').html(res.data);
			$('#modal-global').modal();
		});
	}
	
	
    </script>
@stop