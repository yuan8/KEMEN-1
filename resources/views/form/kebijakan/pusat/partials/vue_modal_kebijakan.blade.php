
  <div class="modal fade" id="plus-{{$tag}}">
    <div class="modal-dialog">
        <form v-bind:action='action' method="post">
            <div class="modal-content">
                  <div class="modal-header text-center">
                    <h4 class="text-uppercase">Tambah {{$tag}} <span ></span>
                      <div class="pull-right">
                          <button type="button" class="btn btn-info btn-xs" v-on:click='toggleNew'>
                              <i class="fa fa-plus"></i> Tambah Manual DB
                      </button>
                      </div>
                  </div>
                  <div class="modal-body" >
                    <span>@{{mandat}}</span>
                    <hr>
                    <div v-if="formTambah" class="animated fadeInBottom">
                      <div class="form-group">
                        <label>Tambah Baru</label>
                        <textarea class="form-control" v-model="uraian_baru"></textarea>
                      </div>
                      <button type="button" class="btn btn-sm btn-info" v-on:click='storeNew'>
                        <i class="fa fa-arrow-up"></i> Upload
                      </button>
                      <hr>
                      
                    </div>
                    <div class="form-group">
                      <label class="text-center text-uppercase">Uraian {{$tag}} </label>
                      <select multiple="true" class="form-control" name="{{$tag}}[]" id="select-{{$tag}}"></select>
                    </div>
                   
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
  var plus_{{$tag}}=new Vue({
    el:'#plus-{{$tag}}',
    
    data:{
      formTambah:0,
      mandat:'',
      action:'',
      uraian_baru:'',
      action_new:'',
      value:''
    },
    methods:{
      build:function(dom,uraian,link,link_new,value){
        this.mandat=uraian;
        this.action=link;
        this.action_new=link_new;
        this.value=value;
          

          setTimeout(function(){
              $('[name="{{$tag}}[]"]').val(null).trigger('change');
              var data=value;
              data=data.split('|@|');
              for(var i in data){
                if(data[i]!=''){
                  data[i]=data[i].split('(@)');
                  var op=new Option(data[i][1],data[i][1],true,true);
                  $('[name="{{$tag}}[]"]').append(op).trigger('change'); 
                }
                
              }

              $(dom).modal();

          },300);

      },
      toggleNew:function(){
        if(this.formTambah){
          this.formTambah=0;
        }else{
          this.formTambah=1;
          this.uraian_baru='';
        }
      },
      storeNew:function(){
        var data_send={
          'uraian':this.uraian_baru
        };

        API_CON.post(this.action_new,data_send).then(function(res){
          var res=res.data;
          if(parseInt(res.code)==200){
             var option = new Option(res.data.text, res.data.id,true,true);
              $('#select-{{$tag}}').append(option).trigger('change');
            }
        });
      },

    },
    watch:{
      mandat:function(){
        $('#select-{{$tag}}').val('');
        
        $('#select-{{$tag}}').select2({
           ajax: {
              url: '{{route('api.kebijakan.pusat.get.'.$tag)}}',
              dataType: 'json',
              headers:{
                Authorization:TOKEN_KN
              }
            }
        });

      }
    }


  });



</script>
