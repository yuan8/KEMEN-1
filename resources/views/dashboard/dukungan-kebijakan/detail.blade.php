@extends('adminlte::page_dashboard')


@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highcharts.js')}}"></script>
  <script type="text/javascript" src="{{asset('bower_components/highcharts/modules/sankey.js')}}"></script>

  <script type="text/javascript" src="{{asset('bower_components/highcharts/modules/organization.js')}}"></script>



@stop


@section('content')
<h1 class="text-center"><b>DUKUNGAN KEBIJAKAN PROVINSI A</b></h1>
<hr>

<div class="container">
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-md-3">
			<label>TAHUN</label>
			<select class="form-control">
				<option>2020</option>
			</select>
		</div>
		<div class="col-md-3">
			<label>DAERAH</label>
			<select class="form-control">
				<option>SEMUA</option>
			</select>
		</div>
		<div class="col-md-3">
			<label>URUSAN</label>
			<select class="form-control">
				<option>SEMUA</option>
				
			</select>
		</div>
			<div class="col-md-3">
			<label>KEBIJAKAN PUSAT</label>
			<select class="form-control">
				<option>SEMUA</option>
				
			</select>
		</div>
	</div>
</div>

<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body">
					<div id="map-organization"></div>
				</div>
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


   Highcharts.chart('map-organization', {
  chart: {
    height: 600,
    inverted: true
  },

  title: {
    text: 'Highcharts Org Chart'
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
    data: [
      ['KEBIJAKANPUSAT', 'MANDAT'],
      ['PP', 'MANDAT'],
      ['PERMEN', 'MANDAT'],
      ['PERPRES', 'MANDAT'],
      ['MANDAT', 'PERKADA'],
      ['MANDAT', 'PERDA'],
      ['MANDAT', 'LAINLAIN'],

   
  
    ],
    levels: [{
      level: 0,
      color: '#359154',
      dataLabels: {
        color: 'black'
      },
      height: 25
    }, {
      level: 1,
      color: '#f1f1f1',
      dataLabels: {
        color: 'black'
      },
      height: 25
    }, {
      level: 2,
      color: '#980104'
    }, {
      level: 4,
      color: '#359154'
    }],
    nodes: [
    {
    	id:'KEBIJAKANPUSAT',
    	title:'KEBIJAKAN PUSAT',
    },
       {
    	id:'KESESUAIAN',
    	title:'KESESUAIAN',
    },
     {
    	id:'MANDAT',
    	name:'DDD'
    },
     {
    	id:'UU',
    	title:'UNDANG UNDANG',
    },
      {
    	id:'PERDA',
    	title:'PERDA (SESUAI)',
    	name:'DDD'
    },
     {
    	id:'PERKADA',
    	title:'PRERKADA (SESUAI)',
    	name:'DDD'
    },
     {
    	id:'LAINLAIN',
    	title:'LAIN - LAIN (SESUAI)',
    	name:'DDD'
    },
   ],
    colorByPoint: false,
    color: '#007ad0',
    dataLabels: {
      color: 'white'
    },
    borderColor: 'white',
    nodeWidth: 65
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

@stop