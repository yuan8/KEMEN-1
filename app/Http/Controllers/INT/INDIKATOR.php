<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\KB5\INDIKATOR AS IND;
use Hp;
use Auth;
use Carbon\Carbon;
use Alert;
class INDIKATOR extends Controller
{
    //

    public function index(Request $request){

    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

        if($request->s){
            $id_sub=[$request->s];
        }else{
             $id_sub=(array)DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id')->toArray();
        }
       


        $data=IND::whereRaw("
        (tahun=".$tahun.(isset($request->t)?" and tag::text ilike '".$request->t."'":' ')." and id_sub_urusan in (".implode(',', $id_sub).") and uraian ilike '%".$request->q."%') OR (tahun=".$tahun.(isset($request->t)?(" and tag::text ilike '".$request->t."'"):' ')." and id_sub_urusan in (".implode(',', $id_sub).") and kode ilike '%".$request->q."%') 
        ");




    $data=$data->orderBy('id','DESC')->paginate(10);
        $data->appends(['q'=>$request->q]);
        $data->appends(['t'=>$request->t]);

         $id_sub=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get();
    	return view('integrasi.master_indikator.index')->with(['data'=>$data,'sub_urusan'=>$id_sub]);
    }


    public function create(){
    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $satuan=DB::table('public.master_satuan')->get()->pluck('kode');
        $sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get();
        return view('integrasi.indikator.create')->with([
        	'meta_urusan'=>$meta_urusan,
        	'tag'=>0,
        	'sub_urusan'=>$sub_urusan,
        	'satuan'=>$satuan
        ]);
    }


    public function store(Request $request){
    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $data=[];



        $data['tag']=$request->tag;
        $data['uraian']=$request->uraian;
       
        $data['tahun']=$tahun;
        $data['tipe_value']=$request->tipe_value;
        $data['target']=$request->target;

        $data['target_1']=$request->tipe_value==2?($request->target_1?(float)$request->target_1:null):null;

        $data['satuan']=$request->satuan;
        $data['lokus']=$request->lokus;
        $data['kw_nas']=$request->kw_nas=='on'?true:false;

        $data['kw_p']=$request->kw_p=='on'?true:false;

        $data['kw_k']=$request->kw_k=='on'?true:false;

        $data['id_sub_urusan']=$request->id_sub_urusan;
        $data['data_dukung_nas']=$data['kw_nas']?($request->data_dukung_nas):null;
        $data['data_dukung_p']=$data['kw_p']?($request->data_dukung_p):null;
        $data['data_dukung_k']=$data['kw_k']?($request->data_dukung_k):null;
        $data['keterangan']=$request->keterangan;
        $data['pelaksana_nas']=$data['kw_nas']?json_encode($request->pelaksana_nas?$request->pelaksana_nas:[]):'[]';

        $data['pelaksana_p']=$data['kw_p']?json_encode($request->pelaksana_p?$request->pelaksana_p:[]):'[]';

        $data['pelaksana_k']=$data['kw_k']?json_encode($request->pelaksana_k?$request->pelaksana_p:[]):'[]';

        $data['kewenangan_nas']=$data['kw_nas']?($request->kewenangan_nas):null;
        $data['kewenangan_p']=$data['kw_p']?($request->kewenangan_p):null;
        $data['kewenangan_k']=$data['kw_k']?($request->kewenangan_k):null;
        $data['id_user']=Auth::id();
        $data['created_at']=Carbon::now();
        $data['updated_at']=Carbon::now();


        $data=IND::create($data);

        if($data){
        	if($data->tag==1){
        		$kode=$data->id;
        	}else{
        		$kode=$tahun.'.'.$data->id;
        	}

        	$data=IND::where('id',$data->id)->first();
        	$data->kode=Hp::pre_ind($data->tag).$kode;
        	$data->kode_realistic=$kode;
        	$data->update();

            $data=IND::where('id',$data->id)->with('_sub_urusan')->first();
            $data['_sumber']=$data->_sumber();

            if($request->for_api){
                return array('kode'=>200,'data'=>$data);
            }

            Hp::satuanCreateOrignore($data['satuan']);

        	Alert::success('Success','Berhasil Menambah Indikator');
        	return back();

        }else{
            if($request->for_api){
                return array('kode'=>500,'data'=>[]);
            }
            
        	Alert::error('Error','Gagal Menambah Indikator');
        	return back();
        }




    }


    public function list_indikator(Request $request){
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();

        $data=IND::where('tahun',$tahun)->orderBy('id','DESC')->with('_sub_urusan');
        foreach ($request->all() as $key => $v) {
            # code...
            if($key!='id_sub_urusan'){
                if(!is_array($v)){
                    $data=$data->where($key,$v);
                }else{
                    $data=$data->whereIn($key,$v);

                }
            }else{
                
            }
        }

        if($request->id_sub_urusan){
            $data=$data->where('id_sub_urusan',$request->id_sub_urusan);
        }else{
            $id_sub=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');
            $data=$data->whereIn('id_sub_urusan',$id_sub);
        }
            
        


        $data=$data->orderBy('id','DESC')->get();
        foreach ($data as $key => $i) {
            $data[$key]['_sumber']=$i->_sumber();
            # code...
        }


        return array('kode'=>200,'data'=>$data);

    }
}
