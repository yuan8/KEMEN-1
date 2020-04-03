
 <div class="modal fade" id="delete_mandat">
    <div class="modal-dialog">
        <form v-bind:action='action' method="post">
          @method('DELETE')
            <div class="modal-content">
                  <div class="modal-header text-center">
                    <h4 class="text-uppercase">Hapus Mandat  <span ></span>
                  </div>
                  <div class="modal-body" >
                    <p class="text-center"><b>@{{mandat}} | @{{sub_urusan}}</b></p>
                    <p>Mengapus Mandat, akan menghapus juga kebijakan yang terkait dengan mandat ini</p>
                    <p><b>Anda yakin ?</b></p>
                   
                  </div>
                  <div class="modal-footer">
                    
                     <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                  </div>
               @csrf
            </div>
         </form>
    </div>
  </div>


<script type="text/javascript">
  var delete_mandat=new Vue({
    el:'#delete_mandat',
    
    data:{
      mandat:'',
      action:'',
      sub_urusan:''
    },
    methods:{
      build:function(link,mandat,sub_urusan){
        this.mandat=mandat;
        this.action=link;
        this.sub_urusan=sub_urusan;

        setTimeout(function(){
          $('#delete_mandat').modal();
        },300);

      },
     
    }
   
  });



</script>
