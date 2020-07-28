@extends('adminlte::page')


@section('content_header')
 <div class="row">
      <div class="col-md-8">
        <h3>{{ $daerah->nama}} {{Hp::fokus_tahun()}} </h3>
      </div>
      
    </div>
@stop

@section('content')
  <div class="row">
      <div class="col-md-12">
        <div class="box box-solid box-info-gradient">
            <div class="box-body">
              <table class="table table-bordered" id="table-daerah">
                <thead class="bg bg-navy">
                    <tr class="">
                        <th rowspan="3">KODE PROGRAM</th>
                        <th rowspan="3">PROGRAM</th>
                        <th rowspan="3">KODE KEGIATAN</th>
                        <th rowspan="3">KEGIATAN</th>
                        <th colspan="6">INDIKATOR</th>
                        <th rowspan="3">ACTION</th>

                    </tr>
                    <tr>
                      <th rowspan="2">KODE</th>
                      <th rowspan="2">URAI INDIKATOR</th>
                      <th colspan="2">TARGET {{Hp::fokus_tahun()}}</th>
                      <th colspan="2">TARGET {{Hp::get_tahun_rpjmn()['finish']}}</th>
                    </tr>
                    <tr>
                      <th>TARGET</th>
                      <th>SATUAN</th>
                       <th>TARGET</th>
                      <th>SATUAN</th>

                    </tr>
                        </thead>
                        <tbody>
                            @php
                              $id_p=null;
                              $id_pi=null;
                              $id_k=null;
                              $id_ki=null;
                            @endphp
                            @foreach($data as $d)
                            
                                @if($d->id_p!=$id_p)
                                <tr class="bg bg-primary">
                                  <td class="text-right">{{$d->kode_p}}</td>
                                  <td>{{$d->urai_p}}</td>
                                  @php
                                  $id_p=$d->id_p;
                                  @endphp
                                  <td colspan="12"></td>
                                 </tr>
                                @endif
                                 @if($d->id_pi!=$id_pi)
                                <tr>
                                  <td colspan="4"></td>
                                  <td>{{$d->kode_pi}}</td>
                                  <td>{{$d->urai_pi}}</td>
                                  <td>{{$d->target_pi}}</td>
                                  <td>{{$d->satuan_pi}}</td>
                                 <td id="pi-{{$d->id_pi}}-target"><input type="text" name="" class="form-control" value="{{$d->target_pix}}" id="pi-{{$d->id_pi}}-target-value"></td>
                                  <td id="pi-{{$d->id_pi}}-satuan"><input type="text" name="" class="form-control" value="{{$d->satuan_pix}}" id="pi-{{$d->id_pi}}-target-satuan"></td>
                                  <td><button onclick="updateTargetAhir('ki-{{$d->id_pi}}','P',{{$d->id_pi}})" class="btn btn-warning btn-xs">UPDATE</button></td>
                                  @php
                                  $id_pi=$d->id_pi;
                                  @endphp
                                 </tr>
                                @endif
                                 @if($d->id_k!=$id_k)
                                <tr>
                                  <td colspan="2"></td>
                                  <td class="text-right">{{$d->kode_k}}</td>
                                  <td>{{$d->urai_k}}</td>
                                  @php
                                  $id_k=$d->id_k;
                                  @endphp
                                 </tr>
                                @endif
                                @if($d->id_ki!=$id_ki)
                                <tr>
                                  <td colspan="4"></td>
                                  <td>{{$d->kode_ki}}</td>
                                  <td>{{$d->urai_ki}}</td>
                                  <td>{{$d->target_ki}}</td>
                                  <td>{{$d->satuan_ki}}</td>
                                  <td id="ki-{{$d->id_ki}}-target"><input type="text" name="" class="form-control" value="{{$d->target_kix}}" id="ki-{{$d->id_ki}}-target-value"></td>
                                  <td id="ki-{{$d->id_ki}}-satuan"><input type="text" name="" class="form-control" value="{{$d->satuan_kix}}" id="ki-{{$d->id_ki}}-target-satuan"></td>
                                  <td><button onclick="updateTargetAhir('ki-{{$d->id_ki}}','K',{{$d->id_ki}})" class="btn btn-warning btn-xs">UPDATE</button></td>
                                  @php
                                  $id_ki=$d->id_ki;
                                  @endphp
                                 </tr>
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
<script type="text/javascript">

  function updateTargetAhir(id_dom,jenis,id){
    var data={
      'satuan':$('#'+id_dom+'-target-satuan').val(),
      'target':$('#'+id_dom+'-target-value').val(),
      'jenis':jenis,
      'tahun':{{Hp::fokus_tahun()}},
      'id':id
    };

    API_CON.post("{{route('api.int.prokeg.update_target')}}",data).then(function(res){
      if(res.data.code==200){
        Swal.fire(
          'Success',
          'Berhasil Menambahkan Target',
          'success'
        );
                
      }

    }); 
  }

</script>

@stop
