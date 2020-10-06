@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN <span class="text-success">{{$daerah->nama}}</span> </h3>
    	</div>
    	<div class="col-md-4 modal-footer">
    		<a href="" class="btn btn-success">DOWNLOAD DATA</a>
    	</div>
    </div>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-body table-responsive">
                <table class="table table-bordered ">
                   
                    <tbody>
                        <?php
                            $id_sub_urusan=0;
                            $id_mandat=0;

                         ?>
                        @foreach($datas as $kb)
                          <script type="text/javascript">
                            var mandat_{{$kb->id_mandat}}=<?php echo json_encode($kb); ?>;
                          </script>
                            @if(($id_sub_urusan!=$kb->id)&&(!empty($kb->id)))
                                <tr class="bg bg-warning">
                                    <td>{{$kb->nama}}</td>
                                    <td colspan="5" class="bg bg-warning"></td>
            
                                </tr>
                                <?php $id_sub_urusan=$kb->id; ?>
                            @endif
                             @if(($id_mandat!=$kb->id_mandat)&&(!empty($kb->id_mandat)))

                              @if((!empty($kb->id_integrasi)))
                                  <tr class="{{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'bg-success':'bg-warning') }}">
                                      <td></td>
                                      <td>
                                          <p><b>REGULASI</b></p>

                                        {!!$kb->tipe?'<i class="fa fa-circle text-warning"></i>':'<i class="fa fa-circle text-info"></i>'!!}

                                       {{$kb->mandat}}</td>

                                      <td class="bg " >
                                          <p><b> {{$kb->kesesuaian==0?'BELUM DINILAI':(($kb->kesesuaian==1)?'SESUAI':'TIDAK SESUAI') }}</b></p>
                                          <button onclick="update_kesesuian.build(mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.update.kesesuian',['id'=>$kb->id_integrasi])}}',{{$kb->id_integrasi}},{{$kb->kesesuaian}},mandat_{{$kb->id_mandat}}.note)" class="btn btn-xs {{$kb->kesesuaian==0?'btn-danger':(($kb->kesesuaian==1)?'btn-success':'btn-warning') }}">
                                             <i class="fa fa-pen"></i>

                                          </button>
                                      </td>
                                      <td>
                                      

                                          <button class="btn btn-info btn-xs" onclick="plus_perda.build('#plus-perda',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perda',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perda',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perda,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERDA
                                          </button>
                                      </td>
                                      <td>
                                        <script type="text/javascript">
                                         var perkada_{{$kb->id}}=<?php echo json_encode($kb); ?>;
                                       </script>
                                            <button class="btn btn-info btn-xs" onclick="plus_perkada.build('#plus-perkada',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perkada',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perkada',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perkada,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERKADA
                                          </button>
                                      </td>
                                     <td>
                                            <button class="btn btn-info btn-xs" onclick="plus_lainnya.build('#plus-lainnya',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.lainnya',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.lainnya',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.lainnya,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> LAINNYA
                                          </button>
                                      </td>
                                     
                                  </tr>
                                  <tr class="{{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'bg-success':'bg-warning') }}">
                                      <td colspan="3"></td>
                                      <td>
                                          <p><b>PERDA</b></p>
                                          @if(!empty($kb->perda))
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->perda); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{{$uu[1]}}</li>
                                            @endforeach


                                           </ul>

                                          @endif

                                      </td>
                                      <td>
                                          <p><b>PERKADA</b></p>

                                          @if(!empty($kb->perkada))
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->perkada); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{{$uu[1]}}</li>
                                            @endforeach


                                           </ul>

                                          @endif

                                      </td>
  									                     <td>
                                          <p><b>LAINNYA</b></p>

                                          @if(!empty($kb->lainnya))
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->lainnya); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{{$uu[1]}}</li>
                                            @endforeach


                                           </ul>

                                          @endif

                                      </td>
                                  </tr>

                                 @if(!empty($kb->note))
                                  <tr class="{{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'bg-success':'bg-warning') }}">
                                      <td colspan="2"></td>
                                      <td colspan="4">
                                          <div>Note:</div>
                                          <div>{!!nl2br($kb->note)!!}</div>
                                      </td>
                                  </tr>

                                 @endif

                            @else
                                <tr>
                                    
                                    
                                    <td></td>
                                    <td>
                                        <p><b>REGULASI</b></p>

                                      {!!$kb->tipe?'<i class="fa fa-circle text-warning"></i>':'<i class="fa fa-circle text-info"></i>'!!}

                                     {{$kb->mandat}}</td>
                                     <td>
                                       <p><b>TIDAK TERDAPAT DATA UNTUK DI NILAI</b></p>
                                     </td>
                                     <td>
                                      

                                          <button class="btn btn-info btn-xs" onclick="plus_perda.build('#plus-perda',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perda',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perda',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perda,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERDA
                                          </button>
                                      </td>
                                      <td>
                                        <script type="text/javascript">
                                         var perkada_{{$kb->id}}=<?php echo json_encode($kb); ?>;
                                       </script>
                                            <button class="btn btn-info btn-xs" onclick="plus_perkada.build('#plus-perkada',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perkada',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perkada',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perkada,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERKADA
                                          </button>
                                      </td>
                                     <td>
                                            <button class="btn btn-info btn-xs" onclick="plus_lainnya.build('#plus-lainnya',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.lainnya',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.lainnya',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.lainnya,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> LAINNYA
                                          </button>
                                      </td>
                                     


        
                                </tr>
                                <?php $id_sub_urusan=$kb->id; ?>
                            @endif
                            @endif
                        @endforeach
                    </tbody>
                     <thead class="bg-navy">
                        <tr>
                            <th>SUB URUSAN</th>
                            <th style="min-width: 200px;">REGULASI</th>
                            <th style="min-width: 150px;">KESESUAIAN</th>
                            <th style="min-width: 200px;">PERDA</th>
                            <th style="min-width: 200px;">PERKADA</th>
                            <th style="min-width: 200px;">LAINNYA</th>
                        </tr>
                    </thead>
                </table>
				
			</div>
		</div>
	</div>
</div>
                {{$datas->links()}}




@stop

@section('js')

@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perda'])
@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perkada'])
@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'lainnya'])
@include('form.kebijakan.daerah.partials.vue_modal_update_kesesuaian')



@stop