@php
	$domid='dom'.date('s');
@endphp
		
		
<form action="{{route('prokeg.tambah.sasaran')}}" method="post">
	@csrf
<div class="modal-content">	
<div class="modal-header text-center"><h4 class="text-uppercase"></h4></div>
<div class="modal-body">	
<input name="kodepemda" value="{{$id}}" hidden></input>
Sasaran
<textarea required="required" name="uraian" class="form-control" style="min-height: 150px;"></textarea></div> <div class="form-group"><label class="checkbox-inline" style="min-width: 100px;">
</div>
<div class="modal-footer"><button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-times-circle"></i> Tutup</button> <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-pen"></i> Update</button></div>
</div>
</form>

