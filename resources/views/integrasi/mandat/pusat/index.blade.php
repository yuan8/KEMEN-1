@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3>KEBIJAKAN PUSAT </h3>
    	</div>
    <div class="col-md-4">
      <br>
     
      </div>
    </div>
<style type="text/css">
  

</style>
     <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.theme.default.css')}}">
  <script type="text/javascript" src="{{asset('bower_components/jquery-treetable/jquery.treetable.js')}}"></script>
  <style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
      vertical-align:middle!important;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered{
          white-space: unset;
    }
    thead tr{
      height: 40px!important;
    }
  </style>
@stop

@section('content')
   <div class="form-group ">
          <a href="{{route('int.kb.resume',['pdf'=>'true'])}}" class="btn btn-success btn-sm">DOWNLOAD RESUME</a>
        </div>
  	<div class=" table-responsive">
  		
  				<table class="table table-fixed bg-white table-bordered  table-hover " id="table-data">
		  			
            <tbody>
              <?php
                $id_sub_urusan=0;
                $id_mandat=0;
               ?>
              @foreach($kebijakan as $kb)
                @if($id_sub_urusan!=$kb->id)
                  <tr class="" data-tt-id="sub-{{$kb->id}}">
                   
                    <td style="width: 200px;">{{$kb->nama}}</td>
                    <td style="width:200px;">
                      <button class="btn btn-primary btn-xs" onclick="tambah_mandat.build('{{$kb->nama}}','{{route('kebijakan.pusat.store.mandat',['id'=>$kb->id])}}')"> <i class="fa fa-plus"></i> MANDAT </button>
                    </td>
                    <td colspan="5" class="text-center " >
                      
                       
                    </td>
                  </tr> 
                  <?php 
                  $id_sub_urusan=$kb->id;
                  ?>               
                @endif
                 @if(($id_mandat!=$kb->id_mandat)&&(!empty($kb->id_mandat)))
                   <script type="text/javascript">
                          var kbm_{{$kb->id_mandat}}=<?php echo json_encode((array)$kb,true);?>;
                          var m_{{$kb->id_mandat}}=kbm_{{$kb->id_mandat}};
                          var kbuu_{{$kb->id_mandat}}=kbm_{{$kb->id_mandat}}.uu||'';
                          var kbpermen_{{$kb->id_mandat}}=kbm_{{$kb->id_mandat}}.permen||'';
                          var kbperpres_{{$kb->id_mandat}}=kbm_{{$kb->id_mandat}}.perpres||'';
                          var kbpp_{{$kb->id_mandat}}=kbm_{{$kb->id_mandat}}.pp||'';
                          var kbm_{{$kb->id_mandat}}=kbm_{{$kb->id_mandat}}.mandat||'';
                    </script>

                  <tr class="" data-tt-id="mandat-{{$kb->id_mandat}}" data-tt-parent-id="sub-{{$kb->id}}" >
                    <td colspan="1"></td>
                    <td>
                     {!!$kb->tipe?'<i class="fa fa-circle text-warning"></i>':'<i class="fa fa-circle text-info"></i>'!!}  {{$kb->tipe?'REGULASI':'KEGIATAN'}} <br>

                    </td>
                    <td  style="width:200px;"> <div class="btn-group">
                        <button class="btn btn-danger btn-xs" onclick="delete_mandat.build('{{route('kebijakan.pusat.delete',['id'=>$kb->id_mandat])}}',kbm_{{$kb->id_mandat}},'{{$kb->nama}}')">
                         
                        <i class="fa fa-trash"></i> {{$kb->tipe?'REGULASI':'KEGIATAN'}}
                      </button>
                      <button class="btn btn-warning btn-xs" onclick="update_mandat.build('{{$kb->nama}}','{{route('kebijakan.pusat.update',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}',m_{{$kb->id_mandat}},'{{$kb->id_mandat}}')">
                        <i class="fa fa-pen"></i> {{$kb->tipe?'REGULASI':'KEGIATAN'}}
                      </button>
                      </div></td>
                    <td class="text-center">
                      <button onclick="plus_uu.build('#plus-uu',kbm_{{$kb->id_mandat}},'{{route('kebijakan.pusat.store.mandat.uu',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.uu',['id_mandat'=>$kb->id_mandat])}}',kbuu_{{$kb->id_mandat}})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> UU</button>
                    </td>
                    <td class="text-center">
                      <button onclick="plus_pp.build('#plus-pp',kbm_{{$kb->id_mandat}},'{{route('kebijakan.pusat.store.mandat.pp',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.pp',['id_mandat'=>$kb->id_mandat])}}',kbpp_{{$kb->id_mandat}})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> PP</button>
                    </td>
                     <td class="text-center">
                      <button onclick="plus_perpres.build('#plus-perpres',kbm_{{$kb->id_mandat}},'{{route('kebijakan.pusat.store.mandat.perpres',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.perpres',['id_mandat'=>$kb->id_mandat])}}',kbperpres_{{$kb->id_mandat}})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> PERPRES</button>
                    </td>
                     <td class="text-center">
                      <button onclick="plus_permen.build('#plus-permen',kbm_{{$kb->id_mandat}},'{{route('kebijakan.pusat.store.mandat.permen',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.permen',['id_mandat'=>$kb->id_mandat])}}',kbpermen_{{$kb->id_mandat}})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> PERMEN</button>
                    </td>
                    
                  <?php 
                  $id_mandat=$kb->id_mandat;
                  ?>               
                @endif
                @if(!empty($kb->id_mandat))
                <tr data-tt-id="data-{{$kb->id_mandat}}" data-tt-parent-id="sub-{{$kb->id}}">
                  <td colspan=""></td>
                  <td colspan=""></td>

                  <td> {!!nl2br($kb->mandat)!!}</td>
                  <td>
                    @if(!empty($kb->uu))
                     <ul>
                      <?php $duu=explode('|@|',$kb->uu); ?>
                      @foreach($duu as $uu)
                      <?php $uu=explode('(@)', $uu) ?>

                      <li>{{$uu[1]}}</li>
                      @endforeach


                     </ul>

                    @endif

                  </td>

                  <td>
                    @if(!empty($kb->pp))
                     <ul>
                      <?php $duu=explode('|@|',$kb->pp); ?>
                      @foreach($duu as $uu)
                      <?php $uu=explode('(@)', $uu) ?>

                      <li>{{$uu[1]}}</li>
                      @endforeach


                     </ul>

                    @endif

                  </td>
                  <td>
                    @if(!empty($kb->perpres))
                     <ul>
                      <?php $duu=explode('|@|',$kb->perpres); ?>
                      @foreach($duu as $uu)
                      <?php $uu=explode('(@)', $uu) ?>

                      <li>{{$uu[1]}}</li>
                      @endforeach


                     </ul>

                    @endif

                  </td>
                  <td>
                    @if(!empty($kb->permen))
                     <ul>
                      <?php $duu=explode('|@|',$kb->permen); ?>
                      @foreach($duu as $uu)
                      <?php $uu=explode('(@)', $uu) ?>

                      <li>{{$uu[1]}}</li>
                      @endforeach


                     </ul>

                    @endif

                  </td>

                </tr>
                <tr data-tt-id="sp-{{$kb->id_mandat}}" data-tt-parent-id="sub-{{$kb->id}}">
                  <td class=""  style="background: #ddd" colspan="7"></td>
                </tr>

                @endif
                
              @endforeach
            </tbody>
            <thead class="bg-navy">
              <tr class="">
                <th>SUB URUSAN</th>
                <th></th>
                <th style="min-width: 250px;">MANDAT</th>
                <th style="min-width: 250px;">UU</th>
                <th style="min-width: 250px;">PP</th>
                <th style="min-width: 250px;">PERPRES</th>
                <th style="min-width: 250px;">PERMEN</th>
              </tr>
            </thead>

		  		</table>
  			
  </div>




