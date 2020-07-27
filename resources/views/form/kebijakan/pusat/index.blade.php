@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3>KEBIJAKAN PUSAT </h3>
    	</div>
    	<div class="col-md-4 modal-footer">
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
                    <td colspan="6" class="text-center bg bg-warning">
                      <button class="btn btn-warning btn-sm" onclick="tambah_mandat.build('{{$kb->nama}}','{{route('kebijakan.pusat.store.mandat',['id'=>$kb->id])}}')"> <i class="fa fa-plus"></i> Mandat/Kegiatan </button>
                    </td>
                  </tr> 
                  <?php 
                  $id_sub_urusan=$kb->id;
                  ?>               
                @endif
                 @if(($id_mandat!=$kb->id_mandat)&&(!empty($kb->id_mandat)))
                  <tr class="">
                    <td colspan="1"></td>
                    <td>
                      <button class="btn btn-danger btn-xs" onclick="delete_mandat.build('{{route('kebijakan.pusat.delete',['id'=>$kb->id_mandat])}}','{{$kb->mandat}}','{{$kb->nama}}')">
                        <i class="fa fa-trash"></i> {{$kb->tipe?'Mandat':'Kegiatan'}}
                      </button>
                    </td>
                    <td>{!!$kb->tipe?'<i class="fa fa-circle text-warning"></i>':'<i class="fa fa-circle text-info"></i>'!!} {{$kb->mandat}}</td>
                    <td class="text-center">
                      <button onclick="plus_uu.build('#plus-uu','{{$kb->mandat}}','{{route('kebijakan.pusat.store.mandat.uu',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.uu',['id_mandat'=>$kb->id_mandat])}}','{{$kb->uu}}')" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> UU</button>
                    </td>
                    <td class="text-center">
                      <button onclick="plus_pp.build('#plus-pp','{{$kb->mandat}}','{{route('kebijakan.pusat.store.mandat.pp',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.pp',['id_mandat'=>$kb->id_mandat])}}','{{$kb->pp}}')" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> PP</button>
                    </td>
                     <td class="text-center">
                      <button onclick="plus_perpres.build('#plus-perpres','{{$kb->mandat}}','{{route('kebijakan.pusat.store.mandat.perpres',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.perpres',['id_mandat'=>$kb->id_mandat])}}','{{$kb->perpres}}')" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> perpres</button>
                    </td>
                     <td class="text-center">
                      <button onclick="plus_permen.build('#plus-permen','{{$kb->mandat}}','{{route('kebijakan.pusat.store.mandat.permen',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.pusat.store.permen',['id_mandat'=>$kb->id_mandat])}}','{{$kb->permen}}')" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> permen</button>
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
                    mandat:''
                  },
                  methods:{
                    build:function(sub_urusan,link){
                      this.action=link;
                      this.sub_urusan=sub_urusan;
                        
                        setTimeout(function(){
                          $('#tm[type="checkbox"]').change(function(){
                            tambah_mandat.tipe=!$(this).prop('checked');
                          });
                          $('#plus-mandat').modal();
                        },300);


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