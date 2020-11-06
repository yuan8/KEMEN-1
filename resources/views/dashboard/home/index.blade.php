@extends('adminlte::page_dashboard')


@section('content_header')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/highcharts/css/highcharts.css')}}">
  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_11.js')}}"></script>
@stop


@section('content')
<h1 class="text-center"><b>RKPD PROVINSI TAHUN {{$tahun}}</b></h1>
<hr>
<div class="container">
	<div class="row" style="margin-bottom: 10px;">
	<div class="col-md-3">
		<label>TAHUN</label>
		<select class="form-control" onchange="window.location.href=this.value">
			<option value="{{route('v.rkpd.prov',['tahun'=>date('Y')])}}" {{$tahun==date('Y')?'selected':''}}>{{date('Y')}}</option>
			<option value="{{route('v.rkpd.prov',['tahun'=>date('Y')+1])}}" {{$tahun==(date('Y')+1)?'selected':''}}>{{date('Y')+1}}</option>
		</select>
	</div>
	<div class="col-md-3">
		<label>DAERAH</label>
		<select class="form-control">
			<option>SEMUA</option>
		</select>
	</div>
{{-- 	<div class="col-md-3">
		<label>URUSAN</label>
		<select class="form-control">
			<option>SEMUA</option>
			
		</select>
	</div> --}}
</div>
</div>
<style type="text/css">
	.list-group-horizontal .list-group-item
{
	display: inline-block;
}
.list-group-horizontal .list-group-item
{
	margin-bottom: 0;
	margin-left:-4px;
	margin-right: 0;
 	border-right-width: 0;
}
.list-group-horizontal .list-group-item:first-child
{
	border-top-right-radius:0;
	border-bottom-left-radius:4px;
}
.list-group-horizontal .list-group-item:last-child
{
	border-top-right-radius:4px;
	border-bottom-left-radius:0;
	border-right-width: 1px;
}
</style>
<div class="row" style="margin-bottom: 15px;">

	<div class="col-md-6" id="chart" style="background: #fff; height: 462px;">
		
	</div>
	<div class="col-md-6"  style="background: #fff;  height: 462px;">
		<div id="map"></div>
		<p class="text-center"><b>Persentase Pelaporan</b></p>
		<ul class="list-group list-group-horizontal text-center">
		  <li class="list-group-item"><i class="fas fa-circle"></i> =0%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:red;"></i> <=20%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:orange;"></i> <=40%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:yellow;"> </i> <=60%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:green;"> </i> <=60%</li>
		  <li class="list-group-item"><i class="fas fa-circle" style="color:#45ff23;"> </i> <=100%</li>
		</ul>
	</div>

</div>
{{-- <div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body">
					<table class="table table-bordered">
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
							<tr>
								<td>PROVINSI ACEH</td>
								<td>7</td>
								<td>11</td>
								<td>Rp. 300,0000,0000</td>
								<td>
									<div class="btn-group">
										
									</div>
								</td>

							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div> --}}

	
</div>

@stop

@section('js')
<style type="text/css">
	.highcharts-background{
		fill:transparent;
	}
</style>
<script type="text/javascript">
		map_init=Highcharts.mapChart('map', {
                chart: {
                    backgroundColor: 'transparent',
                },
                title: {
                    text: 'PELAPORAN RKPD PER-PROVINSI',
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
					    data: <?= json_encode($data_map) ?>,
					    name: 'APA AJA BOLEH',
					    joinBy: 'id',
					    type:'map',
					    visible:true,
					    mapData:Highcharts.maps['ind'],
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



// ------


var clm_chart=Highcharts.chart('chart', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'PELAPORAN RKPD PER-PROVINSI'
    },
    xAxis:{
    	categories:<?= json_encode($data_chart['category'])?>,
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pemda'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'DAERAH MELAPORKAN RKPD',
        color:'green',
        data: <?php echo json_encode($data_chart['melapor']) ?>
    },
    {
        name: 'DAERAH TIDAK MELAPORKAN RKPD',
        color:'red',
        data:<?php echo json_encode($data_chart['tidak_melapor']) ?>
    }]
});
</script>

@stop