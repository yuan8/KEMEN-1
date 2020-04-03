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
								<form action="{{url('meta-login-user')}}" method="post">

					<div class="box-body text-center">

								<h4 id="ww">Selamat Datang "<b class="text-uppercase">{{$agent->name}}</b>"</h4>
									@csrf

									<select name="tahun" class="form-control">
										   @foreach(Hp::pilihan_tahun() as $i)

								                            <option value="{{$i}}" {{date('Y')==$i?'selected':''}}>{{$i}}</option>
								            @endforeach
									</select>
									<br>


					</div>
					<div class="box-footer text-center">
							<button class="btn btn-warning" type="submit">Masuk</button>

					</div>
					</form>


				</div>

			</div>

		</div>
	</body>
</html>
<script type="text/javascript">
navigator.getBattery().then(function(battery) {
	console.log(battery);
});


 var synth = window.speechSynthesis;

// var inputForm = document.querySelector('form');

function speak(msg){
var utterThis = new SpeechSynthesisUtterance(msg);

if (synth.speaking) {
  console.error('speechSynthesis.speaking');
  return;
}

synth.speak(utterThis);

}




</script>