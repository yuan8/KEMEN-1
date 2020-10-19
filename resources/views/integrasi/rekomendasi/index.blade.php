@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>INTEGRASI PROGRAM KEGIATAN </h3>
      </div>

    </div>
@stop

@section('content')
  <div class="row">
      <div class="col-md-12">
        <div class="box box-solid box-info-gradient">
            <div class="box-body">
                   <table class="table table-bordered" id="table-daerah">
              <thead>
                  <tr class="bg bg-navy">
                      <th>KODEPEMDA</th>
                      <th>NAMA PEMDA</th>
                      <th>NAMA PROVINSI</th>
                      <th>STATUS</th>
                      <th>ACTION</th>

                  </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $d)
                            @php
                              $d['_has_rekom']=$d['_has_rekomendasi'];
                            @endphp
                            <tr class="{{$d['_rekomendasi_final']?'bg-primary':($d['_has_rekom']?'bg-warning':'')}}">
                                <td>{{$d->id}}</td>
                                <td>{{$d->nama}}</td>
                                <td>{{isset($d['_provinsi'])?$d['_provinsi']['nama']:''}}</td>
                                <td>
                                  {{$d['_rekomendasi_final']?'FINAL':($d['_has_rekom']?'TERDAPAT DATA':'BELUM TERDAPAT DATA')}}
                                </td>
                                <td>
                                  @if($d['_rekomendasi_final'])
                                    <a href="{{route('int.rekomendasi.detail',['kodepemda'=>$d->id])}}" class="btn btn-primary btn-xs "> VIEW REKOMENDASI {{HP::fokus_tahun()+1}}</a>
                                    </td>
                                  @else
                                  <a href="{{route('int.rekomendasi.detail',['kodepemda'=>$d->id])}}" class="btn {{$d['_has_rekom']?'btn-warning':'btn-info'}} btn-xs ">{{$d['_has_rekomendasi']?'EDIT':'BUAT'}} REKOMENDASI {{HP::fokus_tahun()+1}}</a>
                                  </td>

                                  @endif

                            </tr>


                          @endforeach
                      </tbody>
                  </table>
            </div>
        </div>
      </div>
  </div>
@stop

@section('js')
    <script type="text/javascript">
        $('#table-daerah').DataTable({
          "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],
          
             sort:false
        });

    </script>
@stop
