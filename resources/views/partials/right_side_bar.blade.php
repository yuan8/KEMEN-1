


<h5 class="text-uppercase text-center">Pilih Urusan</h5>
<div class="col-md-12">
	<ul class="list-group">
		<?php 
			$pl_urusan=Hp::pilihan_urusan();
		?>
	  @foreach($pl_urusan['data'] as $key =>$u)
	  	<li onclick="{{$key==$pl_urusan['id_fokus']?'javascript:void(0)':"pindahUrusan(`".$u."`);".'window.location=`'.route('init.pindah_urusan',['id'=>$key]).'`'}}"  class="text-dark list-group-item cursor-link" ><span><i class="  fa-circle  {{$key==$pl_urusan['id_fokus']?'fa text-primary':'far fa-fw'}}"></i> </span> <span>{{$u}}</span></li>
	  @endforeach

	  
	</ul>
</div>