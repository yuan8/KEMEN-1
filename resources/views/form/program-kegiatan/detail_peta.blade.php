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
            {{$data->links()}}
           
            <div class="box box-warning">
                <div class="box-header with-border">
                    <div class="input-group col-md-12">
                        <form action="{{route('pk.peta.detail',['id'=>$daerah->id])}}" method="get">
                            <input type="" class="form-control" name="q" placeholder="Search..." value="{{isset($_GET['q'])?$_GET['q']:''}}">
                        </form>
                    </div>
                </div>
               <form  action="{{route('pk.peta.store',['id'=>$daerah->id])}}" method="post">
                   @csrf
                    <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>PEMETAAN</th>
                                <th>PROGRAM</th>
                                <th>KODE KEGIATAN</th>
                                <th>KEGIATAN</th>
                               
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
                                    <td></td>
                                    <td>{{$d->uraian_program}}</td>
                                    <td colspan="5"></td>
                                </tr>
                                <?php $idp=$d->id_program; ?>

                                @endif
                                @if($idk!=$d->id_kegiatan)
                                <tr class="bg {{$d->id_sub_urusan?'bg-success':($d->id_urusan?'bg-warning':'bg-danger')}}">
                                    <td>
                                        @if(empty($d->id_sub_urusan))
                                        <h5><b>{{$d->uraian_urusan}}</b></h5>

                                        <select class="form-control select-box" name="sub[{{$d->id_kegiatan}}]">
                                            <option value="">--SUB URUSAN--</option>
                                            @foreach($sub as $s)
                                                <option value="{{$s->id}}">{{$s->nama}}</option>
                                            @endforeach
                                        </select>

                                        @else
                                        <h5><b>{{$d->uraian_urusan}}</b></h5>
                                        <p>{{$d->uraian_sub_urusan}}</p>
                                        @endif
                                    </td>
                                    <td colspan="1"></td>
                                    <td>{{$d->nomenklatur_kegiatan}}</td>
                                    <td colspan="5">{{$d->uraian_kegiatan}}</td>
                                </tr>
                                <?php $idk=$d->id_kegiatan; ?>

                                @endif


                            @endforeach
                        </tbody>
                    </table>
                </div>
                     <div class="box-footer modal-footer">
                        <button type="submit" class="btn btn-warning">UPDATE DATA PAGE {{isset($_GET['page'])?$_GET['page']:1}}</button>
                    </div>
               </form>
            </div>
            {{$data->links()}}
        </div>
    </div>

@stop

@section('js')
<script type="text/javascript">
    $('.select-box').on('change',function(){
        if((this.value!=null) && (this.value!='')){
            $(this).parent().parent().css('background','#f5a11c');
            // $(this).css('background','#f5a11c');

        }else{
              $(this).parent().parent().removeAttr('style');
              // $(this).removeAttr('style');

            // $(this).css('background','#fff');
            // $(this).css('color','#555');


        }
    });

</script>

@stop