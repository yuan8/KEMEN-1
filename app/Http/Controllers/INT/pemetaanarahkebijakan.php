<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use Alert;
use Auth;
use App\RKP\RKP;
use Validator;
use App\KB5\INDIKATOR;
use App\RKP\RKPINDIKATOR;
use App\KB5\ARAHKEBIJAKAN;
use App\pemetaankebijakan;
use Carbon\Carbon;


class pemetaanarahkebijakan extends Controller
{
         
    static function namaRKP($kode){
        $jenis='';
        switch ((int)$kode) {
            case 1:
                # code...
             $jenis='PN';
                break;
             case 2:
                # code...
             $jenis='PP';
                break;
             case 3:
                # code...
             $jenis='KP';
                break;
             case 4:
                # code...
             $jenis='PROPN';
                break;
              case 5:
                # code...
             $jenis='PROYEK';
                break;
            default:
                # code...
                break;
        }
        return $jenis;
    }
		 public function pn_indikator($id){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	$id_sub=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
		$data2=DB::table('ikb_mandat')->where('id',$id)->get();
		foreach($data2 as $keterangan)
		{
			$ket=$keterangan->uraian;
		}
		//$keterangan=$data2['uraian'];
		
        $jenis='MANDAT';

    	if($data2){
//    		$indikator=INDIKATOR::where('tahun',$tahun)->whereIn('id_sub_urusan',$id_sub)->get();
			$indikator=DB::table('form.kb5_arah_kebijakan')->where('id_user',$meta_urusan['id_urusan'])->get();
		//	dd($indikator2);
    		return view('form.pemetaan.indikator')->with(['data'=>$indikator,'rkp'=>$id,'ket'=>$ket,'jenis'=>$jenis]);
	   }else{
	   		return 'data tidak tersedia';
	   }
    }
	public function index(){
		return view('form.pemetaan.indikator');
	}
	public function insert_arah_kebijakan(Request $request){
		$tahun=Hp::fokus_tahun();
    	$uid=Hp::fokus_urusan();
	
		//$data=DB::table('form.pemetaan_kebijakan')->where(['tahun'=>$tahun,'id_user'=>$uid['id_urusan']])->first();
		//dd($request);
    	
				
    		if($request->id_indikator){
foreach ($request->id_mandat as $key => $j)
{
	$id_mandat=$j;
}
//dd($request);
    			foreach ($request->id_indikator as $key => $i) {
				
	    			if(!(pemetaankebijakan::where(['id_mandat'=>$id_mandat,'id_arah_kebijakan'=>$i])->first())){
	    				pemetaankebijakan::insertOrIgnore(['id_mandat'=>$id_mandat,'id_arah_kebijakan'=>$i,'tahun'=>(int)$tahun,'id_user'=>(int)$uid]);
	    			}
	    			# code...
	    		}

	    		Alert::success('Success','Berhasil Menambahkan Indikator');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menambahkan Indikator');
	    		return back();

    		}
    	}
	

}
