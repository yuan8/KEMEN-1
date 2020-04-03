<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use DB;
use Hp;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Collection ;
class IntegrasiCtrl extends Controller
{
    //

    public function result_pro(Request $request){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        DB::enableQueryLog();
        $data=DB::table('master_ind_psn as psn')
        ->join('pic_psn_urusan as pic','pic.id_psn','=','psn.id_psn')
        ->leftJoin('view_pemenuhan_target_pusat_pro as ppro',[
            ['ppro.id_ind_psn','=','psn.id'],
            ['ppro.tahun','=',DB::raw($tahun)],

        ])->where('pic.id_urusan',$id_urusan)
        ->select('psn.*','ppro.*','ppro.daerah as d','psn.uraian as nama_ind',
            DB::raw("(select kode from master_satuan as a where a.id=psn.id_satuan limit 1) as satuan"),
            DB::raw("(
                select STRING_AGG(CONCAT(id,'||',nama,'||',logo),'|@|') FROM master_daerah where id in 
                 (select regexp_split_to_table(ppro.daerah,',') as d)
                ) as daerah_join")
        )
        ->paginate(10);
        // dd(DB::getQueryLog());
        // dd('s');

        return view('form.integrasi.pro.result')->with('data',$data);
    }

     public function testing(){
        $file_gen=file_get_contents(storage_path('app/json_data_daerah.json'));
        $file_gen=json_decode($file_gen,true);
        $file_final=$file_gen;
        // Storage::put('json_data_daerah_final.json',json_encode($file_gen));

        $id_s=[];
        foreach ($file_gen as $key => $d) {

            // $dar=DB::table('master_daerah')->where('nama','ilike',$d['nama'])->first();
            if(!isset($d['id'])){
                $dr=DB::table('master_daerah')->where(DB::raw("REPLACE(nama,' ','')"),'ilike',str_replace(' ', '', $d['nama']))->first();
                if($dr){
                    $file_gen[$key]['id']=$dr->id;
                    $d['id']=$dr->id;
                }

               
            }
            if(!isset($d['id'])){

                dd($d);
            }

            // if((int)$d['id']==1277){
            //     if(count($id_s)==1){
            //         dd($d);
            //     }
            // }





            if((!isset($d['lo'])) && (isset($d['id']))){
                $img=file_get_contents('https:'.$d['url']);
                Storage::put('public/logo-daerah/'.$d['id'].'.png',$img);
                $file_gen[$key]['storage']='storage/logo-daerah/'.$d['id'].'.png';
                $lo=DB::table('master_daerah')->where('id',$d['id'])->update([
                    'logo'=>'storage/logo-daerah/'.$d['id'].'.png'
                ]);
                if($lo){
                    $file_gen[$key]['lo']=true;
                    $file_gen[$key]['id']=$d['id'];

                }



                Storage::put('json_data_daerah.json',json_encode($file_gen,JSON_PRETTY_PRINT));

            }
            else{
              
            }
            // dd('fix :'.$d['id'].' '.$d['nama']);


           

            # code...
        }
        dd('dono');


        dd($file_gen);
        
    }


    public function index(Request $request){
         $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];

        $sub=DB::table('master_sub_urusan')->where('id_urusan',$id_urusan)->get();

        $data_nomenklatur_total=DB::table('master_nomenklatur_provinsi as nmp')->whereIn('nmp.jenis',['kegiatan','sub_kegiatan'])->where(DB::raw("(case when left(nmp.bidang_urusan,1)='0' then right(nmp.bidang_urusan,1)  else nmp.bidang_urusan end)"),$id_urusan)->count();


        $data=DB::table('view_pic_psn as psn')
        ->join('master_ind_psn as ind','ind.id_psn','=','psn.id')
        ->join('ind_nomen_prokeg_pro as nh','nh.id_ind_psn','=','ind.id')
        ->join('master_nomenklatur_provinsi as nm','nm.id','=','nh.id_nomen')
        ->select(
            'psn.nama as nama_psn',
            'ind.*',
            DB::raw("(select nomenklatur from master_nomenklatur_provinsi as n where n.kode =concat(nm.urusan,'.',nm.bidang_urusan,'.',nm.program) and n.jenis='program' limit 1 ) as nama_program"),
            DB::raw("(case when nm.jenis='sub_kegiatan' then (select nomenklatur from master_nomenklatur_provinsi as n where n.kode =concat(nm.urusan,'.',nm.bidang_urusan,'.',nm.program,'.',n.kegiatan) and n.jenis='kegiatan' limit 1 ) else nm.nomenklatur end) as nama_kegiatan"),
            DB::raw("(case when (nm.sub_kegiatan is not null) then nm.nomenklatur else null end ) as nama_sub_kegiatan"),
            'nm.kode as kode_nomenklatur',
            'nm.jenis',
            'ind.cal_type',
            DB::raw("(select kode from master_satuan where id =ind.id_satuan) as satuan"),
            DB::raw("(select target from ind_psn_target where id_psn =ind.id_psn and tahun=".$tahun.") as target")

        );

