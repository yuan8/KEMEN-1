@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PERMASALAHAN URUSAN  </h3>
    		<small>{{Hp::fokus_urusan()['nama']}}</small>
    	</div>
    	
    </div>
@stop


@section('content')

  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-body">
          <div class="pull-left">
            <h5><b>PEMETAAN PERMASALAHAN</b></h5>
          </div>
          <div class="pull-right">
            <a href="{{route('int.permasalahan.mpokok')}}" class="btn btn-success btn-xs">PERMASALAHAN POKOK</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
  			<div class="box-body ">
  				<table class="table  table-bordered" id="table-pro">
		  			<thead>
		  				<tr>
		  					<th>KODE</th>
		  					<th>NAMA DAERAH</th>
                <th>TERDAPAT DATA</th>

                <th>ACTION</th>


		  				</tr>
		  			</thead>
            <tbody>
              @foreach($daerah as $key=> $p)
              <tr  class="{{$p->ms_exists?'bg-warning':''}}">
                <td>{{$p->id}}</td>

                <td>{{$p->nama}}</td>
                <td>{{$p->ms_exists?'TERDAPAT DATA':'-'}}</td>

                <td>
                  <a href="{{route('permasalahan.daerah.view.daerah',['id'=>$p->id])}}" class="btn btn-xs {{$p->ms_exists?'btn-warning':'btn-success'}} ">{{$p->ms_exists?'UPDATE':'TAMBAH'}}</a>
                  
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

    });



  function deatiledDaerah(id){
    API_CON.post('{{route('api.permasalahan.daerah.get.table.kota')}}',{'id':id}).then(function(res){
      var res= res.data;
      $('#content-kota-table').html(res);
      setTimeout(function(){
        $('#table-kota').DataTable({
          sort:false
        },100);
      })
    });

  }

  </script>


@stop