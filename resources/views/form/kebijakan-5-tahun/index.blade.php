@extends('adminlte::page')


@section('content_header')
     <div class="row">
    	<div class="col-md-8">
    		<h3 class="text-uppercase">IDENTIFIKASI KEBIJAKAN 5 TAHUNAN ({{$rpjmn['start']}} -  {{$rpjmn['finish']}})</h3>
    		
    	</div>
    	
    </div>
@stop


@section('content')
<div class="box box-solid bg-yellow-gradient">
	<div class="box-body ">

		<a href="{{route('kebijakan.pusat.5.tahun.create')}}" class="btn btn-success btn-xs text-uppercase">Tambah Kondisi saat ini</a>
		<a href="" class="btn btn-success btn-xs text-uppercase">DWONLOAD DATA</a>

	</div>
</div>
<hr>
<div class="box box-solid ">
	<div class="box-header with-border">
		<h5>DATA TERKAIT IDENTIFIKASI KEBIJAKAN PUSAT 5 TAHUNAN {{HP::fokus_urusan()['nama']}}</h5>
		
	</div>
	<div class="box-body">
		<div id="table-tabul"></div>
		<table class="table table-bordered table-striped" id="table-data">
			<thead>
				<tr>
					<th>KODE</th>
					<th>KODISI SAAT INI</th>
					<th>ISU STRATEGIS</th>
					<th>ARAH KEBIJAKAN</th>
					<th>INDIKATOR</th>
					<th>TARGET</th>
					<th>SATUAN</th>
					<th>KEWENANGAN</th>

				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>

@stop


@section('js')


<script type="text/javascript">
	//define data
var tabledata = [
    {id:1, name:"Oli Bob", location:"United Kingdom", gender:"male", rating:1, col:"red", dob:"14/04/1984"},
    {id:2, name:"Mary May", location:"Germany", gender:"female", rating:2, col:"blue", dob:"14/05/1982"},
    {id:3, name:"Christine Lobowski", location:"France", gender:"female", rating:0, col:"green", dob:"22/05/1982"},
    {id:4, name:"Brendon Philips", location:"USA", gender:"male", rating:1, col:"orange", dob:"01/08/1980"},
    {id:5, name:"Margret Marmajuke", location:"Canada", gender:"female", rating:5, col:"yellow", dob:"31/01/1999"},
    {id:6, name:"Frank Harbours", location:"Russia", gender:"male", rating:4, col:"red", dob:"12/05/1966"},
    {id:7, name:"Jamie Newhart", location:"India", gender:"male", rating:3, col:"green", dob:"14/05/1985"},
    {id:8, name:"Gemma Jane", location:"China", gender:"female", rating:0, col:"red", dob:"22/05/1982"},
    {id:9, name:"Emily Sykes", location:"South Korea", gender:"female", rating:1, col:"maroon", dob:"11/11/1970"},
    {id:10, name:"James Newman", location:"Japan", gender:"male", rating:5, col:"red", dob:"22/03/1998"},
];

//define table
var table = new Tabulator("#table-tabul", {
    data:tabledata,
    autoColumns:true,
});


	var table1=$('#table-data').DataTable({
		sort:false,
		columns:[
			{
				render:function(){
					return ''
				}
			},
			{
				data:'uraian_ksi'
			},
			{
				data:'uraian_ksi'
			},
			{
				data:'uraian_ksi'
			},
			{
				data:'uraian_ksi'
			},
			{
				data:'uraian_ksi'
			},
			{
				data:'uraian_ksi'
			},
			{
				data:'uraian_ksi'
			}

		]
	});



	table1.rows.add(<?php echo json_encode($data) ?>).draw();




</script>
  

@stop