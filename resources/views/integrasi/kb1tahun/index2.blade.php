@extends('adminlte::page')
@section('content_header')
<div class="row">
  <div class="col-md-8">
    <h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN ({{Hp::fokus_tahun()}})
    </h3>
  </div>
</div>
 <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.theme.default.css')}}">
	<script type="text/javascript" src="{{asset('bower_components/jquery-treetable/jquery.treetable.js')}}"></script>
	<style type="text/css">
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
			vertical-align:middle!important;
		}
	</style>
@stop
@section('content')
<div class="box box-solid   ">
  <div class="box-body ">

    <div class="btn-group">
      <button onclick="showFormCreatePn()" class="btn btn-primary text-uppercase">TAMBAH PN</button>
      <button onclick="showFormCreatePn('MAJOR')" class="btn btn-info  text-uppercase">TAMBAH MAJOR PROJECT</button>

    <a href="{{route('int.kb1tahun.download',['pdf'=>'true'])}}" class="btn btn-success text-uppercase">DOWNLOAD DATA</a>
    </div>

  </div>
</div>
<hr>
<div class="box">

  <div class="box-body ">
    <table class="table table-bordered table-hover" id="data-table">
      @foreach($data as $pn)
        @include('integrasi.kb1tahun.partial.head_indikator',['d'=>$pn,'parent'=>[],'level'=>1])
        @foreach($pn['_tag_indikator'] as $tagpni )
          @include('integrasi.kb1tahun.partial.indikator',['di'=>$tagpni,'parent'=>$pn])
        @endforeach
        @foreach($pn['_child_pp'] as $pp )
          @include('integrasi.kb1tahun.partial.head_indikator',['d'=>$pp,'parent'=>$pn,'level'=>2])
          @foreach($pp['_tag_indikator'] as $tagpni )
            @include('integrasi.kb1tahun.partial.indikator',['di'=>$tagpni,'parent'=>$pp])
          @endforeach
          @foreach($pp['_child_kp'] as $kp )
            @include('integrasi.kb1tahun.partial.head_indikator',['d'=>$kp,'parent'=>$pp,'level'=>3])
              @foreach($kp['_tag_indikator'] as $tag )
                @include('integrasi.kb1tahun.partial.indikator',['di'=>$tag,'parent'=>$kp])
              @endforeach
             @foreach($kp['_child_propn'] as $propn )
              @include('integrasi.kb1tahun.partial.head_indikator',['d'=>$propn,'parent'=>$kp,'level'=>4])
              @foreach($propn['_tag_indikator'] as $tag )
                @include('integrasi.kb1tahun.partial.indikator',['di'=>$tag,'parent'=>$propn])
              @endforeach
              @foreach($propn['_child_proyek'] as $proyek )
                @include('integrasi.kb1tahun.partial.head_indikator',['d'=>$proyek,'parent'=>$propn,'level'=>5])
                @foreach($propn['_tag_indikator'] as $tag )
                  @include('integrasi.kb1tahun.partial.indikator',['di'=>$tag,'parent'=>$proyek])
                @endforeach
              @endforeach
            @endforeach
          @endforeach
        @endforeach
      @endforeach
      <thead class="bg-navy">
        <tr>
          <th>ACTION</th>
          <th>URAIAN</th>
          <th colspan="5">INDIKATOR</th>


        </tr>
      </thead>
</table>
</div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$("#data-table").treetable({ expandable: true,column:1,initialState: 'Expand'},true);



  function nameRKP(jenis){
    switch(jenis){
      case -1:
        jenis='MAJOR PROJECT';
      break;
      case 1:
        jenis='PN';
      break;
      case 2:
        jenis='PP';
      break;
      case 3:
        jenis='KP';
      break;
      case 4:
        jenis='PROPN';
      break;
      case 5:
        jenis='PROYEK';
      break;
    }

    return jenis;
  }



  function showFormDetailIndikator(id){

    API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
      $('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
      $('#modal-global-lg .modal-body').html(res.data);
      $('#modal-global-lg').modal();
    });
  }

  function showFormCreatePn(major=null){
    API_CON.get("{{route('int.kb1tahun.pn_create')}}"+(major?'?major=true':'')).then(function(res){
      $('#modal-global-lg .modal-header .modal-title').html('TAMBAH '+(major?'MAJOR PROJECT':'')+' {{Hp::fokus_tahun()}}');
      $('#modal-global-lg .modal-body').html(res.data);
      $('#modal-global-lg').modal();
    });
  }

  function showFormViewPn(id,jenis=null){
    API_CON.get("{{route('int.kb1tahun.pn_view',['id'=>''])}}/"+id).then(function(res){
      $('#modal-global-lg .modal-header .modal-title').html('UBAH '+nameRKP(jenis)+' {{Hp::fokus_tahun()}}');
      $('#modal-global-lg .modal-body').html(res.data);
      $('#modal-global-lg').modal();
    });
  }

  function showFormDeletePn(id,jenis=null){
    API_CON.get("{{route('int.kb1tahun.pn_form_delete',['id'=>''])}}/"+id).then(function(res){
      $('#modal-global-lg .modal-header .modal-title').html('DELETE '+nameRKP(jenis)+' {{Hp::fokus_tahun()}}');
      $('#modal-global-lg .modal-body').html(res.data);
      $('#modal-global-lg').modal();
    });
  }

  function showFormCreatePnIndikator(id,jenis=null){
    API_CON.get("{{route('int.kb1tahun.pn_indikator',['id'=>''])}}/"+id).then(function(res){
      $('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR '+nameRKP(jenis)+' {{Hp::fokus_tahun()}}');
      $('#modal-global-lg .modal-body').html(res.data);
      $('#modal-global-lg').modal();
    });
  }

  function showFormNested(id,jenis){
    API_CON.get("{{route('int.kb1tahun.nested_create',['id'=>''])}}/"+id).then(function(res){
      $('#modal-global-lg .modal-header .modal-title').html('TAMBAH  '+nameRKP(jenis+1)+' {{Hp::fokus_tahun()}}');
      $('#modal-global-lg .modal-body').html(res.data);
      $('#modal-global-lg').modal();
    });
  }


  function showFormDetailDeleteIndikator(id,jenis){
    API_CON.get("{{route('int.kb1tahun.indikator_form_delete',['id'=>''])}}/"+id).then(function(res){
      $('#modal-global-lg .modal-header .modal-title').html('HAPUS INDIKATOR  '+nameRKP(jenis+1)+' {{Hp::fokus_tahun()}}');
      $('#modal-global-lg .modal-body').html(res.data);
      $('#modal-global-lg').modal();
    });
  }
</script>
<style type="text/css">
  .btn-group-bt-5 .btn{
    margin-bottom: 5px;
  }


table.treetable span.indenter{
  display: inline-flex;
}
</style>
@stop
