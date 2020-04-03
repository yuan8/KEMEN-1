<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
class GlobCTRL extends Controller
{
    //
    public function detail_ind_psn($id){
    	$tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];

        $ind=DB::table('ind_psn as ind')
        ->select('ind.*')
        ->where([
        	['ind.id_urusan',$id_urusan],
        	['ind.tahun_selesai','>=',$tahun],
        	['ind.tahun_selesai','>=',$tahun]
        ])
        ->orWhere([
        	['ind.id_urusan',null],
        	['ind.tahun_selesai','>=',$tahun],
        	['ind.tahun_selesai','>=',$tahun]
        ])
        ->first();

        return (array)$ind;
    }

    public function detail_psn($id){
    	$tahun=Hp::fokus_tahun();
        $id_urusan=Hp::fokus_urusan()['id_urusan'];

        $psn=DB::table('master_psn as psn')
        ->leftJoin('pic_psn_urusan as pic','pic.id_psn','=','psn.id')
        ->select('psn.*',
        	DB::raw("(select nama from master_pn as pn where pn.id=psn.id_pn limit 1) as nama_pn"),
            DB::raw("(select nama from master_pp as a where a.id=psn.id_pp limit 1) as nama_pp"),
            DB::raw("(select nama from master_kp as a where a.id=psn.id_kp limit 1) as nama_kp"),
            DB::raw("(select nama from master_propn as a where a.id=psn.id_propn limit 1) as nama_propn"),
        	DB::raw($tahun." as tahun_access")

    	)
        ->where([
        	['pic.id_urusan',$id_urusan],
        	['psn.tahun_selesai','>=',$tahun],
        	['psn.tahun_selesai','>=',$tahun]
        ])
        ->orWhere([
        	['pic.id_urusan',null],
        	['psn.tahun_selesai','>=',$tahun],
        	['psn.tahun_selesai','>=',$tahun]
        ])
        ->first();

        $ind=DB::table('master_ind_psn as ind')
        ->leftJoin('pic_psn_urusan as pic','pic.id_psn','=','ind.id_psn')
        ->select('ind.*',
        	DB::raw("(select tg.target from ind_psn_target as tg where ind.id=tg.id_ind_psn and tg.tahun=".$tahun." limit 1 ) as target_pusat"),
            DB::raw("(select kode from master_satuan as a where a.id=ind.id_satuan limit 1) as satuan"),
        	DB::raw($tahun." as tahun_access"),
        	DB::raw("concat('target_',((".$tahun." - ind.tahun)+1)) as use_tg_when_false")
    	)
        ->where([
        	['ind.id_psn',$id],
        	['pic.id_urusan',$id_urusan],
        	['ind.tahun_selesai','>=',$tahun],
        	['ind.tahun_selesai','>=',$tahun]
        ])
        ->orWhere([
        	['ind.id_psn',$id],
        	['pic.id_urusan',null],
        	['ind.tahun_selesai','>=',$tahun],
        	['ind.tahun_selesai','>=',$tahun]
        ])
        ->get()->toArray();


        // return (array)$ind;

        return view('glob.detail_psn')->with('data', array('psn'=>(array)$psn,'ind'=>($ind)))->render();
    }
}
