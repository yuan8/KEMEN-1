<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DSS</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      
        <script src="{{ asset('/vendor/vue/vue.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('vendor/custome/menus.css')}}">

        <link rel="stylesheet" type="text/css" href="{{asset('vendor/custome/menus.css')}}">
        <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/custome/p5.min.js') }}"></script>
        <script src="{{ asset('vendor/custome/vanta.typo.js') }}"></script>







</head>
<style type="text/css">

</style>
<body >
<div id='back' style="position: absolute; width: 100%; height: 100vh; top:0; z-index: 1;"></div>
		
<div class="" style="z-index: 9999; position: absolute; width: 100%; height: 100vh;">
<h1 class="title">DATA SUPPORT SYSTEM</h1>
<div class="col-md-12">

</div>

<div id="app" class="container">
  <a href="{{route('sinkron-home')}}">
    <card data-image="{{asset('vendor/custome/sink.png')}}" >
    <h1 slot="header">Sinkronisasi</h1>
    <p slot="content">Penyelarasan Perencanaan Pusat Daerah</p>
  </card>
  </a>
   <a href="{{url('bangda')}}">
     <card data-image="{{asset('vendor/custome/spm.png')}}" >
    <h1 slot="header">SPM</h1>
    <p slot="content">Capian SPM PAMSIMAS</p>
  </card>
   </a>
  <a href="http://nuwas.dssapp.xyz/v">
    <card data-image="{{asset('vendor/custome/nuwsp.png')}}">
    <h1 slot="header">NUWSP</h1>
    <p slot="content"></p>
  </card>
  </a>

 <a href="http://support.nuwsp.xyz">
    <card data-image="https://images.unsplash.com/photo-1479621051492-5a6f9bd9e51a?dpr=2&auto=compress,format&fit=crop&w=1199&h=811&q=80&cs=tinysrgb&crop=">
    <h1 slot="header">NUWSP SUPPORT DATA</h1>
    <p slot="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
  </card>
    
 </a>
</div>

</div>


  
</body>
<script type="text/javascript">


  Vue.config.devtools = true;

Vue.component('card', {
  template: `
    <div class="card-wrap"
      @mousemove="handleMouseMove"
      @mouseenter="handleMouseEnter"
      @mouseleave="handleMouseLeave"
      ref="card">
      <div class="card"
        :style="cardStyle">
        <div class="card-bg" :style="[cardBgTransform, cardBgImage]"></div>
        <div class="card-info">
          <slot name="header"></slot>
          <slot name="content"></slot>
        </div>
      </div>
    </div>`,
  mounted() {
    this.width = this.$refs.card.offsetWidth;
    this.height = this.$refs.card.offsetHeight;
  },
  props: ['dataImage'],
  data: () => ({
    width: 0,
    height: 0,
    mouseX: 0,
    mouseY: 0,
    mouseLeaveDelay: null
  }),
  computed: {
    mousePX() {
      return this.mouseX / this.width;
    },
    mousePY() {
      return this.mouseY / this.height;
    },
    cardStyle() {
      const rX = this.mousePX * 30;
      const rY = this.mousePY * -30;
      return {
        transform: `rotateY(${rX}deg) rotateX(${rY}deg)`
      };
    },
    cardBgTransform() {
      const tX = this.mousePX * -40;
      const tY = this.mousePY * -40;
      return {
        transform: `translateX(${tX}px) translateY(${tY}px)`
      }
    },
    cardBgImage() {
      return {
        backgroundImage: `url(${this.dataImage})`
      }
    }
  },
  methods: {
    handleMouseMove(e) {
      this.mouseX = e.pageX - this.$refs.card.offsetLeft - this.width/2;
      this.mouseY = e.pageY - this.$refs.card.offsetTop - this.height/2;
    },
    handleMouseEnter() {
      clearTimeout(this.mouseLeaveDelay);
    },
    handleMouseLeave() {
      this.mouseLeaveDelay = setTimeout(()=>{
        this.mouseX = 0;
        this.mouseY = 0;
      }, 1000);
    }
  }
});

const app = new Vue({
  el: '#app'
});


VANTA.TOPOLOGY({
  el: "#back",
mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
  color: 0x4072e8,
  backgroundColor: 0xffffff
})




</script>
</html>
