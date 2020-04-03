<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>DSS</title>
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
		<style media="screen">
			body{
				background: rgb(34,193,195);
	background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(253,187,45,1) 100%);
			}
		</style>
		    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>

	</head>
	<body style="">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>APLIKASI SINKRONISASI</h3>
				<hr>
			<img src="{{asset('logo.png')}}" style="max-width: 70px;">
			<h5><b>BANGDA KEMENDAGRI</b></h5>

			</div>
			<div class="col-md-4 col-md-offset-4">

				<div class="box box-warning" style="margin-top:20px;">

					<div class="box-body text-center">

								
								<h1 id="count"></h1>
								<p><b>REFRESING..</b></p>



					</div>
					<div class="box-footer text-center">
						

					</div>


				</div>

			</div>

		</div>
	</body>
</html>
<script type="text/javascript">

localStorage.local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh=Date();

count=3;

function coun_down(){

	setTimeout(function(){
		if(count<=0){
			window.location.href='{{$url?$url:url('')}}';
		}else{
			count-=1;
			$('#count').html(count);
			coun_down()
		}
	},1000);

}

coun_down();



</script>