@extends('adminlte::page_dashboard')


@section('content_header')
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/highcharts/css/highcharts.css')}}">
  <script type="text/javascript" src="{{asset('bower_components/highcharts/highmaps.js')}}"></script>

<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/ind.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/ind/kota.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/L_MAP/idn_11.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-treetable/css/jquery.treetable.theme.default.css')}}">
<script type="text/javascript" src="{{asset('bower_components/jquery-treetable/jquery.treetable.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('bower_components/jquery-ui/jquery-ui.js')}}">
<link rel="stylesheet" type="text/css" href="{{asset('tree-level-dist/tree/style.css')}}">
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
					<table class="table table-bordered table-hover" id="data-table">
						<thead>
							<tr>
								<th style="width: 150px;"></th>
								<th></th>
							</tr>
						</thead>
						<tbody>

							@foreach($data as $d)
								<tr data-tt-id="kn-{{$d['id']}}" class="">
									<td class="tree">
										<div class="t-root"></div>
									</td>
									<td>
										<div class="content-tree">{!!nl2br($d['uraian'])!!}</div>
									</td>
								</tr>
								@foreach($d['_children'] as $isu)
									<tr data-tt-id="isu-{{$isu['id']}}" data-tt-parent-id="kn-{{$isu['id_kondisi']}}">
											<td class="tree">
												<div class="t-cpb"></div>
												<div class="t-cn"></div>
											</td>
										<td><div class="content-tree">{!!nl2br($isu['uraian'])!!}</div></td>
									</tr>
									@foreach($isu['_children'] as $ak)
										<tr data-tt-id="ak-{{$ak['id']}}" data-tt-parent-id="isu-{{$ak['id_isu']}}">
											<td class="tree">
												<div class="t-b"></div>
			<div class="t-cpb"></div>
			<div class="t-cn"></div>
											</td>
											<td>
												<div class="content-tree"> 
													<table class="table table-bordered">
														<tr>
															<td>ANU</td>
															<td>ABU</td>
														</tr>
													</table>
												</div>
											</td>
										</tr>
									@endforeach
								@endforeach

							@endforeach
							
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

	tr td div.content-tree{
		display: inline-block!important;
	}
	tr td span.indenter{
		display: inline-block!important;
	}	
	table.treetable tr.branch{
		background: unset;
	}

table tr td.tree{
	vertical-align:middle;
	text-align: left;

}
</style>
<script type="text/javascript">
	$("#data-table").treetable({ expandable: true,column:1 });



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