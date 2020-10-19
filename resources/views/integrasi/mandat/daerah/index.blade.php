@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3>IDENTIFIKASI KEBIJAKAN DAERAH </h3>
    	</div>
    	
    </div>
@stop

@section('content')
  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-solid">
  			<div class="box-body ">
          <table class="table  table-bordered" id="table-pro">
            <thead>
              <tr class="bg-navy">
                <th>KODE</th>
                <th>NAMA DAERAH</th>
                <th>STATUS</th>
                

                <th>ACTION</th>


              </tr>
            </thead>
            <tbody>
              @foreach($data as $key=> $p)
              <tr  class="{{$p->exists?'bg-warning':''}}">
                <td>{{$p->id}}</td>

                <td>{{$p->nama_daerah}}</td>
                <td>{{$p->exists?'TERDAPAT DATA':'-'}}</td>

                <td>
                  <a href="{{route('kebijakan.daerah.view.daerah',['id'=>$p->id])}}" class="btn btn-xs {{$p->exists?'btn-warning':'btn-success'}} ">{{$p->exists?'UPDATE':'TAMBAH'}}</a>
                  
                </td>
               
              </tr>

              @endforeach

            </tbody>

          </table>
  			</div>
  		</div>
  	</div>
    <div class="col-md-6" id="content-kota-table">
      
    </div>
  </div>


@stop


@section('js')
  <script type="text/javascript">
    $('#table-pro').DataTable({
      sort:false,
          "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],

    });



  function deatiledDaerah(id){
    API_CON.post('{{route('api.kebijakan.daerah.get.table.kota')}}',{'id':id}).then(function(res,err){
      $('#content-kota-table').html(res.data);
        setTimeout(function(){
        $('#table-kota').DataTable({
          sort:false,
          },100);
        });
    });

  }

  </script>


@stop