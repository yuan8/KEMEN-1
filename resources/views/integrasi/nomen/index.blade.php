@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">NOMENKLATUR {{$pro}} TAHUN {{Hp::fokus_tahun()}}</h3>
    	
    	</div>
    	
    	
    </div>
@stop


@section('content')
<div class="box-group">
    <button class="btn btn-primary">TAMBAH URUSAN</button>
</div>
<div class="box box-solid">
    <div class="box-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        KODE
                    </th>
                    <th>
                        PROGRAM
                    </th>
                    <th>
                        KEGIATAN
                    </th>
                    <th>
                        SUB KEGIATAN
                    </th>
                </tr>
            </thead>
            <tbody >
                @foreach($data as $p)
                <tr>
                    <td>{{$p['kode']}}</td>
                    <td>{{$p['nomenklatur']}}</td>
                </tr>
                    @foreach($p['_child_kegiatan'] as $k)
                   <tr>
                        <td>{{$k['kode']}}</td>
                        <td colspan="1"></td>

                    <td>{{$k['nomenklatur']}}</td>
                   </tr>
                        @foreach($k['_child_sub_kegiatan'] as $s)
                       <tr>
                            <td>{{$s['kode']}}</td>
                        <td colspan="2"></td>
                        <td>{{$s['nomenklatur']}}</td>
                       </tr>

                
                     @endforeach
                
                     @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop