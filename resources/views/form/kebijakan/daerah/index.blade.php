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
    API_CON.post('{{route('api.kebijakan.daerah.get.table.kota')}}',{'id':id}).then(function(res,err){
      $('#content-kota-table').html(res.data);
        setTimeout(function(){
        $('#table-kota').DataTable({
          sort:false
          },100);
        });
    });

  }

  </script>


@stop