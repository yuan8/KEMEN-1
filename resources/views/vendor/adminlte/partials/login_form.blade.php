  <style type="text/css">
    body{
      background: linear-gradient(353deg, rgba(34,193,195,1) 5%, rgba(253,187,45,1) 30%) !important;
    }
    .icheck-success>input:first-child+label::before {
    background-color: #222;
    }
   </style>
   <div class="col-md-4 col-md-offset-2">
        <script type="text/javascript">
        var fingerprint='{{$fingerprint}}';
            
        </script>
        @if(!Auth::check())
             <div class="login-box-body" style="background: transparent !important;">

            <p class="login-box-msg">
            </p>
            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                {{ csrf_field() }}

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <select class="form-control" name="tahun">
                        @foreach(Hp::pilihan_tahun() as $i)

                            <option value="{{$i}}" {{date('Y')==$i?'selected':''}}>{{$i}}</option>
                        
                        @endforeach
                    </select>
                    
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="icheck-success">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember" style="color: #222"><b>{{ trans('adminlte::adminlte.remember_me') }}</b></label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-default btn-block btn-flat">
                            {{ trans('adminlte::adminlte.sign_in') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <br>
            <p>
              <!--   <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}" class="text-center">
                    {{ trans('adminlte::adminlte.i_forgot_my_password') }}
                </a> -->
            </p>
           <!--  @if (config('adminlte.register_url', 'register'))
                <p>
                    <a href="{{ url(config('adminlte.register_url', 'register')) }}" class="text-center">
                        {{ trans('adminlte::adminlte.register_a_new_membership') }}
                    </a>
                </p>
            @endif -->
        </div>

        @endif
    </div>
    <div class="col-md-3 text-center hidden-sm hidden-xs" style="padding-right:50px;" id="barcode_content">
        {!!$barcode!!}
        <h5 class="text-center"><b>Login Cepat : <span id="id_check_count"></span></b></h5>
         <button class="btn btn-sm btn-warning" onclick="refresh_token()">REFRESH TOKEN</button>
    </div>


    <script>

  var barcode_html=$('#barcode_content').html();
 var synth = window.speechSynthesis;
var utterThis='';
// var inputForm = document.querySelector('form');

function speak(msg){
  utterThis= new SpeechSynthesisUtterance(msg);

  utterThis.lang='id-ID';
  utterThis.rate=1.2;

if (synth.speaking) {
  console.error('speechSynthesis.speaking');
  return;
}

synth.speak(utterThis);

}

  var count_check=30;
  function checkLoginBarcode(key){

     if(count_check>0){
       

      }else{
        removeBarcode();
      }

    $.post('{{url('api/check_login_barcode')}}',{'key':key},function(res){
      if(res.code==100){
        var isChrome = !!window.chrome ;

        if(isChrome){
        speak('Selamat datang '+res.message);

      }else{
        speak('Login Valid');

        // speak('Authentication is Valid, wait process');

      }
         utterThis.onend = function (event) {
          window.location.href=('{{url('home')}}');
        }

      }else{
         setTimeout(function(){
              if(count_check>0){
                count_check-=1;
                $('#id_check_count').html(count_check+' s');
                 checkLoginBarcode(fingerprint);

              }else{
                removeBarcode();
              }
         },1000);
      }
    });

  }

  function removeBarcode(){
    var barcode_html=$('#barcode_content').html();

    $('#barcode_content').html('<img src="{{asset('token.png')}}" class="img-responsive cursor-link" onclick="refresh_token()">');
  }

  function refresh_token(){
    count_check=30;

    $.post('{{route('br.login.update.token')}}',{key:fingerprint},function(res){
       if(res.code==100){
        window.location.href=('{{url('meta-login-user').'?tahun='}}'+(new Date().getFullYear()));
      }else{
        barcode_html=res.data+'<h5 class="text-center"><b>Login Cepat : <span id="id_check_count"></span></b></h5> <button class="btn btn-sm btn-default bg-dark" onclick="refresh_token()">REFRESH TOKEN</button>';
        
    
        fingerprint=res.fingerprint;
         $('#barcode_content').html(barcode_html);
        checkLoginBarcode(fingerprint);
      }
    });


   
  }

    @if(Auth::User())
      
    @else
    count_check=0;
    checkLoginBarcode(fingerprint);
    @endif


</script>