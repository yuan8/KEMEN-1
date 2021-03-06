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
	      background: transparent!important;
	    }

	    html,body,table{
			background: transparent!important;
		}

		.table-data thead{
			background: #f1f1f1!important;
		}
	    div.row > div {
	      display: inline-block;  
	      border: solid 1px #ccc;
	      margin: 0.2cm;
	    }
	    div.row {
	      display: block;
	    }
	   
		  li:not(:first-child){
		    border-top:1px dashed #ddd;
		}

		ul, ol {
	    margin-top: 0;
	    margin-bottom: 0px;
	    list-style: none;
	    padding-inline-start: 0px!important;
		
		}

		.page-break {
	    	page-break-after: always!important;
		}

		tr.table-page-break{
		
	    	page-break-before: always!important;

		}
		 tr.page-break  { display: block; page-break-before: always; }
	}

	li:not(:first-child){
	    border-top:1px dashed #ddd;
	    margin-top: 5px;
	}
	

	.table-data thead{
		background: #f1f1f1;
	}

	ul, ol {
	    margin-top: 0;
	    margin-left: 0px;
	    margin-bottom: 0px;
	    list-style: none;
	    padding-inline-start: 0px;
	}

	td,th{
		vertical-align: middle!important;
	}

	.table-data td, .table-data th{
	    border: 1px solid  #ddd!important;
	    font-size: 7px;
		background: transparent;

	}

	html,body,table{
		background: transparent!important;
	}

	.page-break {
    	page-break-after: always!important;
	}
	
	tr.table-page-break{
	
    	page-break-before: always!important;

	}
	 tr.page-break  { display: block; page-break-before: always; }

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
	.bg-gray{
		background-color: #f1f1f1!important;
	}
	</style>

</head>
<body>
<script type="text/php">
	    if (isset($pdf)) {
	        $x = 770;
	        $y = 10;
	        $text = "Halaman {PAGE_NUM} / {PAGE_COUNT}";
	        $font = null;
	        $size = 6;
	        $color = array(0,0,0);
	        $word_space = 0.0;  //  default
	        $char_space = 0.0;  //  default
	        $angle = 0.0;   //  default
	        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
	    }
</script>
@yield('content')
</body>
</html>