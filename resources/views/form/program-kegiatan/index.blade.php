@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">PROGRAM KEGIATAN DAERAH ({{(int)Hp::fokus_tahun() - 1}}) </h3>
    		
    	</div>
    	<!-- <div class="col-md-4 modal-footer" style="padding-top: 20px;">
    		<div class="btn-group">
    			<a href="{{route('program.kegiatan.download-template')}}" class="btn btn-warning">
    			<i class="fa fa-download"></i> Download template 
    		</a>
    		<button class="btn btn-warning">
    			<i class="fa fa-upload"></i> Upload Dokument 
    			
    		</button>
    		</div>

    	</div> -->
    	
    </div>
@stop


@section('content')

<div class="box box-warning">
    <div class="box-body table-responsive">
        <table class="table table-bordered" id="container-daerah">
            <thead>
                <tr>
                    <th>DAERAH</th>
                    <th>JUMLAH KEGIATAN</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@stop


@section('js')
<script type="text/javascript">
    var data_table=[];

    var data_list_for_add=$('#container-daerah').DataTable({
            'sort':false,
            'columns':[
                {
                    data:'nama',
                    type:'string'

                },
                {
                    data:'jumlah_kegiatan',
                    type:'num',
                   

                },
                
            ],
            autoWidth:false,
             "lengthMenu": [[10,15], [10,15]],
            'createdRow':function (row, data, dataIndex,meta) {
                $(row).addClass('cursor-link');
                if(data.is_provinsi){
                    $(row).addClass('bg bg-warning');
                }

                // console.log(data);

                $(row).attr('onclick', 'open_link('+data.id+')');
            },
            data:[]
        });

    API_CON.get('{{route('api.pk.daerah')}}').then(function(res){
            data_list_for_add.rows.add(res.data);
            data_table=res.data;
            data_list_for_add.draw();
     });


    function open_link(id){
       var path="{{route('pk.detail')}}/"+id;
      window.location.href=path;
    }

</script>



@stop