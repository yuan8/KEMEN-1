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
  	<div class="col-md-6">
  		<div class="box box-success">
  			<div class="box-body table-responsive">
  				<table class="table table-striped" id="table-pro">
		  			<thead>
		  				<tr>
		  					<th>KODE</th>
		  					<th>PROVINSI</th>

		  				</tr>
		  			</thead>
            <tbody>
              @foreach($provinsis as $key=> $p)
              <tr  class="cursor-link" onclick="deatiledDaerah({{$p->id}})">
                <td>{{$p->id}}</td>
                <td>{{$p->nama}}</td>
               
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
      sort:false
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