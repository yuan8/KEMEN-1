@extends('adminlte::page_dashboard')


@section('content_header')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/highcharts/css/highcharts.css')}}">
  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_11.js')}}"></script>
@stop


@section('content')
<h1 class="text-center"><b>RKPD PROVINSI ACEH  </b></h1>
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
		<label>URUSAN</label>
		<select class="form-control">
			<option>SEMUA</option>
			
		</select>
	</div>
</div>
</div>
<div class="row" style="margin-bottom: 10px;">

	<div class="col-md-12" id="chart" style="background: #fff; height: 400px;">
		
	</div>
	
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-body">
					<table class="table table-bordered">
						
						<tbody>
							<tr>
								<td>PERKERJAAN UMUM</td>
								<td>7</td>
								<td>11</td>
								<td>Rp. 300,0000,0000</td>
								<td>AKSI</td>
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



// ------


Highcharts.chart('chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'PELAPORAN RKPD PROVINSI ACEH'
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