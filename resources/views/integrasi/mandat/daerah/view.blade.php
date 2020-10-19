@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN <span class="text-success">{{$daerah->nama}}</span> </h3>
    	</div>
    	<div class="col-md-4 modal-footer">
    		
    	</div>
    </div>
@stop

@section('content')
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-navy"><i class="fa fa-file"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">REGULASI BELUM TERINTEGRASI</span>
        <span class="info-box-number">{{number_format($rekap['regulasi_belum_terintegrasi'])}} / {{number_format($rekap['regulasi'])}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-file"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">REGULASI BELUM DINILAI</span>
        <span class="info-box-number">{{number_format($rekap['regulasi_belum_dinilai'])}} / {{number_format($rekap['regulasi'])}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  
  
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-file"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">REGULASI SESUAI</span>
        <span class="info-box-number">{{number_format($rekap['regulasi_sesuai'])}} / {{number_format($rekap['regulasi'])}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-file"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">REGULASI TIDAK SESUAI</span>
        <span class="info-box-number">{{number_format($rekap['regulasi_tidak_seusai'])}} / {{number_format($rekap['regulasi'])}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
 

	<div class="col-md-12">
   <div class="btn-group" style="margin-bottom: 10px;">
      <a href="" class="btn btn-success btn-sm" style="margin-bottom: 10px;">DOWNLOAD DATA</a>
    <a href="{{route('kebijakan.daerah.desk_daerah',['kode_daerah'=>$daerah->id])}}" class="btn btn-primary btn-sm" style="margin-bottom: 10px;">
      <i class="fa fa-desktop"></i>
    DESK </a>
   </div>

		<div class="box box-success">
			<div class="box-body table-responsive">

                <table class="table table-bordered ">

                    <tbody>
                        <?php
                            $id_sub_urusan=0;
                            $id_mandat=0;

                         ?>
                        @foreach($datas as $kb)
                        @php
                        @endphp
                          <script type="text/javascript">
                            var mandat_{{$kb->id_mandat}}=<?php echo json_encode($kb); ?>;
                          </script>
                            @if(($id_sub_urusan!=$kb->id)&&(!empty($kb->id)))
                                <tr class="bg bg-warning">
                                    <td  colspan="6"><h5><b>{{$kb->nama}}</b></h5></td>

                                </tr>
                                <?php $id_sub_urusan=$kb->id; ?>
                            @endif
                             @if(($id_mandat!=$kb->id_mandat)&&(!empty($kb->id_mandat)))
                             
                              @if((!empty($kb->id_integrasi)))
                                  <tr class="{{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'':'bg-warning') }}">
                                      <td rowspan="2" style="width: 300px;">
                                         @if(!empty($kb->uu))
                                         <p><b>UNDANG-UNDANG</b></p>
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->uu); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{!!nl2br($uu[1])!!}</li>
                                            @endforeach


                                           </ul>

                                          @endif
                                            @if(!empty($kb->pp))
                                         <p><b>PERATURAN PEMERINTAH</b></p>
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->pp); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{!!nl2br($uu[1])!!}</li>
                                            @endforeach


                                           </ul>

                                          @endif
                                            @if(!empty($kb->perpres))
                                           <p><b>PERATURAN PRESIDEN</b></p>
                                             <ul>
                                              <?php $duu=explode('|@|',$kb->perpres); ?>
                                              @foreach($duu as $uu)
                                              <?php $uu=explode('(@)', $uu) ?>

                                              <li>{!!nl2br($uu[1])!!}</li>
                                              @endforeach


                                           </ul>

                                          @endif
                                            @if(!empty($kb->permen))
                                           <p><b>PERATURAN MENTRI</b></p>
                                             <ul>
                                              <?php $duu=explode('|@|',$kb->permen); ?>
                                              @foreach($duu as $uu)
                                              <?php $uu=explode('(@)', $uu) ?>

                                              <li>{!!nl2br($uu[1])!!}</li>
                                              @endforeach


                                           </ul>

                                          @endif
                                      </td>
                                      <td rowspan="2" style="width: 250px;">
                                         


                                       {!!nl2br($kb->mandat)!!}</td>

                                      <td class="bg " style="width:250px; height: 50px;" >
                                          <button onclick="update_kesesuian.build(mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.update.kesesuian',['id'=>$kb->id_integrasi])}}',{{$kb->id_integrasi}},{{$kb->kesesuaian}},mandat_{{$kb->id_mandat}}.note)" class="btn btn-xs {{$kb->kesesuaian==0?'btn-danger':(($kb->kesesuaian==1)?'btn-success':'btn-warning') }}">
                                             <i class="fa fa-pen"></i> PENILAIAN

                                          </button>
                                          <h5><b> {{$kb->kesesuaian==0?'BELUM DINILAI':(($kb->kesesuaian==1)?'SESUAI':'TIDAK SESUAI') }}</b></h5>

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
                                  <tr class="{{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'bg-':'bg-warning') }}">
                                      <td colspan="1">
                                         <p><b>NOTE:</b></p>
                                          <p>
                                             @if(!empty($kb->note))
                                            {!!nl2br($kb->note)!!}
                                            @endif
                                          </p>
                                      </td>
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

                              @else
                                <tr>

                                       <td style="width: 300px;">
                                         @if(!empty($kb->uu))
                                         <p><b>UNDANG-UNDANG</b></p>
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->uu); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{!!nl2br($uu[1])!!}</li>
                                            @endforeach


                                           </ul>

                                          @endif
                                            @if(!empty($kb->pp))
                                         <p><b>PERATURAN PEMERINTAH</b></p>
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->pp); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{!!nl2br($uu[1])!!}</li>
                                            @endforeach


                                           </ul>

                                          @endif
                                            @if(!empty($kb->perpres))
                                           <p><b>PERATURAN MENTRI</b></p>
                                             <ul>
                                              <?php $duu=explode('|@|',$kb->perpres); ?>
                                              @foreach($duu as $uu)
                                              <?php $uu=explode('(@)', $uu) ?>

                                              <li>{!!nl2br($uu[1])!!}</li>
                                              @endforeach


                                           </ul>

                                          @endif
                                            @if(!empty($kb->permen))
                                           <p><b>PERATURAN MENTRI</b></p>
                                             <ul>
                                              <?php $duu=explode('|@|',$kb->permen); ?>
                                              @foreach($duu as $uu)
                                              <?php $uu=explode('(@)', $uu) ?>

                                              <li>{!!nl2br($uu[1])!!}</li>
                                              @endforeach


                                           </ul>

                                          @endif
                                      </td>
                                      <td  style="width: 250px;">
                                         


                                       {!!nl2br($kb->mandat)!!}</td>

                                      <td></td>
                                     
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
                             <tr>
                                <td colspan="7" style="background: #ddd"></td>
                              </tr>

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




@stop

@section('js')

@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perda'])
@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perkada'])
@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'lainnya'])
@include('form.kebijakan.daerah.partials.vue_modal_update_kesesuaian')



@stop
