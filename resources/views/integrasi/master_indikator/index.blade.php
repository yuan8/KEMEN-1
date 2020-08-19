@extends('adminlte::page')

@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">INDIKATOR TAHUN {{Hp::fokus_tahun()}}</h3>

    	</div>
    	<div class="col-md-4">
    		<br>
    		<div class="btn-group pull-right">
    			<button class="full-w btn btn-xs btn-success" onclick="showFromCreateIndikator()">TAMBAH INDIKATOR</button>

    		</div>
    	</div>

    </div>
@stop


@section('content')

    <form action="{{url()->full()}}" method="get">
        <div class="row no-gutter">
            <div class="col-md-4">
                <label>Sub Urusan</label>
            <select class="form-control init-use-select2 " style="max-width: 40%!important"  name="s">
                <option value="">-</option>
                <option value="null" {{(isset($_GET['s'])?($_GET['s']=='null'?'selected':''):'')}} class="text-uppercase">TIDAK MEMILIKI SUB URUSAN</option>


                @foreach($sub_urusan as $s)
                    <option value="{{$s->id}}" {{(isset($_GET['s'])?($_GET['s']==$s->id?'selected':''):'')}}>{{$s->nama}}</option>
                @endforeach

            </select>
        </div>
            <div class="col-md-3">
                <label>JENIS</label>


             <select class="form-control init-use-select2 col-md-4" name="t">
                <option value="">-</option>
               @php
               for($i=1; $i <5 ; $i++) {
                    echo "<option value='".$i."' ".(isset($_GET['t'])?($_GET['t']==$i?'selected':''):'')." >".Hp::tag_ind($i)."</option>";
               }
               @endphp

            </select>

            </div>
            <div class="col-md-4">
                <label>Indikator Search</label>

            <input type="text" name="q" class="form-control col-md-4" placeholder="Search.." value="{{isset($_GET['q'])?$_GET['q']:''}}">
        </div>
        <div class="col-md-1">
            <label>Action</label>
            <button type="submit" class="btn btn-info col-md-12"><i class="fa fa-search"></i></button>
        </div>

        </div>
    </form>

<hr>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
    <table class="table table-condesed table-bordered bg-white">
        <thead class="bg-navy">
            <tr>
                <th rowspan="2">ACTION</th>
                <th rowspan="2">SUB URUSAN</th>

                <th rowspan="2">JENIS</th>
                <th rowspan="2">KODE</th>
                <th rowspan="2">INDIKATOR</th>
                <th rowspan="2">TARGET</th>
                <th rowspan="2">SATUAN</th>
                <th colspan="3">KEWENANGAN</th>
                <th rowspan="2">LOKUS</th>
                <th rowspan="2">PELAKSANA</th>

            </tr>
            <tr>
                <th>PUSAT</th>
                <th>PROVINSI</th>
                <th>KOTA/KAB</th>


            </tr>
        </thead>

        <tbody>
            @foreach($data as $d)
                <tr>

                    <td>
                           <div class="form-group pull-right">
                                <button class="btn btn-info btn-xs" onclick="showFormDetailIndikator({{$d['id']}})"><i class="fa fa-eye"></i></button>
                                 <button class="btn btn-warning btn-xs" onclick="showFormUpdateIndikator({{$d['id']}})"><i class="fa fa-pen"></i></button>
                                <button class="btn btn-danger btn-xs" onclick="showFormDeleteIndikator({{$d['id']}})"><i class="fa fa-trash"></i></button>
                            </div>

                    </td>
                    <td>{{$d['_sub_urusan']?$d['_sub_urusan']['nama']:'-'}}</td>


                    <td>{{$d->_sumber()}}</td>

                    <td>{{$d->kode}}</td>

                    <td>{{$d->uraian}}</td>
                    <td>
                        @if(($d['tipe_value']==1)OR($d['tipe_value']==2))
                            {{number_format($d['target'],2)}}
                            @else
                                {{$d['target']}}

                            @endif

                            @if($d['tipe_value']==2)
                                <-> {{number_format($d['target_1'],2)}}

                            @endif
                    </td>
                    <td>
                        {{$d->satuan}}
                    </td>
                    <td class="{{$d['kw_nas']?'':'bg-danger'}}" >
                        {!!$d['kw_nas']?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i> '!!}
                    </td>
                    <td class="{{$d['kw_p']?'':'bg-danger'}}" >
                        {!!$d['kw_p']?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i> '!!}
                    </td>
                    <td class="{{$d['kw_k']?'':'bg-danger'}}" >
                           {!!$d['kw_k']?'<i class="fa fa-check text-success"></i>':'<i class="fa fa-times text-danger"></i> '!!}
                    </td>
                    <td>
                        {!!nl2br($d->lokus?$d->lokus:'-')!!}
                    </td>
                    <td>
                        @php
                            $i=$d;
                            $i['pelaksana_nas']=json_decode($i['pelaksana_nas']);
                            $i['pelaksana_p']=json_decode($i['pelaksana_p']);
                            $i['pelaksana_k']=json_decode($i['pelaksana_k']);
                        @endphp
                        @if($i['kw_nas'])
                             <b>PUSAT</b>
                            <ul>
                            @foreach($i['pelaksana_nas'] as $p)
                                <li>{{$p}}</li>
                            @endforeach
                            </ul>
                        @endif
                         @if($i['kw_p'])
                             <b>PROVINSI</b>
                            <ul>
                            @foreach($i['pelaksana_p'] as $p)
                                <li>{{$p}}</li>
                            @endforeach
                            </ul>
                        @endif
                         @if($i['kw_k'])
                             <b>KOTA/KAB</b>
                            <ul>
                            @foreach($i['pelaksana_k'] as $p)
                                <li>{{$p}}</li>
                            @endforeach
                            </ul>
                        @endif

                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
</div>
{{$data->links()}}
    </div>
</div>

@stop

@section('js')
<script type="text/javascript">
    function showFromCreateIndikator(){
        API_CON.get("{{route('int.m.indikator.create')}}").then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }

      function showFormDeleteIndikator(id){

        API_CON.get("{{route('int.m.indikator.form_delete',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('HAPUS INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }


    function showFormDetailIndikator(id){

        API_CON.get("{{route('int.kb5tahun.indikator.detail',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('DETAIL INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }

     function showFormUpdateIndikator(id){
        API_CON.get("{{route('int.m.indikator.form_edit',['id'=>null])}}/"+id,).then(function(res){
            $('#modal-global-lg .modal-header .modal-title').html('UPDATE INDIKATOR {{Hp::fokus_tahun()}}');
            $('#modal-global-lg .modal-body').html(res.data);
            $('#modal-global-lg').modal();
        });
    }
</script>
@stop
