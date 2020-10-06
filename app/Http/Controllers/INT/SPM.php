<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MASTER\SUBURUSAN;
use Hp;
use App\MASTER\SPM as MODELSPM;
use Alert;
use Auth;
use App\MASTER\SATUAN;
use App\MASTER\INDIKATOR;
class SPM extends Controller
{
    //


    public function index(Request $request){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	$data=MODELSPM::where('id_urusan',$meta_urusan['id_urusan'])
    	->with(['_sub_urusan','_indikator'])->orderBy('id','DESC')->get()->toArray();
    	

    	$sub_urusan=SUBURUSAN::where('id_urusan',$meta_urusan['id_urusan'])->get()->toArray();
    	return view('integrasi.spm.index')->with(['sub_urusan'=>$sub_urusan,'data'=>$data,]);
    }

    public function update(Request $request){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();
    	if($request->uraian){
    		$data=MODELSPM::where('id',$request->id_spm)->update([
    			'id_urusan'=>$meta_urusan['id_urusan'],
    			'id_sub_urusan'=>$request->sub_urusan,
    			'uraian'=>strtoupper($request->uraian),
    			'tahun'=>$tahun
    		]);

    		if($data){
    			Alert::success('BERHASIL','BERHASIL UPDATE JENIS LAYANAN');
    		}


    	}

    	return back();
    }

    public function indikator($id,Request $request){
    	$spm=MODELSPM::where('id',$id)->first();
    	$satuan=[];

    	return view('integrasi.spm.indikator')->with(['use_spm'=>true,'rkp'=>$spm,'tag'=>5,'jenis'=>'JENIS PELAYANAN ','satuan'=>$satuan]);

    }

    public function store_indikator($id,Request $request){
    	$spm=MODELSPM::where('id',$id)->first();
    	if($spm){
    		$up=INDIKATOR::whereIn('id',$request->id_indikator)->update(['id_spm'=>$spm['id']]);

    	}
    	
    	Alert::success('BERHASIL','BERHASIL MENAMBAHKAN INDIKATOR');
    	return back();
    	
    }



    public function store(Request $request){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();
    	if($request->uraian){
    		$data=MODELSPM::create([
    			'id_urusan'=>$meta_urusan['id_urusan'],
    			'id_sub_urusan'=>$request->sub_urusan,
    			'uraian'=>strtoupper($request->uraian),
    			'tahun'=>$tahun,
                'id_user'=>Auth::User()->id
    		]);

    		if($data){
    			Alert::success('BERHASIL','BERHASIL MENAMBAHKAN JENIS LAYANAN');
    		}


    	}

    	return back();
    }
}
