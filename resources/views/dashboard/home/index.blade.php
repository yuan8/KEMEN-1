@extends('adminlte::page_dashboard')


@section('content_header')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/highcharts/css/highcharts.css')}}">
  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_11.js')}}"></script>
@stop


@section('content')
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
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>NAMA PEMDA</th>
								<th>JUMLAH PROGRAM</th>
								<th>JUMLAH KEGIATAN</th>
								<th>PAGU</th>





							</tr>
						</thead>
						<tbody>
							<tr>
								<td>PROVINSI ACEH</td>
								<td>7</td>
								<td>11</td>
								<td>Rp. 300,0000,0000</td>



							</tr>
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
		map_init=Highcharts.mapChart('map', {
                chart: {
                    backgroundColor: 'transparent',
                },
                title: {
                    text: 'RKPD 2020',
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
					    data: [
					    {
					    	'id':11,
					    	'name':'namaa point',
					    	'value':1,
					    	'color':'red',
					    	'tooltip':''
					    },
					    {
					    	'id':12,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					    {
					    	'id':13,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					     {
					    	'id':14,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    }, {
					    	'id':15,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					    {
					    	'id':16,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					     {
					    	'id':17,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					    {
					    	'id':18,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					    {
					    	'id':19,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					    {
					    	'id':21,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					    {
					    	'id':31,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					     {
					    	'id':32,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					     {
					    	'id':33,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					     {
					    	'id':34,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					    {
					    	'id':35,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					    {
					    	'id':36,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					     {
					    	'id':51,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					     {
					    	'id':52,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':53,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':61,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':62,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':63,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':64,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					      {
					    	'id':71,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':72,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					      {
					    	'id':73,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':74,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':75,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':76,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					      {
					    	'id':81,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					     {
					    	'id':82,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					     {
					    	'id':91,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'red',
					    	'tooltip':''
					    },
					     {
					    	'id':92,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					     {
					    	'id':65,
					    	'name':'namaa point',
					    	'value':123,
					    	'color':'green',
					    	'tooltip':''
					    },
					    ],
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


Highcharts.chart('chart', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'RKPD 2020'
    },
    xAxis: {
        categories: ['PROVINSI ACEH', 'PROVINSI SUMATRA UTARA', 'PROVINSI SUMATRA BARAT', 'PROVINSI RIAU', 'PROVINSI JAMBI','PROVINSI SUMATRA SELATAN','PROVINSI BENGKULU','PROVINSI LAMPUNG','PROVINSI KEPULAUAN BANGKABELITUNG','PROVINSI KEPULAUAN RIAU','PROVINSI DKI JAKARTA','PROVINSI JAWA BARAT','PROVINSI JAWA TENGAH','DAERAH ISTIMEWA YOGYAKARTA','PROVINSI JAWA TIMUR','PROVINSI BANTEN','PROVINSI BALI','PROVINSI NUSA TENGGARA BARAT','PROVINSI NUSA TENGGARA TIMUR','PROVINSI KALIMANTAN BARAT','PROVINSI KALIMANTAN TENGAH','PROVINSI KALIMANTAN SELATAN','PROVINSI KALIMANTAN TIMUR','PROVINSI SULAWESI UTARA','PROVINSI SULAWESI TENGAH','PROVINSI SULAWESI SELATAN','PROVINSI SULAWESI TENGGARA','PROVINSI GORONTALO','PROVINSI SULAWESI BARAT','PROVINSI MALUKU','PROVINSI MALUKU UTARA','PROVINSI PAPUA BARAT','PROVINSI PAPUA','PROVINSI KALIMANTAN UTARA']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total fruit consumption'
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
        data: [5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3]
    },
    {
        name: 'DAERAH TIDAK MELAPORKAN RKPD',
        color:'red',
        data: [3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1]
    }]
});
</script>

@stop