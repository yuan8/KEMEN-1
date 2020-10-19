@extends('adminlte::desk')
@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highcharts.js')}}"></script>
  <script type="text/javascript" src="{{asset('bower_components/highcharts/modules/sankey.js')}}"></script>

  <script type="text/javascript" src="{{asset('bower_components/highcharts/modules/organization.js')}}"></script>



@stop


@section('content')
<div class="container">
	<div class="row">
	<div class="col-md-12" style="margin-bottom: 10px; margin-top: 10px;">
		<table class="table">
			<tr>
				<td style="width:100px">
					<div class="btn-group pull-left">
			<a href="{{$data->previousPageUrl()}}" class="btn btn-success"><i class="fa fa-arrow-left"></i> PREVIEW</a>
		</div>
				</td>
				<td>
					<H3 class="text-center" > <b>{{$daerah->nama}}</b></H3>
				</td>
				<td style="width:100px">
					<div class="btn-group pull-right">
			<a href="{{$data->nextPageUrl()}}" class="btn btn-success"><i class="fa fa-arrow-right"></i> NEXT</a>
		</div>
				</td>
			</tr>
		</table>
		
		
		
	</div>
	
</div>
</div>
<div class="row">
	 <?php
            $id_sub_urusan=0;
            $id_mandat=0;
            $kb=$data[0];

         ?>
	<div class="col-md-12">
		<table class="table bg-white">
			<tr class="bg-primary">
				<td colspan="4">
					<h4 class="text-center"><b>{{$kb->nama}}</b></h4>
				</td>
			</tr>
			<tr>

				<td style="width: 25%">
                                        	 <p><b>UNDANG-UNDANG</b></p>
					
					@if(!empty($kb->uu))
               <ul>
                <?php $duu=explode('|@|',$kb->uu); ?>
                @foreach($duu as $uu)
                <?php $uu=explode('(@)', $uu) ?>

                <li>{!!nl2br($uu[1])!!}</li>
                @endforeach
               </ul>

                                          @endif
				



				</td>
				<td style="width: 25%">
                                         <p><b>PERATURAN PEMERINTAH</b></p>

					  @if(!empty($kb->pp))
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->pp); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{!!nl2br($uu[1])!!}</li>
                                            @endforeach


                                           </ul>

                                          @endif
					
				</td>
				<td style="width: 25%">
                                           <p><b>PERATURAN MENTRI</b></p>

                                            @if(!empty($kb->perpres))
                                             <ul>
                                              <?php $duu=explode('|@|',$kb->perpres); ?>
                                              @foreach($duu as $uu)
                                              <?php $uu=explode('(@)', $uu) ?>

                                              <li>{!!nl2br($uu[1])!!}</li>
                                              @endforeach


                                           </ul>

                                          @endif
					
				</td>
				<td style="width: 25%">
                                           <p><b>PERATURAN MENTRI</b></p>

					    @if(!empty($kb->permen))
                                             <ul>
                                              <?php $duu=explode('|@|',$kb->permen); ?>
                                              @foreach($duu as $uu)
                                              <?php $uu=explode('(@)', $uu) ?>

                                              <li>{!!nl2br($uu[1])!!}</li>
                                              @endforeach


                                           </ul>

                                          @endif
				</td>
			</tr>
		</table>
		<div class="box box-solid">
			<div class="box-body">
				<h5><b>MANDAT</b></h5>
				<h5><b>   {!!nl2br($kb->mandat)!!}</b></h5>
			</div>
		</div>
		<div class="box box-solid">
		<div class="box-body">
			

			<table class="table table-bordered">
				
				 @foreach($data as $kb)
                        @php
                        @endphp
                          <script type="text/javascript">
                            var mandat_{{$kb->id_mandat}}=<?php echo json_encode($kb); ?>;
                          </script>
                            
                             @if(($id_mandat!=$kb->id_mandat)&&(!empty($kb->id_mandat)))
                             
                              @if((!empty($kb->id_integrasi)))
                                  <tr class="{{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'':'bg-warning') }}">
                                      

                                      <td>


                                          <button class="btn btn-info btn-xs" onclick="plus_perda.build('#plus-perda',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perda',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perda',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perda,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERDA
                                          </button>
                                      </td>
                                      <td>
                                        <script type="text/javascript">
                                         var perkada_{{$kb->id}}=<?php echo json_encode($kb); ?>;
                                       </script>
                                            <button class="btn btn-info btn-xs" onclick="plus_perkada.build('#plus-perkada',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perkada',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perkada',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perkada,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERKADA
                                          </button>
                                      </td>
                                     <td>
                                            <button class="btn btn-info btn-xs" onclick="plus_lainnya.build('#plus-lainnya',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.lainnya',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.lainnya',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.lainnya,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> LAINNYA
                                          </button>
                                      </td>

                                  </tr>
                                  <tr class="{{$kb->kesesuaian==0?'bg-danger':(($kb->kesesuaian==1)?'bg-':'bg-warning') }}">
                                     
                                      <td>
                                          <p><b>PERDA</b></p>
                                          @if(!empty($kb->perda))
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->perda); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{{$uu[1]}}</li>
                                            @endforeach


                                           </ul>

                                          @endif

                                      </td>
                                      <td>
                                          <p><b>PERKADA</b></p>

                                          @if(!empty($kb->perkada))
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->perkada); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{{$uu[1]}}</li>
                                            @endforeach


                                           </ul>

                                          @endif

                                      </td>
  									                     <td>
                                          <p><b>LAINNYA</b></p>

                                          @if(!empty($kb->lainnya))
                                           <ul>
                                            <?php $duu=explode('|@|',$kb->lainnya); ?>
                                            @foreach($duu as $uu)
                                            <?php $uu=explode('(@)', $uu) ?>

                                            <li>{{$uu[1]}}</li>
                                            @endforeach


                                           </ul>

                                          @endif

                                      </td>
                                  </tr>

                              @else
                                <tr>

                                       
                                     
                                     <td>


                                          <button class="btn btn-info btn-xs" onclick="plus_perda.build('#plus-perda',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perda',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perda',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perda,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERDA
                                          </button>
                                      </td>
                                      <td>
                                        <script type="text/javascript">
                                         var perkada_{{$kb->id}}=<?php echo json_encode($kb); ?>;
                                       </script>
                                            <button class="btn btn-info btn-xs" onclick="plus_perkada.build('#plus-perkada',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.perkada',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.perkada',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.perkada,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> PERKADA
                                          </button>
                                      </td>
                                     <td>
                                            <button class="btn btn-info btn-xs" onclick="plus_lainnya.build('#plus-lainnya',mandat_{{$kb->id_mandat}}.mandat,'{{route('kebijakan.daerah.store.mandat.lainnya',['id'=>$kb->id,'id_mandat'=>$kb->id_mandat])}}','{{route('api.kebijakan.daerah.store.lainnya',['id'=>$kb->id_mandat])}}',mandat_{{$kb->id_mandat}}.lainnya,'{{$kode_daerah}}')">
                                              <i class="fa fa-edit"></i> LAINNYA
                                          </button>
                                      </td>





                                </tr>
                                <?php $id_sub_urusan=$kb->id; ?>
                            @endif
                             <tr>
                                <td colspan="7" style="background: #ddd"></td>
                              </tr>

                            @endif
                        @endforeach
			</table>
		</div>
	</div>
	</div>
