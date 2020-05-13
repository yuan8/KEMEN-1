@extends('adminlte::page_front')


@section('content_header')
     <div class="row">
    	<div class="col-md-12">
    		<h3 class="text-uppercase text-center">KINERJA URUSAN DAERAH 2021</h3>
    	</div>
    </div>
   	<style type="text/css">
   		.hover-bg-td:hover{
   			background: #ddd;
   		}
      .modal-lg{
        width: 95%;
      }
   	</style>

@stop

@section('content')

<div class="box">
  <div class="box-body">
    <table class="table table-bordered" id="table_urusan">
      <thead>
        <tr>
          <th>
            URUSAN
          </th>
          <th>JUMLAH INDIKATOR</th>
          <th>ACTION</th>

        </tr>
      </thead>
      <tbody>
       
      </tbody>
    </table>
  </div>
</div>

@stop


@section('js')
<script type="text/javascript">
  var data_source=<?php echo json_encode($data)?>; 
  var table_urusan=$('#table_urusan').DataTable({
    sort:false,
    columns:[
      {
        data:'nama',
        type:'string',

      },
      {
        data:'data',
        type:'string',
        render:function(data,type){
          return data.length;

        }
      },
      {
        data:'nama',
        type:'html',
        render:function(data,type,datarow,setting){
          return '<button class="btn btn-warning btn-xs" onclick="detail_urusan('+setting.row+')">DETAIL</button>'; 
        
        }
      }
    ]
  });


var table_detail_ind='';
  table_urusan.rows.add(data_source).draw();

function detail_urusan(index){
  console.log(table_detail_ind);
  if(table_detail_ind!=''){
    table_detail_ind.clear();
    table_detail_ind.destroy();

  }

  table_detail_ind=$('#table_detail_ind').DataTable({
    sort:false,
    columns:[
      {
        data:'kodeiku'
      },
      {
        data:'nama_indikator'
      },{
        data:'target_nasional',
        type:'string',
        render:function(data,type,datarow){
          return data+' '+datarow.nama_satuan;
        }
      },
      {
        data:'jumlah_pemda',

      },
      {
        data:'url',
        type:'html',
        render:function(data,type,datarow){
          return '<a class="btn btn-warning btn-xs" target="_blank" href="'+data+'">DETAIL</a>'; 
        }
      }
    ]
  });


  $('#modal_detail_ind').modal();
  $('#modal_detail_ind .modal-header h5 b').html(data_source[index].nama);

  table_detail_ind.rows.add(data_source[index].data).draw();
}

</script>



<div class="modal fade" id="modal_detail_ind">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="text-center"><b></b></h5> 
    </div>
     <div class="modal-body">
        <table class="table-bordered table" id="table_detail_ind">
        <thead>
          <tr>
            <th>KODE</th>
            <th>NAMA INDIKATOR</th>
            <th>TARGET NASIOANAL</th>
            <th>JUMLAH DAERAH TAGING</th>
            <th>ACTION</th>
          
          </tr>
        </thead>
      </table>
     </div>
    </div>
  </div>
</div>


@stop