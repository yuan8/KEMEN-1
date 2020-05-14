@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PROGRAM KEGIATAN {{$daerah->nama}} ({{(int)Hp::fokus_tahun() - 1}}) </h3>
    		
    	</div>
    
    	
    </div>
@stop


@section('content')

    <div class="row">
        <div class="col-md-12">
            <a href="{{route('pk.peta.detail',['id'=>$daerah->id])}}" class="btn btn-warning btn-xs " style="margin-bottom: 10px;">PEMETAAN PROGRAM KEGIATAN PADA SUB URUSAN</a>
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="input-group col-md-12">
                        <form action="{{route('pk.detail',['id'=>$daerah->id])}}" method="get">
                            <input type="" class="form-control" name="q" placeholder="Search..." value="{{isset($_GET['q'])?$_GET['q']:''}}">
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="nomen_daerah">
                        <thead>
                            <tr>
                                <th>PROGRAM</th>
                                <th>KODE KEGIATAN</th>
                                <th>KEGIATAN</th>
                                <th>ANGGARAN</th>
                                <th>INDIKATOR</th>
                                <th>TARGET</th>
                                <th>SATUAN</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $idp=0;
                                $idk=0;
                                $id_indp=0;
                                $id_indk=0;
                             ?>
                            @foreach($data as $d)
                                @if($idp!=$d->id_program)
                                <tr>
                                    <td>{{$d->uraian_program}} <br> <small><b><i>{{$d->uraian_sub_urusan}}</i></b></small></td>
                                    <td colspan="6"></td>
                                </tr>
                                <?php $idp=$d->id_program; ?>

                                @endif
                                @if($id_indp!=$d->id_ind_p)
                                <tr>
                                    <td colspan="4"></td>
                                    <td><b>(IP)</b> {{$d->ind_p}}</td>
                                    <td colspan="">{{$d->ind_p_target}}</td>
                                    <td>{{$d->ind_p_satuan}}</td>
                                </tr>
                                <?php $id_indp=$d->id_ind_p; ?>

                                @endif
                                 @if($idk!=$d->id_kegiatan)
                                <tr>
                                    <td colspan=""></td>
                                    <td>
                                        <h5><b>{{$d->uraian_sub_urusan}}</b></h5>
                                        {{$d->nomenklatur_kegiatan}}
                                    </td>
                                    <td colspan="">
                                        
                                        {{$d->uraian_kegiatan}}
                                    </td>
                                    <td colspan="">Rp. {{number_format($d->anggran_kegiatan,0,',','.')}}</td>
                                    <td colspan="3"></td>
                                </tr>
                                <?php $idk=$d->id_kegiatan; ?>

                                @endif
                                 @if($id_indk!=$d->id_ind_k)
                                <tr>
                                    <td colspan="4"></td>
                                    <td><b>(IK)</b> {{$d->ind_k}}</td>
                                    <td colspan="">{{$d->ind_k_target}}</td>
                                    <td>{{$d->ind_k_satuan}}</td>
                                </tr>
                                <?php $id_indk=$d->id_ind_k; ?>

                                @endif


                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>

@stop


@section('js')

<script type="text/javascript">
    var idp=0;
    var idk=0;
    var indk=0;
    var indp=0;

    // var data_list_for_add=$('#nomen_daerah').DataTable({
    //             'sort':false,
    //             'columns':[
    //                 {
    //                     data:'uraian_program',
    //                     type:'string',
    //                     render:function(data,type,row,meta){
    //                         if(idp==row.id_program){
    //                             return '';
    //                         }else{

    //                             idp=row.id_program;
    //                             return row.uraian_program;
    //                         }
    //                     },
                       
                       

    //                 },
    //                 {
    //                     data:'nomenklatur_kegiatan',
    //                     type:'string',
    //                      render:function(data,type,row,meta){
    //                         if(idk==row.id_kegiatan){
    //                             return '';
    //                         }else{
    //                             return row.nomenklatur_kegiatan;
    //                         }
    //                     },

    //                 },{

    //                     data:'uraian_kegiatan',
    //                     type:'string',
    //                     render:function(data,type,row,meta){
    //                         if(idk==row.id_kegiatan){
    //                             return '';
    //                         }else{
    //                             return row.uraian_kegiatan;
    //                         }
    //                     },


    //                 },
    //                 {

    //                     data:'anggran_kegiatan',
    //                     type:'string',
    //                     render:function(data,type,row,meta){
    //                         if(idk==row.id_kegiatan){
    //                             return '';
    //                         }else{
    //                             ind=row.id_kegiatan;
    //                             return row.anggran_kegiatan;
    //                         }
    //                     },
                        

    //                 },
    //                 {

    //                     data:'in',
    //                     type:'string',
    //                     render:function(data,type,row,meta){
    //                         if(idk==row.id_kegiatan){
    //                             return '';
    //                         }else{
    //                             ind=row.id_kegiatan;
    //                             return row.anggran_kegiatan;
    //                         }
    //                     },
                        

    //                 }
                    
    //             ],
    //             autoWidth:false,
    //              "lengthMenu": [[20, 30], [30,30]],
             
    //             data:[]
    // });

   
    // data_list_for_add.draw();

</script>

@stop