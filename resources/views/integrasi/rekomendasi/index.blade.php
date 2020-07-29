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
                   <table class="table table-borded" id="table-daerah">
              <thead>
                  <tr class="bg bg-navy">
                      <th>KODEPEMDA</th>
                      <th></th>
                      <th>NAMA PEMDA</th>
                      <th>ACTION</th>

                  </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td></td>
                                <td>{{$d->nama}}</td>
                                <td>
                                  <a href="{{route('int.rekomendasi.detail',['kodepemda'=>$d->id])}}" class="btn btn-info btn-xs ">BUAT REKOMENDASI {{HP::fokus_tahun()}}</a>
                                </td>
                               
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
             pageLength: 15,
             sort:false
        });

    </script>
@stop