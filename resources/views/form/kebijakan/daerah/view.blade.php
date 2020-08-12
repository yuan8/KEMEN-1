@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN <span class="text-success">{{$daerah->nama}}</span> </h3>
    	</div>
    	<div class="col-md-4 modal-footer">
    		<a href="" class="btn btn-success">Tambah</a>
    	</div>

    </div>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SUB URUSAN</th>
                            <th>MANDAT / KEGIATAN</th>
                            <th>KESESUAIAN</th>
                            <th>PERDA</th>
                            <th>PERKADA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $id_sub_urusan=0;
                            $id_mandat=0;

                         ?>
                        @foreach($datas as $kb)

                            @if(($id_sub_urusan!=$kb->id)&&(!empty($kb->id)))
                                <tr>
                                    <td>{{$kb->nama}}</td>
                                    <td colspan="4" class="bg bg-warning"></td>

                                </tr>
                                <?php $id_sub_urusan=$kb->id; ?>
                            @endif
                             @if(($id_mandat!=$kb->id_mandat)&&(!empty($kb->id_mandat)))
                                <tr>
                                    <td></td>
                                    <td>{!!$kb->tipe?'<i class="fa fa-circle text-warning"></i>':'<i class="fa fa-circle text-info"></i>'!!} {{$kb->mandat}}</td>
                                    <td colspan=""></td>
                                    <td>
                                          <script type="text/javascript">
                                            var data_{{$kb->id_mandat}}=<?php echo json_encode($kb); ?>;
                                        </script>
                                        <button class="btn btn-info btn-xs" onclick="plus_perda.build('#plus-perda','{{$kb->mandat}}','{{route('kebijakan.daerah.store.mandat.perda',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perda',['id'=>$kb->id_mandat])}}',(data_{{$kb->id_mandat}}.perda?data_{{$kb->id_mandat}}.perda:''),'{{$kode_daerah}}')">

                                            <i class="fa fa-edit"></i> PERDA
                                        </button>
                                    </td>
                                    <td>

                                          <button class="btn btn-info btn-xs" onclick="plus_perkada.build('#plus-perkada','{{$kb->mandat}}','{{route('kebijakan.daerah.store.mandat.perkada',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perkada',['id'=>$kb->id_mandat])}}',(data_{{$kb->id_mandat}}.perkada?data_{{$kb->id_mandat}}.perkada:''),'{{$kode_daerah}}')">
                                            <i class="fa fa-edit"></i> PERKADA
                                        </button>
                                    </td>


                                </tr>
                                <?php $id_sub_urusan=$kb->id; ?>
                            @endif
                            @if((!empty($kb->id_integrasi)))
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="bg {{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'bg-success':'bg-warning') }}" colspan="3">
                                        <button onclick="update_kesesuian.build('{{$kb->mandat}}','{{route('kebijakan.daerah.store.mandat.update.kesesuian',['id'=>$kb->id_integrasi])}}',{{$kb->id_integrasi}},{{$kb->kesesuaian}},'{{$kb->note}}')" class="btn btn-xs {{$kb->kesesuaian==0?'btn-danger':(($kb->kesesuaian==1)?'btn-success':'btn-warning') }}">
                                            {{$kb->kesesuaian==0?'Belum Dinilai':(($kb->kesesuaian==1)?'Sesuai':'Tidak Sesuai') }}

                                        </button>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>
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
                                </tr>

                               @if(!empty($kb->note))
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="3">
                                        <div>Note:</div>
                                        <div>{!!nl2br($kb->note)!!}</div>
                                    </td>
                                </tr>

                               @endif

                            @endif
                        @endforeach
                    </tbody>
                </table>

			</div>
		</div>
	</div>
</div>



@stop

@section('js')

@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perda'])
@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perkada'])
@include('form.kebijakan.daerah.partials.vue_modal_update_kesesuaian')



@stop
