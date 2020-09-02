@extends('adminlte::page')


@section('content_header')
   <div class="row">
      <div class="col-md-8">
        <h3>PROGRAM KEGIATAN PEMERINTAH DAERAH </h3>
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
                      <th>PROVINSI</th>
                      <th>NAMA PEMDA</th>
                      <th>DATA RKPD</th>

                  </tr>
                      </thead>
                      <tbody>
					  
                          @foreach($data as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td>{{$d->provinsi}}</td>
                                <td>{{$d->nama}}</td>
                                <td>
								 @if($d->jumlah_kegiatan)
                                        <a href="{{route('prokeg.detail',['kodepemda'=>$d->id,'namapemda'=>$d->nama])}}" class="btn btn-success btn-xs">DETAIL RKPD {{Hp::fokus_tahun()}}</a>

                                    @else
                                   <a href="{{route('prokeg.detail',['kodepemda'=>$d->id,'namapemda'=>$d->nama])}}" class="btn btn-warning btn-xs">DETAIL RKPD {{Hp::fokus_tahun()}}</a>

                                    @endif                                    </td>
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
             pageLength: 15
        });

    </script>
@stop