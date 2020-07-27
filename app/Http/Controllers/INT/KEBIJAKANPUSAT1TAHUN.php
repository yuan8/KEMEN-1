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
class KEBIJAKANPUSAT1TAHUN extends Controller
{
    //

    public function index(){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['jenis'=>1,'tahun'=>$tahun])->with(['_tag_indikator._indikator','_child_pp._child_kp._child_propn._child_proyek'])->get();

    	return view('integrasi.kb1tahun.index')->with('data',$data);
    }


     public function pn_create(){
    	

    	return view('integrasi.kb1tahun.pn.create');
    }

    public function pn_store(Request $request){
    	$tahun=Hp::fokus_tahun();

    	$valid=Validator::make($request->all(),[
    		'uraian'=>'required|string'
    	]);


    	if($valid->fails()){
    		Alert::error('Error');
    		return back();
    	}

    	$data=RKP::create([
    		'uraian'=>$request->uraian,
    		'jenis'=>1,
    		'tahun'=>$tahun,
    		'id_user'=>Auth::User()->id
    	]);

    	if($data){
    		Alert::success('Success','Berhasil Menambahkan PN');
    		return back();
    	}

    }


    public function pn_view($id){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();

    	if($data){
    		return view('integrasi.kb1tahun.pn.update')->with('data',$data);
    	}

    }

    public function pn_update($id,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();

    	if($data){
    		$pn=RKP::find($id)->update([
    			'uraian'=>$request->uraian
    		]);

    		if($pn){
    			
    			Alert::success('Success','Berhasil Mengubah PN');
    			return back();
    		}

    	}

    }

     public function pn_form_delete($id,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();

    	if($data){
	    	return view('integrasi.kb1tahun.pn.form_delete')->with('data',$data);	


    	}

    }

    public function pn_delete($id){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->delete();
    	if($data){
    		Alert::success('Success','Berhasil menghapus data PN');
    		return back();
	   }else{
	   		Alert::error('Gagal','Gagal menghapus data PN');
    		return back();
	   }
    }

     public function pn_indikator($id){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	$id_sub=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
    	if($data){
    		$indikator=INDIKATOR::where('tahun',$tahun)->whereIn('id_sub_urusan',$id_sub)->get();
    		return view('integrasi.kb1tahun.pn.indikator')->with(['data'=>$indikator,'rkp'=>$data])->render();
	   }else{
	   		return 'data tidak tersedia';
	   }
    }

    public function store_indikator($id,Request $request){
    	$tahun=Hp::fokus_tahun();
    	$uid=Auth::id();
    	$data=RKP::where(['tahun'=>$tahun,'id'=>$id])->first();
    	if($data){
    		if($request->id_indikator){
    			foreach ($request->id_indikator as $key => $i) {
	    			if(!(RKPINDIKATOR::where(['id_rkp'=>$data->id,'id_indikator'=>$i])->first())){
	    				RKPINDIKATOR::create(['id_rkp'=>$data->id,'id_indikator'=>$i,'jenis'=>$data->jenis,'id_user'=>$uid]);
	    			}
	    			# code...
	    		}

	    		Alert::success('Success','Berhasil Menambahkan Indikator');
	    		return back();
    		}else{
    			Alert::success('Gagal','Gagal Menambahkan Indikator');
	    		return back();

    		}
    	}

    }
}
