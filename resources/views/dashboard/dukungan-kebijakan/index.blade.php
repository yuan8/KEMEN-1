@extends('adminlte::page_dashboard')


@section('content_header')

  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_11.js')}}"></script>
@stop


@section('content')
<h1 class="text-center"><b>DUKUNGAN KEBIJAKAN PUSAT KE DAERAH</b></h1>
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
								<th>JUMLAH KEBIJAKAN TERIMPLEMENTASI</th>
								<th>JUMLAH KEBIJAKAN BELUM TERIMPLEMENTASI</th>
								<th>ACTION</th>





							</tr>
						</thead>
						<tbody>
							<tr>
								<td>PROVINSI ACEH</td>
								<td>7</td>
								<td>11</td>
								<td>
									<a href="{{route('v.kebijakan.detail',['tahun'=>$tahun,'kodepemda'=>11])}}" class="btn btn-success btn-sm">Detail</a>
								</td>



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
                    text: 'KESUSUAIAN KEBIAJAKAN PUSAT TINGKAT PROVINSI',
                    style:{
                        color:'#222'
                    },
                    enabled:false
                },
                 colorAxis: {
                    min: 0,
                    max: 150	,
                    tickInterval: 5,
                    stops: [[0, '#F1EEF6'], [0.65, '#900037'], [1, '#500007']],
                    labels: {
                        format: '{value} RKPD',

                    }
                },
        
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    floating: true,
                    backgroundColor: ( // theme
                        Highcharts.defaultOptions &&
                        Highcharts.defaultOptions.legend &&
                        Highcharts.defaultOptions.legend.backgroundColor
                    ) || 'rgba(255, 255, 255, 0.85)'
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
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':12,
					    	'name':'namaa point',
					    	'value':21,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':13,
					    	'name':'namaa point',
					    	'value':34,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':14,
					    	'name':'namaa point',
					    	'value':1,
					    	
					    	'tooltip':''
					    }, {
					    	'id':15,
					    	'name':'namaa point',
					    	'value':56,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':16,
					    	'name':'namaa point',
					    	'value':2,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':17,
					    	'name':'namaa point',
					    	'value':45,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':18,
					    	'name':'namaa point',
					    	'value':32,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':19,
					    	'name':'namaa point',
					    	'value':32,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':21,
					    	'name':'namaa point',
					    	'value':34,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':31,
					    	'name':'namaa point',
					    	'value':7,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':32,
					    	'name':'namaa point',
					    	'value':78,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':33,
					    	'name':'namaa point',
					    	'value':100,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':34,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':35,
					    	'name':'namaa point',
					    	'value':87,
					    	
					    	'tooltip':''
					    },
					    {
					    	'id':36,
					    	'name':'namaa point',
					    	'value':43,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':51,
					    	'name':'namaa point',
					    	'value':21,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':52,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':53,
					    	'name':'namaa point',
					    	'value':12,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':61,
					    	'name':'namaa point',
					    	'value':14,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':62,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':63,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':64,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':71,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':72,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':73,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':74,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':75,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':76,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					      {
					    	'id':81,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':82,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':91,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':92,
					    	'name':'namaa point',
					    	'value':123,
					    	
					    	'tooltip':''
					    },
					     {
					    	'id':65,
					    	'name':'namaa point',
					    	'value':123,
					    	
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
        text: 'KESUSUAIAN KEBIAJAKAN PUSAT TINGKAT KAB/KOTA'
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
        name: 'KEBIJAKAN DAERAH SUDAH TERIMPLEMENTASI',
        color:'green',
        data: [5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3, 2,5, 2, 1, 3]
    },
    {
        name: 'KEBIJAKAN DAERAH BELUM TERIMPLEMENTASI',
        color:'red',
        data: [3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1, 9,3, 3, 4, 1]
    }]
});
</script>

@stop