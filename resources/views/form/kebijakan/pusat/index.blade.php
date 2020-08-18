@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3>KEBIJAKAN PUSAT </h3>
    	</div>
    	<div class="col-md-4">
        <br>
        <div class="btn-group pull-right">
          <a href="{{route('int.kb.resume',['pdf'=>'export'])}}" class="btn btn-success btn-xs">DOWNLOAD RESUME</a>
        </div>
    	</div>
    </div>
@stop

@section('content')
  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-warning">
  			<div class="box-body table-responsive">
  				<table class="table table-sriped table-bordered">
		  			<thead>
		  				<tr>
		  					<th>SUB URUSAN</th>
                <th></th>
		  					<th>MANDAT</th>
		  					<th>UU</th>
		  					<th>PP</th>
		  					<th>PERPRES</th>
		  					<th>PERMEN</th>
		  				</tr>
		  			</thead>
            <tbody>
              <?php
                $id_sub_urusan=0;
                $id_mandat=0;


               ?>
              @foreach($kebijakan as $kb)
                @if($id_sub_urusan!=$kb->id)
                  <tr class="">
                   
                    <td>{{$kb->nama}}</td>
                    <td colspan="6" class="text-center bg bg-success">
                      <button class="btn btn-success btn-sm" onclick="tambah_mandat.build('{{$kb->nama}}','{{route('kebijakan.pusat.store.mandat',['id'=>$kb->id])}}')"> <i class="fa fa-plus"></i> Mandat/Kegiatan </button>
                       
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

                        console.log(m_{{$kb->id_mandat}}.tipe);
                      </script>

                  <tr class="">
                    <td colspan="1"></td>
                    <td>
                      
                        <button class="btn btn-danger btn-xs" onclick="delete_mandat.build('{{route('kebijakan.pusat.delete',['id'=>$kb->id_mandat])}}',kbm_{{$kb->id_mandat}},'{{$kb->nama}}')">
                         
                        <i class="fa fa-trash"></i> {{$kb->tipe?'Mandat':'Kegiatan'}}
                      </button>
                      <button class="btn {{$kb->tipe?'btn-warning':'btn-info'}} btn-xs" onclick="update_mandat.build('{{$kb->nama}}','{{route('kebijakan.pusat.update',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}',m_{{$kb->id_mandat}})">
                        <i class="fa fa-pen"></i> {{$kb->tipe?'Mandat':'Kegiatan'}}
                      </button>
                    </td>
                    <td>{!!$kb->tipe?'<i class="fa fa-circle text-warning"></i>':'<i class="fa fa-circle text-info"></i>'!!}  {{$kb->tipe?'Mandat':'Kegiatan'}} <br> {!!nl2br($kb->mandat)!!}</td>
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
                      <button onclick="plus_permen.build('#plus-permen',kbm_{{$kb->id_mandat}},'{{route('kebijakan.pusat.store.mandat.permen',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.permen',['id_mandat'=>$kb->id_mandat])}}',kbpemen_{{$kb->id_mandat}})" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> PERMEN</button>
                    </td>
                    
                  <?php 
                  $id_mandat=$kb->id_mandat;
                  ?>               
                @endif
                @if(!empty($kb->id_mandat))
                <tr>
                  <td colspan="3"></td>
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

                @endif
            
              @endforeach
            </tbody>

		  		</table>
  			</div>
  		</div>
      {{$kebijakan->links()}}
  	</div>
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
                          <label class="text-center">Uraian <span v-if='tipe==0' >Mandat</span><span v-if='tipe==1'>Kegiatan</span> </label>
                          <textarea class="form-control" v-model="mandat" required="" name="uraian" style="min-height: 150px;"></textarea>
                        </div>
                        <div class="form-group">
                          <label class="checkbox-inline" style="min-width: 100px;">
                           <input id="tm"  type="checkbox" checked data-toggle="toggle" name="tipe" data-onstyle="warning" data-on="Mandat" data-off="Kegiatan" data-offstyle="info" data-size="small" data-width="100%"> 
                          </label>
                        </div>
                      </div>
                      <div class="modal-footer">
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah</button>
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
                        <h4 class="text-uppercase">Update <span v-if='tipe==0' >Mandat</span><span v-if='tipe==1'>Kegiatan</span> | <span>@{{sub_urusan}}</span></h4>
                      </div>
                      <div class="modal-body" >
                        <div class="form-group">
                          <label class="text-center">Uraian <span v-if='tipe==0' >Mandat</span><span v-if='tipe==1'>Kegiatan</span> </label>
                          <textarea class="form-control" v-model="mandat" required="" name="uraian" style="min-height: 150px;"></textarea>
                        </div>
                        <div class="form-group">
                          <label class="checkbox-inline" style="min-width: 100px;">
                           <input id="tm" type="checkbox" checked data-toggle="toggle" name="tipe" data-onstyle="warning" data-on="Mandat" data-off="Kegiatan" data-offstyle="info" data-size="small" data-width="100%"> 
                          </label>
                        </div>
                      </div>
                      <div class="modal-footer">
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-pen"></i> Update</button>
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
                    mandat:''
                  },
                  methods:{
                    build:function(sub_urusan,link,x){
                      this.action=link;
                      this.sub_urusan=sub_urusan;
                      this.tipe=x.tipe?0:1;
                      this.mandat=x.mandat;

                        setTimeout(function(){
                          $('#update-mandat #tm[type="checkbox"]').change(function(){
                            update_mandat.tipe=!$(this).prop('checked');
                          });
                          $('#update-mandat').modal();
                        },500);


                    }
                  }

          }); 

            


    </script>




@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'uu']);
@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'pp']);
@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'permen']);
@include('form.kebijakan.pusat.partials.vue_modal_kebijakan',['tag'=>'perpres']);
@include('form.kebijakan.pusat.partials.vue_modal_delete_mandat');




@stop