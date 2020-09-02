@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>PROGRAM KEGIATAN {{$namapemda}} TAHUN ANGGARAN {{$tahun}}</h3>
      </div>
      
    </div>
@stop

@section('content')

<a href="{{route('prokeg.index')}}"><button class="btn btn-success btn-xs" > KEMBALI</button></a>
<a href="#"><button class="btn btn-info btn-xs" onclick="showFormCreatePnIndikator({{$kodepemda}})" > TAMBAH MISI</button></a>


  <div class="row">
      <div class="col-md-12">
        <div class="box box-solid box-info-gradient">
            <div class="box-body">
                   <table class="table table-borded" id="table-daerah">
              <thead>
                  <tr class="bg bg-navy">
                      <th>MISI</th>
                      <th>SASARAN</th>
                      <th>PROGRAM</th>
                      <th>DATA RKPD</th>
					  <th>PROGRAM RKPD</th>
					<th>KEGIATAN</th>
					<th>INDIKATOR</th>
					<th>TARGET</th>
					<th>SATUAN</th>
                  </tr>
                      </thead>
                      <tbody>
					  
                          @foreach($data as $d)
                            <tr>
                                <td>
								@if($d->misi<>'')
								 <table><tr><td>
							<span style="float:left;">	<button class="btn btn-success  btn-xs" onclick="showFormCreateSasaran({{$d->id_misi}})">
						<i data-toggle="tooltip" data-placement="top" title="TAMBAH PP" class="fa fa-plus"></i></button>
						<button class="btn btn-warning  btn-xs" onclick="showFormUpdatemisi({{$d->id_misi}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="delete_mandat.build('{{route('prokeg.hapus.misi',['id'=>$d->id_misi])}}','misi','{{$d->misi}}')"><i class="fa fa-trash"></i></button>
							</span>	</td><td>
								<p style="padding-left:10px">{{$d->misi}}</p>
								</td></tr></table>
								@endif
								</td>
                                <td>
								@if($d->sasaran<>'')																	 
							<table><tr><td>
						<span style="float:left;">		<button class="btn btn-success  btn-xs" onclick="showFormCreateProgram({{$d->id_sasaran}})">
						<i data-toggle="tooltip" data-placement="top" title="TAMBAH PP" class="fa fa-plus"></i></button>
						<button class="btn btn-warning  btn-xs" onclick="showFormUpdateSasaran({{$d->id_sasaran}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="delete_mandat.build('{{route('prokeg.hapus.sasaran',['id'=>$d->id_sasaran])}}','sasaran','{{$d->sasaran}}')""><i class="fa fa-trash"></i></button>
							</span></td><td>
							<p style="padding-left:10px">{{$d->sasaran}}</p>
							</td></tr></table>
								@endif
								</td>
                                <td> 
								@if($d->program_daerah<>'')
								<table><tr><td>

								<span style="float:left;">		
						<button class="btn btn-warning  btn-xs" onclick="showFormUpdateprogram({{$d->id_program}})"><i class="fa fa-pen"></i></button>
						<button class="btn btn-danger  btn-xs" onclick="delete_mandat.build('{{route('prokeg.hapus.program',['id'=>$d->id_program])}}','Program','{{$d->program_daerah}}')""><i class="fa fa-trash"></i></button>
							</span> </td><td>
							<p style="padding-left:10px">{{$d->program_daerah}}</p>
								</td></tr></table>
							@endif
							</td>
                                <td>
								@if($d->program_daerah<>'')
								        <a href="{{route('prokeg.pemetaan.pilihprogram',['id'=>$d->id_program,'kodepemda'=>$kodepemda])}}"" class="btn btn-success btn-xs" onclick="">PEMETAAN PROGRAM</a>
								@endif
								</td>
								<td>
								@if($d->program_rkpd<>'')

								<table><tr><td>

								<span style="float:left;">		
						<button class="btn btn-danger  btn-xs" onclick="delete_mandat.build('{{route('prokeg.hapus.program_rkpd',['id'=>$d->id_program_rkpd])}}','Program','{{$d->program_rkpd}}')""><i class="fa fa-trash"></i></button>
							</span> </td><td>
							<p style="padding-left:10px">{{$d->program_rkpd}}</p>
								</td></tr></table>
								@endif
								</td>
								<td>
								{{$d->kegiatan}}
								</td>
								<td>
								{{$d->indikator}}
								</td>
								<td>
								{{$d->target}}
								</td>
								<td>
								{{$d->satuan}}
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

	 
         


    </script>

@include('prokeg.partials.vue_modal_delete_sasaran');

<script type="text/javascript">
	function showFormCreatePnIndikator(id,jenis=null){
		API_CON.get("{{route('prokeg.tambah.misi.modal',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('Tambah Misi  {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}
function showFormCreateSasaran(id,jenis=null){
		API_CON.get("{{route('prokeg.tambah.sasaranmodal',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('Tambah Sasaran  {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}
function showFormCreateProgram(id,jenis=null){
		API_CON.get("{{route('prokeg.tambah.programmodal',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('Tambah Sasaran  {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}	
function showFormUpdateSasaran(id,jenis=null){
		API_CON.get("{{route('prokeg.ubah.sasaranmodal',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('Ubah Sasaran  {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}	
function showFormUpdatemisi(id,jenis=null){
		API_CON.get("{{route('prokeg.ubah.misimodal',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('Ubah Misi  {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}	
function showFormUpdateprogram(id,jenis=null){
		API_CON.get("{{route('prokeg.ubah.programmodal',['id'=>null])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('Ubah Program  {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}		
	</script>
@stop