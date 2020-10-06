@if (Session::has('alert.config'))
    @if(config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif
    <script src="{{ $cdn?? asset('vendor/sweetalert/sweetalert.all.js')  }}"></script>
    <script>
    $(function(){
		setTimeout(function(){
   	 		Swal.fire({!! Session::pull('alert.config') !!});

			},1200);
	});
    </script>
@endif

<style type="text/css">
	#opening{
		display: block;
	}

	.opening {
		display: block!important;
	    opacity: 1;
	    -webkit-transition: opacity 800 linear;
	    transition: opacity 800ms linear;
	    z-index: 9;
	    position: fixed; z-index: 99999; width: 100vw; height: 100vh; background: #fff;
	    top:0;
	    left: 0;
	}



</style>
<script type="text/javascript" src="{{asset('vendor/custome/cookie.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var slugDSSPAGEID='{{url()->full()}}';
		slugDSSPAGEID=slugDSSPAGEID.toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'');
        console.log('slug = '+slugDSSPAGEID);
        console.log('slug-in = '+$.cookie("_scrollDSS"));

	if($.cookie('_scrollDSS')==undefined){
	    	 $.cookie("_scrollDSS", 'init' );

	}
    console.log($.cookie("_scrollDSS") != slugDSSPAGEID);


    if(($.cookie("_scrollDSS") != slugDSSPAGEID)) {
		 removeTarget=$('#opening');
		 removeTarget.addClass('opening');

		setTimeout(function(){
		
			$('#opening').css('opacity',0);
		},300);

		 setTimeout(function(){$('#opening').remove(); $.cookie("_scrollDSS", slugDSSPAGEID );  console.log("remove"); }, 1200); 
    	;

    }else{
		 $('#opening').removeClass('opening');

    	 $.cookie("_scrollDSS", slugDSSPAGEID );
    	 $('#opening').remove();
    }

		
});
</script>
<div id="opening" class="opacity text-center">
	<img src="{{asset('logo.png')}}" style="max-width:100px; position: absolute; top:0; bottom:0; left:0; right: 0; margin:auto;" >
</div>

