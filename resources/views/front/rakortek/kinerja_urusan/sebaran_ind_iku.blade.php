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
<h5 class="text-center text-uppercase"><b>Indikator {{$nama}}</b></h5>
<div class="box box-warning">
  <div class="box-header with-border">
    <div class="col-md-3">
      <div class="form-group">
        <label>PROVINSI / KOTA</label>
        <select class="form-control tgr_td" id="cat_daerah">
          <option value="" >SEMUA</option>
          <option value="P" >PROVINSI</option>
          <option value="K" >KOTA</option>

        </select>
      </div>
    </div>
    <div class="col-md-3">


       <div class="form-group">
        <label>KETERISIAN TAGGING</label>
        <select class="form-control tgr_td" id="cat_tagging">
          <option value="" >SEMUA</option>
          <option value="1" >MELAKUKAN TAGGING</option>
          <option value="0" >TIDAK MELAKUKAN TAGGING</option>

        </select>
      </div>

    </div>
    <div class="col-md-3">
       <div class="form-group">
        <label>KEGIATAN PENDUKUNG</label>
        <select class="form-control tgr_td" id="cat_pendukung">
          <option value="" >SEMUA</option>
          <option value="1" >MENYERTAKAN</option>
          <option value="0" >TIDAK MENYERTAKAN</option>

        </select>
      </div>

    </div>
     <div class="col-md-3">
       <div class="form-group">
        <label>CATATAN</label>
        <select class="form-control tgr_td" id="cat_catatan">
          <option value="" >SEMUA</option>
          <option value="1" >MENYERTAKAN</option>
          <option value="0" >TIDAK MENYERTAKAN</option>

        </select>
      </div>

    </div>
    <div class="col-md-3">
       <div class="form-group">
        <label>PROVINSI</label>
        <select class="form-control tgr_td use-select-2-def" id="cat_provinsi">
          <option value="" >SEMUA</option>
          @foreach($provinsi as $p)
          <option value="{{$p->id}}">{{$p->nama}}</option>
          @endforeach

        </select>
      </div>

    </div>

  </div>
  <div class="box-body">
    <table class="table table-bordered" id="table_urusan">
      <thead>
        <tr>
          <th>
            KODE DAERAH
          </th>
          <th>NAMA DAERAH</th>
          <th>NAMA INDIKATOR</th>

          <th>TARGET NASIONAL</th>
          <th>TARGET DAERAH</th>
          <th>KEGIATAN PENDUKUNG</th>
          <th>CATATAN</th>
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
  function detail_catatan(kodedaerah,kodeiku,index){
    API_CON.post('{{route('front.r.iku.catatan',['kodedaerah'=>null,'kodeiku'=>null])}}'+'/'+kodedaerah+'/'+kodeiku).then(function(data,err){
        $('#table_detail_keg .modal-body').html(data.data);
      $('#table_detail_keg').modal();
      $('#table_detail_keg .modal-header  h5 b').html(data_source[index].nama_daerah+' - '+data_source[index].nama_indikator);


  });
  }


  var data_source=<?php echo json_encode($data)?>; 
  var table_urusan=$('#table_urusan').DataTable({
    sort:false,
    createdRow:function(row,data,dataIndex,cells){
      if(data.kode_indikator==null){
        $(row).addClass("bg-danger");
      }

    },
    columns:[
      {
        data:'kode_daerah',
        type:'string',
        createdCell: function (td, cellData, rowData, row, col) {
          if(cellData.length < 3){
            $(td).addClass('bg bg-primary');
          }
        },

      },
      {
        data:'nama_daerah',
        type:'string',
        render:function(data){
          return data||'';
        }

      },
       {
        data:'nama_indikator',
        type:'string',
        render:function(data){
          return data||'';
        }

      },
      {
        data:'target_nasional',
        type:'string',
        render:function(data,type,datarow){
           if(data){
             return data+' '+datarow.nama_satuan;
           }else{
            return '';
           }
        }

      },
     {
      data:'target_daerah',
      type:'string',
      render:function(data,type,datarow){
       if(data){
         return data+' '+datarow.nama_satuan;
       }else{
        return '';
       }
      }

    },
    {
        data:'jumlh_pendukung',
        type:'string',
        render:function(data,type,datarow,setting){
          return data>0?'<button class="btn btn-warning btn-xs text-dark" onclick="detail_pendukung(`'+datarow.kode_daerah+'`,`'+datarow.kode_indikator+'`,'+setting.row+')">'+data+' KEGIATAN</button>':'TIDAK MEMILIKI';

        }
      },
     {
        data:'catatan',
        type:'string',
        render:function(data,type,datarow,setting){
          return (data!=''&&data!=null)?'<button class="btn btn-success btn-xs" onclick="detail_catatan(`'+datarow.kode_daerah+'`,`'+datarow.kode_indikator+'`,'+setting.row+')">CATATAN</button>':'TIDAK MEMILIKI';

        }
      },
    ]
  });


