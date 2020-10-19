@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN TAHUNAN </h3>
    		
    	</div>
    	
    	
    </div>
@stop


@section('content')
<div class="row">
    <div class="col-md-12">
            <div class="box box-warning">
                
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td></td>
                                <th>PN</th>
                                <th></th>
                                <th>PP</th>
                                <th></th>
                                <th>KP</th>
                                <th>ANGGARAN</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="bg bg-warning" >
                                    <button class="btn btn-xs btn-warning" onclick="plus_PN.build('TAMBAH PN','','{{route('kebijakan.pusat.tahunan.store.pn')}}','{{route('api.kebijakan.tahunan.get.pn')}}')">
                                        <i class="fa fa-plus"></i> Tambah PN
                                    </button>
                                </td>

                                <?php

                                $pn_id=0;
                                $pp_id=0;
                                $kp_id=0;
                                $target_id=0;

                                ?>
                                @foreach($data as $d)
                                    @if(($pn_id!=$d->pn_id )&&(!empty($d->pn_id)) )
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{$d->pn_uraian}}
                                        </td>
                                        <td colspan="4">
                                             <button class="btn btn-xs btn-warning" onclick="plus_PP.build('TAMBAH PP','{{$d->pn_uraian}}','{{route('kebijakan.pusat.tahunan.store.pp',['id'=>$d->pn_id])}}','{{route('api.kebijakan.tahunan.get.pp')}}')">
                                                <i class="fa fa-plus"></i> Tambah PP
                                            </button>

                                        </td>
                                        <td>
                                            Rp. {{number_format($d->pn_anggaran,0,',',' ')}}
                                        </td>
                                        <td colspan="1"></td>
                                    </tr>
                                    <?php
                                        $pn_id=$d->pn_id;

                                     ?>
                                     @endif

                                     @if(($pp_id!=$d->pp_id )&&(!empty($d->pp_id)) )
                                    <tr>
                                        <td colspan="2"></td>
                                        <td></td>
                                        <td>
                                            {{$d->pp_uraian}}
                                        </td>
                                        <td colspan="2">
                                             <button class="btn btn-xs btn-warning" onclick="plus_PP.build('TAMBAH KP','{{$d->pp_uraian}}','{{route('kebijakan.pusat.tahunan.store.kp',['id'=>$d->pn_id,'id_pp'=>$d->pp_id])}}','{{route('api.kebijakan.tahunan.get.kp')}}')">
                                                <i class="fa fa-plus"></i> Tambah KP
                                            </button>

                                        </td>
                                        <td>
                                            Rp. {{number_format($d->pp_anggaran,0,',',' ')}}
                                        </td>
                                        <td colspan="1"></td>

                                    </tr>
                                    <?php
                                        $pp_id=$d->pp_id;

                                     ?>
                                     @endif
                                    @if(($kp_id!=$d->kp_id )&&(!empty($d->kp_id)) )
                                    <tr>
                                        <td colspan="4"></td>
                                        <td></td>
                                        <td>
                                            {{$d->kp_uraian}}
                                        </td>
                                       
                                        <td>
                                            Rp. {{number_format($d->kp_anggaran,0,',',' ')}}
                                        </td>
                                      
                                    </tr>
                                    <?php
                                        $kp_id=$d->kp_id;

                                     ?>
                                     @endif
                                     

                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

@stop

@section('js')

@include('form.kebijakan-tahunan.partials.vue_modal_tambah',['tag'=>'PN'])
@include('form.kebijakan-tahunan.partials.vue_modal_tambah',['tag'=>'PP'])
@include('form.kebijakan-tahunan.partials.vue_modal_tambah',['tag'=>'KP'])



@stop