        if($request->q){
            $data=$data->where([
                ['psn.id_urusan','=',$id_urusan],
                ['psn.urai']
            ]);
        }else{
            $data=$data->where('psn.id_urusan',$id_urusan);
        }

        
        $data=$data->orderBy('psn.id','DESC')
        ->orderBy('nm.id','ASC')
        ->paginate(10)->appends(['q'=>$request->q]);


    	return view('form.integrasi.index')
        ->with('data_nomenklatur',$data)
        ->with('total',$data_nomenklatur_total)
        ->with('sub_urusan',$sub);
        
    }

    public function api_get_nomen_pro(){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];

          $data_nomenklatur=DB::table('master_nomenklatur_provinsi as nmp')
         ->whereIn('nmp.jenis',['program','kegiatan','sub_kegiatan'])
         ->where(DB::raw("(case when left(nmp.bidang_urusan,1)='0' then right(nmp.bidang_urusan,1)  else nmp.bidang_urusan end)"),$id_urusan)
         ->select('nmp.*',
            DB::raw("( (select count(DISTINCT(ind_n_pro.id_ind_psn)) AS nilai  
                from master_ind_psn as indp 
                join pic_psn_urusan as pic on pic.id_psn = indp.id_psn
                join ind_nomen_prokeg_pro as ind_n_pro on ind_n_pro.id_ind_psn=indp.id
                where pic.id_urusan=".$id_urusan." and ind_n_pro.id_nomen=nmp.id  group by pic.id_urusan) ) 
                 as jumlah_ind")
        )
        ->orderBy('nmp.kode','ASC')
        ->get();

        return $data_nomenklatur;


    }

    public function provinsi(){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];

        $daerah=DB::table('master_daerah')
        ->select('master_daerah.*',
            DB::raw("
                (select count(DISTINCT(indt_d.id_ind_psn)) from ind_psn_target_pro as indt_d 
                join master_ind_psn as indp on  indp.id=indt_d.id_ind_psn
                and indp.tahun <=".$tahun." and indp.tahun_selesai >= ".$tahun." 
                join pic_psn_urusan as pic on pic.id_psn = indp.id_psn and pic.id_urusan=".$id_urusan."
                where indt_d.tahun =".$tahun." and indt_d.kode_daerah=master_daerah.id
                ) as jumlah_ind
            "),
            DB::raw("(select count(*) from master_ind_psn as ipsn
            join pic_psn_urusan as pic on pic.id_psn = ipsn.id_psn and pic.id_urusan=".$id_urusan." ) as total_ind")
        )
        ->where('kode_daerah_parent',null)
        ->orderBy('id','ASC')->get();

        // dd('s');
    	return view('form.integrasi.provinsi')
        ->with('provinsi',$daerah);

    }


    public function detail_provinsi($id){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        $sub_urusan=DB::table('master_sub_urusan')
        ->where('id_urusan',$id_urusan)
        ->get();

        $daerah=DB::table('master_daerah')->find($id);
        if($daerah){
         return view('form.integrasi.pro.index')->with('sub_urusan',$sub_urusan)->with('daerah',$daerah);

        }



    }

    public function maping_ind_pro_store_target($id,$ind,Request $request){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        $ind2=DB::table('master_ind_psn as ipsn')
        ->join('pic_psn_urusan as pic','pic.id_psn','=','ipsn.id_psn')
        ->where('ipsn.id',$ind)
        ->select('ipsn.*')
        ->where('pic.id_urusan',$id_urusan)->first();


        if($ind2){

            // $ind2=array($ind2);
            $tg=DB::table('ind_psn_target as tg')
            ->where('tg.id_ind_psn',$ind)
            ->where('tg.target','!=',null)
            ->first();

            if(!$tg){
                Alert::info('','Mohon melakukan pengisian target pusat');
                return back();
            }



            $data=DB::table('ind_psn_target_pro')
            ->where('kode_daerah',$id)
            ->where('id_ind_psn',$id)
            ->where('tahun',$tahun)->first();

            if($data){
                $data=DB::table('ind_psn_target_pro as tgp')
                // ->join('pic_psn_urusan','pic.id_psn','=','tgp.')
                ->where('tgp.kode_daerah',$id)
                ->where('tgp.id_ind_psn',$id)
                ->where('tgp.tahun',$tahun)->update([
                    'tgp.target'=>(string)$request->target,
                    'tgp.updated_at'=>Carbon::now()

                ]);

            }else{
                $data=DB::table('ind_psn_target_pro')->insertOrIgnore([
                    'id_ind_psn'=>$ind,
                    'kode_daerah'=>$id,
                    'tahun'=>$tahun,
                    'target'=>$request->target,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()

                ]);
            }

            Alert::success('Success');
            return back();

        }


    }

    public function mapingProStore($id,Request $request){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];


        $ind=DB::table('master_ind_psn as psn')->where('psn.id',$id)
        ->join('pic_psn_urusan as pic','pic.id_psn','=','psn.id_psn')
        ->where('pic.id_urusan',$id_urusan)
        ->where('psn.tahun','<=',$tahun)
        ->where('psn.tahun_selesai','>=',$tahun)
        ->select('psn.*')
        ->first();

        if($ind){

            $data_in=[];

            foreach($request->id as $key=>$idnomen){
                $data_in[]=array(
                    'id_ind_psn'=>$id,
                    'id_nomen'=>$idnomen,
                    'nomenklatur'=>$key
                );
            }


            DB::table('ind_nomen_prokeg_pro')->insertOrIgnore($data_in);

            Alert::success('Berhasil');

        }else{

            Alert::error('Data Tidak Tersedia');
        }

        return back();



    }

    public function mapingPro($id){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];
        
        $ind=DB::table('master_ind_psn as ind')
        ->join('pic_psn_urusan as pic','pic.id_psn','=','ind.id_psn')

        ->where('ind.id',$id)
        ->where('pic.id_urusan',$id_urusan)
        ->where('ind.tahun','<=',$tahun)
        ->where('ind.tahun_selesai','>=',$tahun)
        ->select('ind.*',
            DB::raw("(select nama from master_pn as pn where pn.id=ind.id_pn limit 1) as nama_pn"),
            DB::raw("(select nama from master_pp as a where a.id=ind.id_pp limit 1) as nama_pp"),
            DB::raw("(select nama from master_kp as a where a.id=ind.id_kp limit 1) as nama_kp"),
            DB::raw("(select nama from master_propn as a where a.id=ind.id_propn limit 1) as nama_propn"),
            DB::raw("(select nama from master_psn as a where a.id=ind.id_psn limit 1) as nama_psn"),
            DB::raw("(select kode from master_satuan as a where a.id=ind.id_satuan limit 1) as satuan")

        )
        ->first();

        $data_nomenklatur=[];

        if($ind){
            return view('form.integrasi.pro.maping')
            ->with('ind',$ind)
            ->with('nomenklatur',$data_nomenklatur)
            ->with('back_link',route('integrasi.index'));
        }

        Alert::error('Data tidak di temukan');
        return redirect()->route('integrasi.index');


    }


   

    public function api_get_data_ind(){
        
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];


        $data=DB::table('master_ind_psn as ipsn')
        ->join('pic_psn_urusan as pic','pic.id_psn','=','ipsn.id_psn')
        ->join('ind_psn_target as tg',[['tg.id_ind_psn','=','ipsn.id'],['tg.tahun','=',DB::raw($tahun)]])
        ->select('ipsn.*',DB::raw("CONCAT('<button class=%22btn btn-warning btn-xs%22 onclick=%22add_card(this)%22 >Tambah</button>') as btn_add "),DB::raw("CONCAT('<button type=%22button%22 class=%22btn btn-info btn-xs%22 onclick=%22 viewDetailInd(',ipsn.id,',','event',') %22 >Maping / View </button>') as btn_detail"))
        ->where('ipsn.tahun','<=',$tahun)
        ->where('ipsn.tahun_selesai','>=',$tahun)
        ->where('pic.id_urusan',$id_urusan)
        ->where('tg.tahun',$tahun)
        // ->groupby('ipsn.id')
        ->get();

        // return [];
        return $data;
    }

    public function target_pro($kode_daerah,$id=null){
        $tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];

        $daerah=DB::table('master_daerah')->find($kode_daerah);
       
         $ind=(array)DB::table('master_ind_psn as ind')
         ->join('pic_psn_urusan as pic','pic.id_psn','=','ind.id_psn')
        ->join('ind_psn_target as tg',[['tg.id_ind_psn','=','ind.id'],['tg.tahun','=',DB::raw($tahun)]])

        ->where('ind.id',$id)
        ->where('pic.id_urusan',$id_urusan)
        ->where('ind.tahun','<=',$tahun)
        ->where('ind.tahun_selesai','>=',$tahun)
        ->select('ind.*',
            DB::raw("(select nama from master_pn as pn where pn.id=ind.id_pn limit 1) as nama_pn"),
            DB::raw("(select nama from master_pp as a where a.id=ind.id_pp limit 1) as nama_pp"),
            DB::raw("(select nama from master_kp as a where a.id=ind.id_kp limit 1) as nama_kp"),
            DB::raw("(select nama from master_propn as a where a.id=ind.id_propn limit 1) as nama_propn"),
            DB::raw("(select nama from master_psn as a where a.id=ind.id_psn limit 1) as nama_psn"),
            DB::raw("(select kode from master_satuan as a where a.id=ind.id_satuan limit 1) as satuan"),
            
            DB::raw("(select tg.target from ind_psn_target as tg where ind.id=tg.id_ind_psn and tg.tahun=".$tahun." limit 1 ) as target_pusat"),
            DB::raw("(select tg.target from ind_psn_target_pro as tg where ind.id=tg.id_ind_psn and tg.tahun=".$tahun." limit 1 ) as target_daerah")
        )
        ->first();

        if(($ind) && ($daerah)){

            $l=($tahun-$ind['tahun'])+1;
           $ind['use_tg_when_false']='target_'.$l;


            return view('form.integrasi.pro.target')->with('daerah',$daerah)->with('ind',$ind);
        }else{

            return abort('404');
        }


    }
}


// https://codepen.io/plavookac/pen/QMwObb