var table_detail_ind='';
table_urusan.rows.add(data_source).draw();


$.fn.dataTable.ext.search.push(
       function( settings, dt, index,data ) {
        var approve=true;
        if(settings.nTable.id='table_urusan'){

          if(approve){
            var avaible_u=$('#cat_daerah').val();
            switch(avaible_u){
              case '':
              approve=true;
              break;
              case 'P':
              if(data.kode_daerah.length<3){
                approve=true;
              }else{
                approve=false;
              }
              break;
              case 'K':
              if(data.kode_daerah.length>3){
                approve=true;
              }else{
                approve=false;
              }
              break;
              default:
              approve=false;
              break;
            }  

          }

           if(approve){
            var avaible_u=$('#cat_pendukung').val();
            switch(avaible_u+''){
              case '':
              approve=true;
              break;
              case '1':
              if(data.jumlh_pendukung>0){
                approve=true;
              }else{
                approve=false;
              }
              break;
              case '0':
              if(data.jumlh_pendukung==0){
                approve=true;
              }else{
                approve=false;
              }
              break;
              default:
              approve=false;
              break;
            } 
          } 

            if(approve){
              var avaible_u=$('#cat_tagging').val();
              switch(avaible_u+''){
                case '':
                approve=true;
                break;
                case '1':
                if(data.kode_indikator!=null){
                  approve=true;
                }else{
                  approve=false;
                }
                break;
                case '0':
                if(data.kode_indikator==null){
                  approve=true;
                }else{
                  approve=false;
                }
                break;
                default:
                approve=false;
                break;
              }  
          }

          if(approve){
              var avaible_u=$('#cat_catatan').val();
              
              switch(avaible_u+''){
                case '':
                approve=true;
                break;
                case '1':
                if((data.catatan!='') && (data.catatan!=null)){
                  approve=true;
                }else{
                  approve=false;
                }
                break;
                case '0':
                if((data.catatan=='') || (data.catatan==null)){
                  approve=true;
                }else{
                  approve=false;
                }
                break;
                default:
                approve=false;
                break;
              }  
          }

           if(approve){
              var avaible_u=$('#cat_provinsi').val();
              if(('D'+data.kode_daerah+'').includes('D'+avaible_u)){
                approve=true;
              }else{
                approve=false;
              }
          }

          if(approve){
            return true;
          }else{
            return false;
          }                 


        }
      }
);


$('.tgr_td').on('change',function(){
  table_urusan.draw();
});


function detail_pendukung(kodedaerah,kodeiku,index){

  API_CON.post('{{route('front.r.iku.pendukung',['kodedaerah'=>null,'kodeiku'=>null])}}'+'/'+kodedaerah+'/'+kodeiku).then(function(data,err){
    $('#table_detail_keg .modal-body').html(data.data);
  $('#table_detail_keg').modal();
      $('#table_detail_keg .modal-header  h5 b').html(data_source[index].nama_daerah+' - '+data_source[index].nama_indikator);


  });

}

</script>



<div class="modal fade" id="table_detail_keg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="text-center"><b></b></h5> 
    </div>
     <div class="modal-body">
        <table class="table-bordered table" >
        <thead>
          <tr>
            <th>KODE</th>
            <th>NAMA KEGIATAN</th>
          </tr>
        </thead>
      </table>
     </div>
    </div>
  </div>
</div>


@stop