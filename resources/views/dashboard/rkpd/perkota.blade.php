@extends('adminlte::page_dashboard')


@section('content_header')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/highcharts/css/highcharts.css')}}">
  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_11.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/datatables/media/css/dataTables.bootstrap.min.css')}}">
<script type="text/javascript" src="{{asset('bower_components/datatables/media/js/jQuery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/datatables/media/js/jQuery.dataTables.min.js')}}"></script>


@stop


@section('content')
<h1 class="text-center"><b>PELAPORAN RKPD {{$provinsi->nama}}</b></h1>
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
</div>
</div>
<div class="row" style="margin-bottom: 10px;">

	<div class="col-md-6" id="chart" style="background: #fff; height: 400px;">
		
	</div>
	<div class="col-md-6" id="map" style="background: #fff;  height: 400px;">
		
	</div>

</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body">
					<table class="table table-bordered" id="data-table" style="width: 100%;">
						<thead>
							<tr>
								<th>NAMA PEMDA</th>
								<th>JUMLAH PROGRAM</th>
								<th>JUMLAH KEGIATAN</th>
								<th>PAGU</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
				</div>
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

		var data_pemda=[],data_chart=[];
		var chart=undefined;
		$.get('{{route('v.api.rkpd.pemda',['kodepemda'=>11])}}',function(res){

			data_pemda=res.map;
			data_chart=res.chart;

			map_builder();
			chart_builder();
			table_builder();
		});

		function table_builder(){
			table_init=$('#data-table').DataTable({
			    data:data_pemda,
				"language": {
	                "decimal":        ",",
    				"thousands":      ".",
	            },
				columns:[
				
					{
						data:'name',
						
					},
					{
						type:'number',

						render:function(data,key,dataRow){
							return dataRow.jumlah_program;
						}
					},
					{
						type:'number',
						render:function(data,key,dataRow){
							return dataRow.jumlah_kegiatan;
						}
					},
					{		
							
							type:'num-fmt',
							render:function(data,key,dataRow){
							return dataRow.jumlah_pagu;
						}
					},
					{	type:'html',
						render:function(data,key,dataRow){
							return '<a href="'+dataRow.link_detail+'"class="btn btn-success btn-sm">Detial</a>';
						}
					},
					
				]
			});

		}

		function map_builder(){
			map_init=Highcharts.mapChart('map', {
                chart: {
                    backgroundColor: 'transparent',
                },
                title: {
                    text: 'PELAPORAN RKPD PROVINSI',
                    style:{
                        color:'#222'
                    },
                    enabled:false
                },
         
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    headerFormat: '',
                    formatter: function() {
                        return (this.point.tooltip == undefined ? (this.point.integrasi !== undefined ? this.point.integrasi : this.point.nama) : this.point.tooltip); 
                    }
                },
                 mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },
                series:[

                	{
					    data: data_pemda,
					    name: 'APA AJA BOLEH',
					    joinBy: 'id',
					    type:'map',
					    visible:true,
					    mapData:Highcharts.maps['idn_11'],
					    dataLabels: {
					        enabled: true,
					        format: '{point.name}',
					        color: '#fff',
					        style: {
					            fontSize: 9,
					            font: '9px Trebuchet MS, Verdana, sans-serif'
					        },
					    },
					    color:'{point.color}',
					    states: {
					        hover: {
					            color: '#BADA55'
					        }
					    },
					}

                ]

            });

		}

		function chart_builder() {
			chart=Highcharts.chart('chart', {
			    chart: {
			        type: 'bar'
			    },
			    title: {
			        text: 'PELAPORAN RKPD PER-PROVINSI'
			    },
			  
			    data:data_chart,
			    legend: {
			        reversed: true
			    },
			    plotOptions: {
			        series: {
			            stacking: 'normal'
			        }
			    },
			     yAxis: [{ // Primary yAxis
			        labels: {
			            format: 'Rp.{value}',
				           align: 'right',
				           
                       
			          
			        },
			        title: {
			            text: 'ANGGARAN',
			            
			        },
			        opposite: true,
			        

			    }, { // Secondary yAxis
			      
			        labels: {
			            format: '{value} Bidang',
			            align: 'left',
			            
                     
			            
			        },
			          title: {
			            text: 'BIDANG',
			           
			        },


			    }],
			    series:[
				    {
				    	name:'Anggaran',
				    	yAxis:0,
				    	color:'green'

				    },
				    {
				    	name:'Jumlah Bidang',
				    	yAxis:1,
				    	color:'red'

				    }
			    ],
			    
			    
			});

			var categories = new Array();
			var data_series_0 = new Array();
			var data_series_1 = new Array();


			for (var i in data_chart) {
			    categories.push(data_chart[i].category);
			    data_series_0.push(data_chart[i].data[0]);
			    data_series_1.push(data_chart[i].data[1]);

			}
			chart.xAxis[0].setCategories(categories);
			 chart.series[0].setData(data_series_0);
			 chart.series[1].setData(data_series_1);




		}

		



// ------




</script>

@stop