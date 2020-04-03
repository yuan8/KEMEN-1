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
                                <th>KP</th>
                                <th></th>
                                <th>PROPN</th>
                                <th></th>
                                <th>PROYEK</th>
                                <th>ANGGARAN  </th>
                                <th></th>
                                <th>TARGET ({{Hp::fokus_tahun()}})</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              
                                <?php

                                $kp_id=0;
                                $pro_id=0;
                                $psn_id=0;
                                $target_id=0;

                                ?>
                                @foreach($data as $d)
                                    @if(($kp_id!=$d->kp_id )&&(!empty($d->kp_id)) )
                                    <tr>
                                        <td>
                                            {{$d->kp_uraian}}
                                        </td>
                                        <td colspan="4">
                                             <button class="btn btn-xs btn-warning" onclick="plus_PROPN.build('TAMBAH PROPN','{{$d->kp_uraian}}','{{route('kebijakan.pusat.tahunan.store.propn',['id'=>$d->kp_id])}}')">
                                                <i class="fa fa-plus"></i> Tambah PROPN
                                            </button>

                                        </td>
                                        <td>
                                            Rp. {{number_format($d->kp_anggaran,0,',',' ')}}
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <?php
                                        $kp_id=$d->kp_id;

                                     ?>
                                     @endif

                                     @if(($pro_id!=$d->pro_id )&&(!empty($d->pro_id)) )
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                            {{$d->pro_uraian}}
                                        </td>
                                        <td colspan="2">
                                             <button class="btn btn-xs btn-warning" onclick="plus_PSN.build('TAMBAH PSN','{{$d->pro_uraian}}','{{route('kebijakan.pusat.tahunan.store.psn',['id'=>$d->pro_id])}}')">
                                                <i class="fa fa-plus"></i> Tambah Proyek
                                            </button>

                                        </td>
                                        <td>
                                            Rp. {{number_format($d->pro_anggaran,0,',',' ')}}
                                        </td>
                                        <td colspan="2"></td>

                                    </tr>
                                    <?php
                                        $pro_id=$d->pro_id;

                                     ?>
                                     @endif
                                    @if(($psn_id!=$d->psn_id )&&(!empty($d->psn_id)) )
                                    <tr>
                                        <td colspan="3"></td>
                                        <td></td>
                                        <td>
                                            {{$d->psn_uraian}}
                                        </td>
                                       
                                        <td>
                                            Rp. {{number_format($d->psn_anggaran,0,',',' ')}}
                                        </td>
                                         <td colspan="2">
                                            <button class="btn btn-xs btn-warning" onclick="plus_TARGET.build('TAMBAH TARGET','{{$d->psn_uraian}}','{{route('kebijakan.pusat.tahunan.store.target.proyek',['id'=>$d->psn_id])}}',false)">
                                                <i class="fa fa-plus"></i> Tambah Target
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                        $psn_id=$d->psn_id;
                                     ?>
                                     @endif
                                      @if(($target_id!=$d->target_id )&&(!empty($d->target_id)) )
                                    <tr>
                                        <td colspan="6"></td>
                                        <td></td>
                                        <td>
                                            {{$d->target_uraian}}
                                        </td>
                                    </tr>
                                    <?php
                                        $target_id=$d->target_id;
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

@include('form.kebijakan-tahunan.partials.vue_modal_tambah_proyek',['tag'=>'PROPN'])
@include('form.kebijakan-tahunan.partials.vue_modal_tambah_proyek',['tag'=>'PSN'])
@include('form.kebijakan-tahunan.partials.vue_modal_tambah_proyek',['tag'=>'TARGET'])



@stop