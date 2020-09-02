<script src="https://unpkg.com/inputmask@4.0.4/dist/inputmask/dependencyLibs/inputmask.dependencyLib.js"></script>
<script src="https://unpkg.com/inputmask@4.0.4/dist/inputmask/inputmask.js"></script>
<script src="https://unpkg.com/inputmask@4.0.4/dist/inputmask/inputmask.date.extensions.js"></script>

@php
	$domid='dom'.date('s');
@endphp

<form action="{{route('monev.update.progres.commit')}}" method="post">
@csrf
	<div class="box box-danger">
            <div class="box-body">
			<div class="form-group">
                  <label>Progres Capaian(%)</label>
                  <input type="number" required="required" class="form-control" name="progres" placeholder="Masukan Progres dalam persen" value="{{$progres}}">
                </div>
				
			<div class="form-group">
                  <label>Permasalahan Pencapaian</label>
                  <textarea class="form-control" rows="3" name="permasalahan" placeholder="Masukan Permasalahan" >{{$permasalahan}}</textarea>
                </div>	
            <div class="form-group">
                  <label>Tindak Lanjut</label>
                  <textarea class="form-control" rows="3" name="tindak_lanjut" placeholder="Rencana Tindak Lanjut" >{{$tindak_lanjut}}</textarea>
                </div>	
			<div class="form-group">
                <label>Date masks:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                   </div>
                  <input id="input" type="date" name="tanggal" class="form-control" data-inputmask="'mask': '99/99/9999', 'placeholder': 'mm/dd/yyyy'" data-mask="" value="{{$tanggal}}">
                </div>
                <!-- /.input group -->
              </div>	
             <!-- Date dd/mm/yyyy -->
			 
            </div>
			<div class="form-group"  align="center">
			 <button type="submit" class="btn btn-success btn-xm">simpan</button>
			 </div>
              <!-- /.form group -->
    </div>
            <!-- /.box-body -->
 <input name="id_progres" value="{{$id}}" hidden></input>

</form>
