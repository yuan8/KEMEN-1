@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">NOMENKLATUR {{$pro}} TAHUN {{Hp::fokus_tahun()}}</h3>
    	
    	</div>
    	
    	
    </div>
@stop


@section('content')
<div class="box-group">
    <button class="btn btn-primary" onclick="tambah_program()">TAMBAH PROGRAM</button>
</div>
<div class="box box-solid">
    <div class="box-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                     <th style=" max-width:100px;">
                        AKSI
                    </th>
                  
                    <th>
                        PROGRAM
                    </th>
                    <th>
                        KEGIATAN
                    </th>
                    <th>
                        SUB KEGIATAN
                    </th>
                </tr>
            </thead>
            <tbody >
                @php 
                    $prioritas_urusan=0;
                @endphp
                @foreach($data as $p)
                @if($prioritas_urusan!=$p['id_urusan_prio'])
                <tr class="bg-warning">
                    <td colspan="4">
                        <b>{{$p['_urusan_prio']['uraian']}}</b>
                    </td>
                   

                </tr>
                @php
                    $prioritas_urusan=$p['id_urusan_prio'];
                @endphp
                @endif
                <tr>
                    <td style=" max-width:100px;" class="text-right">
                         <div class="text-right">
                            <p><b>{{$p['kode']}}</b></p>
                        </div>
                       
                        <div class="btn-group">
                            <button class="btn btn-success btn-xs" onclick="tambah_kegiatan('{{route('int.nomen.store_kegiatan',['pro'=>$pro,'id_program'=>$p['id']])}}',{{$p['id']}})"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-warning btn-xs"><i class="fa fa-pen"></i></button>
                            <button class="btn btn-danger btn-xs" onclick="delete_nomen('{{route('int.nomen.delete',['pro'=>$pro,'id'=>$p['id']])}}',{{$p['id']}})"><i class="fa fa-trash"></i></button>

                        </div>
                         
                    </td>
                    <td>
                         <div class="">
                            <p><b>PROGRAM</b></p>
                        </div>
                    {{$p['uraian']}}</td>
                    <td></td>
                    <td></td>
                </tr>
                    @foreach($p['_child_kegiatan'] as $k)
                   <tr>
                        <td style=" max-width:100px;" class="text-right">
                              <div class="text-right">
                            <p><b>{{$k['kode']}}</b></p>
                        </div>
                            <div class="btn-group">
                            <button class="btn btn-success btn-xs" onclick="tambah_subkegiatan('{{route('int.nomen.store_subkegiatan',['pro'=>$pro,'id_program'=>$p['id'],'id_kegiatan'=>$k['id']])}}',{{$k['id']}})"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-warning btn-xs"><i class="fa fa-pen"></i></button>
                              <button class="btn btn-danger btn-xs" onclick="delete_nomen('{{route('int.nomen.delete',['pro'=>$pro,'id'=>$k['id']])}}',{{$k['id']}})"><i class="fa fa-trash"></i></button>
                        </div>
                      
                       
                        </td>
                        <td colspan="1"></td>

                    <td>
                         <div class="">
                            <p><b>KEGIATAN</b></p>
                        </div>
                    {{$k['uraian']}}</td>
                    <td></td>
                   </tr>
                        @foreach($k['_child_sub_kegiatan'] as $s)
                       <tr>
                          <td style=" max-width:100px;" class="text-right">
                              <div class="text-right">
                            <p><b>{{$s['kode']}}</b></p>
                        </div>
                            <div class="btn-group">
                           
                            <button class="btn btn-warning btn-xs"><i class="fa fa-pen"></i></button>
                              <button class="btn btn-danger btn-xs" onclick="delete_nomen('{{route('int.nomen.delete',['pro'=>$pro,'id'=>$s['id']])}}',{{$s['id']}})"><i class="fa fa-trash"></i></button>

                        </div>
                        
                        </td>
                        <td colspan="2"></td>
                        <td>
                             <div class="">
                            <p><b>SUBKEGIATAN</b></p>
                        </div>
                        {{$s['uraian']}}</td>
                       </tr>
                     @endforeach
                
                     @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@stop

@section('js')


<div class="modal fade " id="tambah-program">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title">
                    TAMBAH PROGRAM
                </h5>
            </div>
                <form accept="post" method="post" action="{{route('int.nomen.store_program',['pro'=>$pro])}}">

                    <div class="modal-body">
                            @csrf
                             <div class="form-group">
                                <label>URUSAN*</label>
                                <select id="select-urusan-prioritas" class="text-uppercase form-control" required="" name="urusan"></select>
                            </div>
                            <div class="form-group">
                                <label>KODE*</label>
                                <input type="text" class="form-control" name="kodeprogram" required="" placeholder="1.03.01.01">
                            </div>
                             <div class="form-group">
                                <label>URAIAN PROGRAM*</label>
                                <input type="text" class="form-control" placeholder="...." name="uraiprogram" required="">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">TAMBAH</button>
                    </div>
                </form>

                
        </div>
    </div>


</div>