@stop

@section('js')

    <div class="modal fade" id="plus-mandat">
          <div class="modal-dialog">
                <form  v-bind:action="action" method="post">

              <div class="modal-content">
                      <div class="modal-header text-center">
                        <h4 class="text-uppercase">Tambah <span v-if='tipe==0' >Mandat</span><span v-if='tipe==1'>Kegiatan</span> | <span>@{{sub_urusan}}</span></h4>
                      </div>
                      <div class="modal-body" >
                        <div class="form-group">
                          <label class="text-center">URAIAN <span v-if='tipe==0' >Mandat</span><span v-if='tipe==1'>Kegiatan</span> </label>
                          <textarea class="form-control" v-model="mandat" required="" name="uraian" style="min-height: 150px;"></textarea>
                        </div>
                        <div class="form-group">
                          <label class="checkbox-inline" style="min-width: 100px;">
                           <input id="tm"  type="checkbox" checked data-toggle="toggle" name="tipe" data-onstyle="warning" data-on="Mandat" data-off="Kegiatan" data-offstyle="info" data-size="small" data-width="100%"> 
                          </label>
                        </div>
                      </div>
                      <div class="modal-footer">
                         <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                        <button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-plus"></i> Tambah</button>
                      </div>
                   @csrf

                </div>
               </form>
          </div>
        </div>


        <script type="text/javascript">
                
          var tambah_mandat=new Vue({
                  el:'#plus-mandat',
                  data:{
                    tipe:0,
                    action:'',
                    sub_urusan:'',
                    update:null,
                    mandat:''
                  },
                  methods:{
                    build:function(sub_urusan,link){
                      this.action=link;
                      this.sub_urusan=sub_urusan;
                        
                        setTimeout(function(){
                          $('#plus-mandat #tm[type="checkbox"]').change(function(){
                            tambah_mandat.tipe=!$(this).prop('checked');
                          });
                          $('#plus-mandat').modal();
                        },300);


                    }
                  }

          }); 

            


    </script>

    <div class="modal fade" id="update-mandat">
          <div class="modal-dialog">
                <form  v-bind:action="action" method="post">
                  @method('PUT')
              <div class="modal-content">
                      <div class="modal-header text-center">
                        <h4 class="text-uppercase">Update <span v-if='tipe==0' >REGULASI</span><span v-if='tipe==1'>KEGIATAN</span> | <span>@{{sub_urusan}}</span></h4>
                      </div>
                      <div class="modal-body" >
                        <div class="form-group">
                          <label class="text-center">URAIAN <span v-if='tipe==0' >REGULASI</span><span v-if='tipe==1'>KEGIATAN</span> </label>
						  <input v-model="id" name="id_mandat" hidden />
                          <textarea class="form-control" v-model="mandat" required="" name="uraian" style="min-height: 150px;"></textarea>
                        </div>
                        <div class="form-group">
                          <label  style="min-width: 100px;">
						  
                           <input class="tm" type="checkbox"  data-toggle="toggle" name="tipe" data-onstyle="warning" data-on="REGULASI" data-off="KEGIATAN" data-offstyle="info" data-size="small" data-width="100%"> 
                          </label>
                        </div>
                      </div>
                      <div class="modal-footer">
                         <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                        <button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-pen"></i> Update</button>
                      </div>
                   @csrf

                </div>
               </form>
          </div>
        </div>


        <script type="text/javascript">
                
          var update_mandat=new Vue({
                  el:'#update-mandat',
                  data:{
                    tipe:0,
                    action:'',
                    sub_urusan:'',
                    update:true,
                    mandat:'',
					id:''
                  },
				  
                  methods:{
                    build:function(sub_urusan,link,x,id){
                      this.action=link;
                      this.sub_urusan=sub_urusan;
                      this.tipe=x.tipe?0:1;
                      this.mandat=x.mandat;
					  this.id=id;
                        setTimeout(function(){
                          $('#update-mandat .tm[type="checkbox"]').change(function(){
                            update_mandat.tipe=!$(this).prop('checked');
                          });
                          $('#update-mandat').modal();
                        },500);

					if(this.tipe==1){
						
						$('.tm').bootstrapToggle('off');
						} else{
			
						$('.tm').bootstrapToggle('on');
							};	
					
					

                    }
                  }

          }); 

            

        $("#table-data").treetable({ expandable: true,column:1,initialState: 'Expand'},true);


    </script>




@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'uu']);
@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'pp']);
@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'permen']);
@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'perpres']);
@include('form.kebijakan.pusat.partials.vue_modal_delete_mandat');




@stop