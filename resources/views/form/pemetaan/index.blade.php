@extends('adminlte::page')


@section('content_header')
    <div class="row">
    	<div class="col-md-8">
    		<h3>PEMETAAN KEBIJAKAN DAN RPJMD </h3>
    	</div>
    	<div class="col-md-4 modal-footer">
    	</div>
    </div>
@stop

@section('content')

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-warning">
  			<div class="box-body table-responsive">
  				<table class="table table-sriped table-bordered">
		  			<thead>
		  				<tr>
		  					<th>SUB URUSAN</th>
                <th></th>
		  					<th>MANDAT</th>
		  					<th colspan="4" style="text-align:center">ARAH KEBIJAKAN RPJMN</th>
		  					
		  				</tr>
		  			</thead>
            <tbody>
              <?php
                $id_sub_urusan=0;
                $id_mandat=0;


               ?>
              
			  @foreach($kebijakan as $kb)
			             
                                
                
                 
                  <tr class="" style="border:2px solid black">
                    <td>{{$kb->sub_urusan}}</td>
                    
                    <td>
					@if($kb->mandat<>'')
                      <button class="btn btn-info btn-xs" onclick="showFormCreatePnIndikator({{$kb->id_mandat}})">
                        <i class="fa fa-edit"></i> pemetaan
                      </button>
					  @endif
                    </td>
                    <td> {{$kb->mandat}}</td>
                    <td colspan ="4" >
					<p style"align:justify">
					@if($kb->arah_kebijakan<>'(@)')
					                      <?php $arah=explode('<br>',$kb->arah_kebijakan); ?>
										  @foreach($arah as $ar)
										  <?php $a=explode('(@)',$ar); ?>
										  
										  <ul>
										  <li>
										 <span> {{$a[1]}} </span><span><button class="btn btn-danger  btn-xs" onclick="delete_mandat.build('{{route('pemetaan.kebijakan.delete',['id'=>$a[0]])}}','{{$kb->mandat}}','{{filter_id($a[1])}}')"><i class="fa fa-trash"></i></button></span>
										  </li>
										  </ul>
										  
										  @endforeach
										  
					@endif
					</p>
                    </td>
                                        
                             
                            
              @endforeach
            </tbody>

		  		</table>
  			</div>
  		</div>
  	</div>
  </div>




@stop

@section('js')

    <div class="modal fade" id="plus-mandat">
          <div class="modal-dialog">
                <form  v-bind:action="action" method="post">

              <div class="modal-content">
                      <div class="modal-header text-center">
                        <h4 class="text-uppercase">Tambah <span v-if='tipe==0' >Mandat</span><span v-if='tipe==1'>Kegiatan</span> | <span>@{{sub_urusan}}</span></h4>
                      </div>
                      <div class="modal-body" >
                        <div class="form-group">
                          <label class="text-center">Uraian <span v-if='tipe==0' >Mandat</span><span v-if='tipe==1'>Kegiatan</span> </label>
                          <textarea class="form-control" v-model="mandat" required="" name="uraian" style="min-height: 150px;"></textarea>
                        </div>
                        <div class="form-group">
                          <label class="checkbox-inline" style="min-width: 100px;">
                           <input id="tm"  type="checkbox" checked data-toggle="toggle" name="tipe" data-onstyle="warning" data-on="Mandat" data-off="Kegiatan" data-offstyle="info" data-size="small" data-width="100%"> 
                          </label>
                        </div>
                      </div>
                      <div class="modal-footer">
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah</button>
                      </div>
                   @csrf

                </div>
               </form>
          </div>
        </div>


        <script type="text/javascript">
                
          var tambah_mandat=new Vue({
                  el:'#plus-mandat',
                  data:{
                    tipe:0,
                    action:'',
                    sub_urusan:'',
                    mandat:''
                  },
                  methods:{
                    build:function(sub_urusan,link){
                      this.action=link;
                      this.sub_urusan=sub_urusan;
                        
                        setTimeout(function(){
                          $('#tm[type="checkbox"]').change(function(){
                            tambah_mandat.tipe=!$(this).prop('checked');
                          });
                          $('#plus-mandat').modal();
                        },300);


                    }
                  }

          }); 

            


    </script>




@include('form.pemetaan.partials.vue_modal_kebijakan',['tag'=>'uu']);
@include('form.pemetaan.partials.vue_modal_kebijakan',['tag'=>'pp']);
@include('form.pemetaan.partials.vue_modal_kebijakan',['tag'=>'permen']);
@include('form.pemetaan.partials.vue_modal_kebijakan',['tag'=>'perpres']);
@include('form.pemetaan.partials.vue_modal_delete_mandat');

<script type="text/javascript">
function nameRKP(jenis){
		switch(jenis){
			case 1:
				jenis='PN';
			break;
			case 2:
				jenis='PP';
			break;
			case 3:
				jenis='KP';
			break;
			case 4:
				jenis='PROPN';
			break;
			case 5:
				jenis='PTOYEK';
			break;
		}

		return jenis;
	}
	
	function showFormCreatePnIndikator(id,jenis=null){
		API_CON.get("{{route('form.pemetaan',['id'=>''])}}/"+id).then(function(res){
			$('#modal-global-lg .modal-header .modal-title').html('TAMBAH INDIKATOR '+nameRKP(jenis)+' {{Hp::fokus_tahun()}}');
			$('#modal-global-lg .modal-body').html(res.data);
			$('#modal-global-lg').modal();
		});
	}
var tagBody = '(?:[^"\'>]|"[^"]*"|\'[^\']*\')*';

var tagOrComment = new RegExp(
    '<(?:'
    // Comment body.
    + '!--(?:(?:-*[^->])*--+|-?)'
    // Special "raw text" elements whose content should be elided.
    + '|script\\b' + tagBody + '>[\\s\\S]*?</script\\s*'
    + '|style\\b' + tagBody + '>[\\s\\S]*?</style\\s*'
    // Regular name
    + '|/?[a-z]'
    + tagBody
    + ')>',
    'gi');
function removeTags(html) {
  var oldHtml;
  do {
    oldHtml = html;
    html = html.replace(tagOrComment, '');
  } while (html !== oldHtml);
  return html.replace(/</g, '&lt;');
}

	</script>

@stop
