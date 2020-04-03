<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>

<body>

	<div class="" style="display: none;">{!!$content!!}}</div>
</body>



<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


<script type="text/javascript" src="{{asset('vendor/custome/fd.js')}}"></script>
<script type="text/javascript">
	
	function download(data,name){
		$.fileDownload('{{route('bot.simspam.download')}}',{
  				preparingMessageHtml: name+" Wait...",
		        failMessageHtml: "There was a problem generating your report, please try again.",
		        httpMethod: "POST",
		        data: {'data':data,'name':name},
		         successCallback: function (url) {
 
                	$preparingFileModal.dialog('close');
            	}
		       
		});

	}
	

</script>

<style type="text/css">
	*{
		color:#222;
	}
</style>
@include('bot.simspam.download')


@yield('content')

@if(isset($loop))

	<script type="text/javascript">
		function next(url){

			window.location.href=url;

		}


	</script>

@else
	<script type="text/javascript">
		function next(url){
			console.log('job done');
		}

	</script>


@endif

</html>