</div>

@stop

@section('js')
<style type="text/css">
	.highcharts-background{
		fill:transparent;
	}
</style>
<script type="text/javascript">

@php 
	$node=[
		'MANDAT'=>[
			'id'=>'MANDAT',
			'title'=>'MANDAT',
			'description'=>nl2br(str_replace('"', '', $data[0]->mandat)),
			'level'=>4
		],

	];

	$data_node=[];


@endphp

 @if(!empty($kb->uu))

   <?php $duu=explode('|@|',$kb->uu); ?>
    @foreach($duu as $key=>$x)
   		 <?php $x=explode('(@)', $x) ?>
	    @php
		    $node[
		    	'UU'.$key]=[
				'id'=>'',
				'title'=>'',
				'description'=>'',
				'level'=>0

			];
	    	$node['UU'.$key]['id']='UU'.$key;
	    	$node['UU'.$key]['title']='UNDANG-UNDANG';
	    	$node['UU'.$key]['description']=nl2br(str_replace('"', '', $x[1])).' <br>';
   			$data_node[]=['UU'.$key,'MANDAT'];

	    @endphp
    @endforeach

  
  @endif

   @if(!empty($kb->pp))

   <?php $duu=explode('|@|',$kb->pp); ?>
    @foreach($duu as $key=>$x)
   		 <?php $x=explode('(@)', $x) ?>
	    @php
	    $node['PP'.$key]=[
				'id'=>'',
				'title'=>'',
				'description'=>'',
				'level'=>1

			];
	    	$node['PP'.$key]['id']='PP'.$key;
	    	$node['PP'.$key]['title']='PERATURAN PERMERINTAH';
	    	$node['PP'.$key]['description']=nl2br(str_replace('"', '', $x[1])).' <br>';
   			$data_node[]=['PP'.$key,'MANDAT'];

	    @endphp
    @endforeach

   @php 
   // dd((array_values($data_node)));
   @endphp
  @endif

   @if(!empty($kb->permen))

   <?php $duu=explode('|@|',$kb->permen); ?>
    @foreach($duu as $key=>$x)
   		 <?php $x=explode('(@)', $x) ?>
	    @php
	    $node['PERMEN'.$key]=[
				'id'=>'',
				'title'=>'',
				'description'=>'',
				'level'=>2

			];
	    	$node['PERMEN'.$key]['id']='PERMEN'.$key;
	    	$node['PERMEN'.$key]['title']='PERATURAN MENTRI';
	    	$node['PERMEN'.$key]['description']=nl2br(str_replace('"', '', $x[1])).' <br>'??'-';
   			$data_node[]=['PERMEN'.$key,'MANDAT'];

	    @endphp
    @endforeach

   @php 
   // dd((array_values($node)));
   @endphp
  @endif

   @if(!empty($kb->perpres))

   <?php $duu=explode('|@|',$kb->perpres); ?>
    @foreach($duu as $key=>$x)
   		 <?php $x=explode('(@)', $x) ?>
	    @php
	    $node['PERPRES'.$key]=[
				'id'=>'',
				'title'=>'',
				'description'=>'',
				'level'=>3
			];
	    	$node['PERPRES'.$key]['id']='PERPRES'.$key;
	    	$node['PERPRES'.$key]['title']='PERATURAN PRESIDEN';
	    	$node['PERPRES'.$key]['description']=nl2br(str_replace('"', '', $x[1])).' <br>'??'-';
   			$data_node[]=['PERPRES'.$key,'MANDAT'];

	    @endphp
    @endforeach

   @php 
   // dd((array_values($node)));
   @endphp
  @endif
 

  var series={
	'nested_list':<?php echo json_encode($data_node) ?>,
	'node':<?php echo json_encode(array_values($node)) ?>
	};



   Highcharts.chart('map-kebijakan', {
  chart: {
    height: 600,
    inverted: true
  },

  title: {
    text: 'IMPLEMENTASI KEBIJAKAN PUSAT PADA {{$daerah->nama}}'
  },

  accessibility: {
    point: {
      descriptionFormatter: function (point) {
        var nodeName = point.toNode.name,
          nodeId = point.toNode.id,
          nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
          parentDesc = point.fromNode.id;
        return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
      }
    }
  },

  series: [{
    type: 'organization',
    name: 'Highsoft',
    keys: ['from', 'to'],
    data:series.nested_list,
 
    nodes:series.node,
    colorByPoint: false,
    color: '#007ad0',
    dataLabels: {
      color: 'white'
    },
    borderColor: 'white',
    nodeWidth: 60
  }],
  tooltip: {
    outside: true
  },
  exporting: {
    allowHTML: true,
    sourceWidth: 800,
    sourceHeight: 600
  }

});


</script>
@section('js')

@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perda'])
@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'perkada'])
@include('form.kebijakan.daerah.partials.vue_modal_tambah_kebijakan_daerah',['tag'=>'lainnya'])
@include('form.kebijakan.daerah.partials.vue_modal_update_kesesuaian')



@stop
@stop