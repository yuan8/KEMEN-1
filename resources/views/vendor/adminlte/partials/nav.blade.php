
<li class="dropdown ">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		DASHBOARD
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li class="">
        	<a href="{{route('pp.index')}}">
            	<i class="far fa-circle "></i>
            		STATUS DATA RKPD
            </a>
    	</li>
    	<!--  <li class="">
        	<a href="{{route('pp.urusan')}}">
            	<i class="far fa-circle "></i>
            		URUSAN DALAM RKPD
            </a>
    	</li> -->
    </ul>
</li>

<li class="nav-item dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        PROGRAM KEGIATAN
        <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        <li class="">
             <a href="{{url('program-kegiatan-urusan')}}">PROGRAM KEGIATAN PER URUSAN</a>
          
        </li>
       <li class="nav-item">
            <a href="{{url('program-kegiatan-daerah')}}">PROGRAM KEGIATAN PER DAERAH</a>
        </li>

    </ul>
</li>
<li class="nav-item">
    <a href="{{route('pad.index')}}">PAD</a>
</li>



<li class="nav-item dropdown-submenu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        RAKORTEK 2021
        <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">

         <li class="nav-item">
            <a href="{{route('front.r.index')}}">INDIKATOR KINERJA URUSAN PERDAERAH</a>
        </li>
         <li class="nav-item">
            <a href="{{route('front.r.iku_perurusan')}}">INDIKATOR KINERJA URUSAN PERURUSAN</a>
        </li>
        
         <li class="nav-item">
            <a href="{{route('front.r.perba.index')}}">KAWASAN PERBATASAN NEGARA</a>
        </li>

    </ul>
</li>

