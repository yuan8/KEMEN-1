
  <div class="modal fade" id="update_kesesuian">
    <div class="modal-dialog">
        <form v-bind:action='action' method="post">
          @method('PUT')
            <div class="modal-content">
                  <div class="modal-header text-center">
                    <h4 class="text-uppercase">Update Kesesuaian <span ></span>
                  </div>
                  <div class="modal-body" >
                    <span>@{{mandat}}</span>
                    <hr>
                    <label>Penilaian Kesuaian Kebijakan Pusat dan Daerah</label>

                    <div class="form-group">
                      <div class="radio radio-danger radio-inline">
                        <input type="radio" id="pnl0" value="0" name="penilaian"  >
                        <label for="inlineRadio1"> Belum Dinilai </label>
                      </div>
                      <div class="radio radio-success radio-inline">
                        <input type="radio" id="pnl1" value="1" name="penilaian" >
                        <label for="inlineRadio1"> Sesuai </label>
                      </div>
                      <div class="radio radio-warning radio-inline">
                        <input type="radio" id="pnl2" value="2" name="penilaian" >
                        <label for="inlineRadio1"> Tidak Sesuai </label>
                      </div>
                      
                    </div>
                    <hr>

                   
                    <div class="form-group">
                      <label class="text-center text-uppercase">Uraian Kesesuian </label>
                      <textarea class="form-control" name="note" >@{{note}}</textarea>
                    </div>
                    <input type="hidden" name="kode_daerah" v-model="kode_daerah">
                   
                  </div>
                  <div class="modal-footer">
                    
                     <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah</button>
                  </div>
               @csrf
            </div>
         </form>
    </div>
  </div>



<script type="text/javascript">
  var update_kesesuian=new Vue({
    el:'#update_kesesuian',
    
    data:{
      mandat:'',
      action:'',
      value:'',
      kode_daerah:'',
      id_kesesuian:'',
      kesesuian:'',
      note:''
    },
    methods:{
      build:function(mandat,link,id_kesesuian,kesesuian,note){
        this.mandat=mandat;
        this.action=link;
        this.id_kesesuian=id_kesesuian;
        this.value='';
        this.kesesuian=kesesuian;
        this.note=note;


        console.log('[name="penilaian"][value="'+kesesuian+'"]');
        $('#pnl'+kesesuian).attr('checked',true);

          setTimeout(function(){
              $('#update_kesesuian').modal();
          },300);

      },
    },
  });



</script>