<div class="modal fade " id="tambah-kegiatan">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title">
                    TAMBAH KEGIATAN
                </h5>
            </div>
                <form accept="post" method="post" action="" id="form-tambah-kegiatan">
                    <div class="modal-body">
                    <div id="parent"></div>

                    <hr>


                        <input type="hidden" name="kode_parent" value="" id="kode_parent">
                            @csrf
                           
                            <div class="form-group">
                                <label>KODE</label>
                                <div class="input-group">
                                  <span class="input-group-addon"  id="kode_parent_view"></span>
                                  <input type="text" class="form-control" name="kodekegiatan" required="" placeholder="1.03" aria-describedby="kode_parent_view">
                                </div>
                            </div>
                             <div class="form-group">
                                <label>URAIAN KEGIATAN</label>
                                <input type="text" class="form-control" placeholder="...." name="uraikegiatan" required="">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">TAMBAH</button>
                    </div>
                </form>

                
        </div>
    </div>

</div>

<div class="modal fade " id="tambah-subkegiatan">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title">
                    TAMBAH SUBKEGIATAN
                </h5>
            </div>
                <form accept="post" method="post" action="" id="form-tambah-kegiatan">
                    <div class="modal-body">
                    <div id="parent"></div>
                    <hr>

                        <input type="hidden" name="kode_parent" value="" id="kode_parent">
                            @csrf
                            <div class="form-group">
                                <label>KODE</label>
                                <div class="input-group">
                                  <span class="input-group-addon"  id="kode_parent_view"></span>
                                  <input type="text" class="form-control" name="kodesubkegiatan" required="" placeholder="1.03" aria-describedby="kode_parent_view">
                                </div>
                            </div>
                             <div class="form-group">
                                <label>URAIAN SUBKEGIATAN</label>
                                <input type="text" class="form-control" placeholder="...." name="uraisubkegiatan" required="">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">TAMBAH</button>
                    </div>
                </form>

                
        </div>
    </div>

</div>

<div class="modal fade " id="delete-nomen">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title">
                    HAPUS NOMENKLATUR
                </h5>
            </div>
                <form accept="post" method="post" action="" id="form-tambah-kegiatan">
                    <div class="modal-body">
                    <div id="parent"></div>

                    <input type="hidden" name="kode_parent" value="" id="kode_parent">
                        @csrf
                            
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">HAPUS</button>
                    </div>
                </form>

                
        </div>
    </div>

</div>

<script type="text/javascript">

    function tambah_program(){
        $('#tambah-program').modal();
        render_select();
    }
    
    function tambah_kegiatan(url,id_program){
        $.get('{{$pro=='PROVINSI'?route('int.nomen.api_data',['pro'=>$pro]):route('int.nomen.api_data',['pro'=>$pro])}}?id_nomen='+id_program,{pro:"{{$pro}}"},function(res){

            if(res){
                $('#tambah-kegiatan #kode_parent').val(res.kode+'.');
                $('#tambah-kegiatan #parent').html(res.uraian);

                $('#tambah-kegiatan #kode_parent_view').html(res.kode+'.');
                $('#tambah-kegiatan #form-tambah-kegiatan').attr('action',url);
                $('#tambah-kegiatan').modal();
            }

        });

        

    }
       function tambah_subkegiatan(url,id_program){
        $.get('{{$pro=='PROVINSI'?route('int.nomen.api_data',['pro'=>$pro]):route('int.nomen.api_data',['pro'=>'kota'])}}?id_nomen='+id_program,{pro:"{{$pro=='PROVINSI'?'provinsi':'kota'}}"},function(res){

            if(res){
                $('#tambah-subkegiatan #kode_parent').val(res.kode+'.');
                $('#tambah-subkegiatan #parent').html(res.uraian);

                $('#tambah-subkegiatan #kode_parent_view').html(res.kode+'.');
                $('#tambah-subkegiatan #form-tambah-kegiatan').attr('action',url);
                $('#tambah-subkegiatan').modal();
            }

        });



    }

    function delete_nomen(url,id_nomen){
        $.get('{{$pro=='PROVINSI'?route('int.nomen.api_data',['pro'=>$pro]):route('int.nomen.api_data',['pro'=>'kota'])}}?id_nomen='+id_nomen,{pro:"{{$pro=='PROVINSI'?'provinsi':'kota'}}"},function(res){

            if(res){
                $('#delete-nomen #parent').html('Hapus ('+res.kode+') '+res.uraian);

                $('#delete-nomen #form-tambah-kegiatan').attr('action',url);
                $('#delete-nomen').modal();
            }

        });
    }

    function render_select(){
       if($('#select-urusan-prioritas').html()!==undefined){
            $('#select-urusan-prioritas').select2({
                tags:true,
                dropdownParent: $('#select-urusan-prioritas').parent(),
                  ajax: {
                    url: "{{route('api.global.list_api_urusan_prio')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                      return {
                        q: params.term, // search term
                        page: params.page
                      };
                    },
                    processResults: function (data, params) {
                      // parse the results into the format expected by Select2
                      // since we are using custom formatting functions we do not need to
                      // alter the remote JSON data, except to indicate that infinite
                      // scrolling can be used
                      params.page = params.page || 1;

                      return {
                        results: data.data,
                        pagination: {
                          more: (params.page) < data.last_page
                        }
                      };
                    },
                    cache: true
                  },
                  placeholder: 'Search for a repository',

                });
       }
    }
</script>
@stop