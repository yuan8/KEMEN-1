<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('ltefron.title_prefix', ''))
@yield('title', config('ltefron.title', 'DSS'))
@yield('title_postfix', config('ltefron.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="icon" href="{{asset('icon.png')}}">
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/vendor/vue/vue.js') }}"></script>
    <script src="{{ asset('/vendor/vue/vue-select.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('/vendor/vue/vue-select.css')}}">
    <script type="text/javascript">
        Vue.component('v-select', VueSelect.VueSelect);
    </script>

    <script type="text/javascript" src="{{asset('vendor/custome/js.js?v='.((env('DEV')==true) ?date('ymdhis'):'1.1') )}}"></script>

    <link rel="manifest" type="text/css" href="{{asset('manifest.json')}}">

    @include('adminlte::plugins', ['type' => 'css'])

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/custome/cs.css?v='.((env('DEV')==true) ?date('ymdhis'):'1.1') ) }}">
    <link rel="stylesheet" href="{{ asset('vendor/custome/animated.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/custome/checkbox.css') }}">

    <script type="text/javascript" src="{{asset('vendor/custome/axios.js')}}"></script>

    <script type="text/javascript">

    const TOKEN_KN='{{(Auth::User())?'Bearer '.Auth::User()->api_token:''}}';

    const API_CON = axios.create({
          timeout: 6000,
          headers: {
            'Authorization': TOKEN_KN,
            'Content-Type': 'application/json',
          }
    });



  </script>




    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition @yield('body_class')">

@yield('body')

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
<script type="text/javascript" src="{{url('vendor/Datatable/datatables.js')}}"></script>

@include('adminlte::plugins', ['type' => 'js'])

@yield('adminlte_js')


@include('sweetalert::alert')

<script type="text/javascript">
   function buildNum(){
     $('.val_check_type').each(function(key,dom){
        var t=$(dom).text().trim()!=''?$(dom).text().trim():'';

        if(((t!=null)&&(t!=''))){

            if(isNaN(t)==false){
                t=parseFloat(t);
                $(dom).html(new Intl.NumberFormat('de-DE', { }).format(t));
                $(dom).removeClass('val_check_type');

            }
        }
       

     });


   }
     buildNum();

    $('html').on('load',buildNum());
    var localy_trigger_refresh=localStorage.getItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh');

    $(window).on("storage", function(e) {
    var event = e.originalEvent; // Get access to the storage-specifics
    if (event.key == "local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh") { // Or whatever
        // Do something with event.newValue
        if(localy_trigger_refresh!=localStorage.getItem('local_{{str_replace('.','_',$_SERVER['HTTP_HOST'])}}_dss_tab_info_refresh')){
            window.location.reload();
        };
    }
    });

window.addEventListener("message", receiveMessage, false);

function receiveMessage(event) {
  if (event.origin == "http://localhost"){
     // console.log('message kenek'); 
    console.log(event);

  }
  return ;
    

}



// var inputForm = document.querySelector('form');

var utterThis='';
// var inputForm = document.querySelector('form');

function speak(msg){
 var synth = window.speechSynthesis;

  utterThis= new SpeechSynthesisUtterance(msg);

  utterThis.lang='id-ID';
  utterThis.rate=1.2;

if (synth.speaking) {
  console.error('speechSynthesis.speaking');
  return;
}

synth.speak(utterThis);

}

function pindahTahun(tahun=null){

    if(!!window.chrome){
        speak('Tahun di pindahkan '+tahun);
    }else{
        speak(''+tahun);

    }
}

function pindahUrusan(tahun=null){

    if(!!window.chrome){
        speak('Urusan di pindahkan '+tahun);
    }else{
        // speak(''+tahun);

    }
}


</script>



<div class="modal fade " id="modal-pindah-tahun-fokus">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{route('init.tahun')}}" method="post">

                    <div class="box-body text-center">


                    </div>
                    <div class="box-footer text-center">
                            <button class="btn btn-warning" onclick='pindahTahun($("#pilihan-pindah-tahun").val())' type="submit">PINDAH</button>

                    </div>
                    </form>
        </div>
    </div>
</div>
</body>
</html>
