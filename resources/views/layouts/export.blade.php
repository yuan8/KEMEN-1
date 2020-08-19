<!DOCTYPE html>
<html>
<head>
	<title>@if(isset($title)) {{$title}} @else INTEGRASI {{$daerah['nama']}} - {{Hp::fokus_tahun()}} @endif</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.css')}}">

	<style type="text/css">
	@media print {
	    @page {
	      margin: 2.5cm;   
	    }
	    div.row > div {
	      display: inline-block;  
	      border: solid 1px #ccc;
	      margin: 0.2cm;
	    }
	    div.row {
	      display: block;
	    }
	}
	td,th{
		vertical-align: middle!important;
	}

	td,th,tr{
	    border: 1px solid  #ddd!important;
	    font-size: 16px;
	}
	/*

	.table {
	    display: table;
	    border-spacing: 2px;
	}
	.row {
	    display: table-row;
	}
	.row > div {
	    display: table-cell;
	    border: solid 1px #ccc;
	    padding: 2px;
	}*/
	</style>
</head>
<body>
@yield('content')
</body>
</html>