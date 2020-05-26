<?php

namespace App\Http\Controllers\FRONT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class APBD extends Controller
{
    //


    public function index(Request $request){


    	if(strpos($request->daerah,'-' )!==false){
    		$data=DB::table('pad.pad as pad')
	    	->select('kode_akun',DB::raw("(select akun from pad.master_akun where id = pad.kode_akun) as nama_akun"),DB::raw("(select kat from pad.master_akun where id = pad.kode_akun) as kat_akun"),'tahun',DB::RAW('sum(anggaran::numeric)::numeric as total_anggaran'),DB::RAW('sum(realisasi::numeric)::numeric as total_realisasi')
	    	)
	    	->groupBy('kode_akun','tahun')
	    	->orderBy('pad.kode_akun','asc')
	    	->orderBy('tahun','asc')
	    	->where('kode_daerah','ilike',(int)str_replace('-', '', ($request->daerah)))
	    	->get();
    	}

    	else if(($request->provinsi)){
    		$data=DB::table('pad.pad as pad')
	    	->select('kode_akun',DB::raw("(select akun from pad.master_akun where id = pad.kode_akun) as nama_akun"),DB::raw("(select kat from pad.master_akun where id = pad.kode_akun) as kat_akun"),'tahun',DB::RAW('sum(anggaran::numeric)::numeric as total_anggaran'),DB::RAW('sum(realisasi::numeric)::numeric as total_realisasi')
	    	)
	    	->groupBy('kode_akun','tahun')
	    	->orderBy('pad.kode_akun','asc')
	    	->orderBy('tahun','asc')
	    	->where('kode_daerah','ilike',($request->provinsi.'%'))
	    	->get();

    	}else{
    		$data=DB::table('pad.pad as pad')
	    	->select('kode_akun',DB::raw("(select akun from pad.master_akun where id = pad.kode_akun) as nama_akun"),DB::raw("(select kat from pad.master_akun where id = pad.kode_akun) as kat_akun"),'tahun',DB::RAW('sum(anggaran::numeric)::numeric as total_anggaran'),DB::RAW('sum(realisasi::numeric)::numeric as total_realisasi')
	    	)
	    	->groupBy('kode_akun','tahun')
	    	->orderBy('pad.kode_akun','asc')
	    	->orderBy('tahun','asc')
	    	->get();
    	}

    	$data_return=[];
    	$kode_akun=0;

    	$blue_print_data=[];
    	for ($i=2010; $i <=2020 ; $i++) { 
    		$blue_print_data['T'.$i]=array(
    			'kode_akun'=>null,
    			'nama_akun'=>null,
    			'kat_akun'=>null,
    			'total_anggaran'=>null,
    			'total_realisasi'=>null,
    			'total_realisasi_persentase'=>0,
    		);
    	}

    	foreach ($data as $key => $d) {
    		$data_return[$d->kode_akun]['nama']=$d->nama_akun;
    		$data_return[$d->kode_akun]['kat_akun']=$d->kat_akun;


    		if(!isset($data_return[$d->kode_akun]['tahun'])){
    			$data_return[$d->kode_akun]['tahun']=$blue_print_data;
    		}
    		$d->total_anggaran=(float)$d->total_anggaran;
    		$d->total_realisasi=(float)$d->total_realisasi;


    		$dt=(array) $d;

    		$data_return[$d->kode_akun]['tahun']['T'.$d->tahun]=$dt;
    		

    		if(($d->total_realisasi>0 and $d->total_realisasi!=null) and ($d->total_anggaran>0 and !empty($d->total_anggaran))){
    			$data_return[$d->kode_akun]['tahun']['T'.$d->tahun]['total_realisasi_persentase']=(($d->total_realisasi/$d->total_anggaran)*100);
    		}else{
    			$data_return[$d->kode_akun]['tahun']['T'.$d->tahun]['total_realisasi_persentase']=0;
    		}

    	}


    	$data_return=array_values($data_return);

    	$provinsi=DB::table('pad.kode_daerah')->where('kode','ilike','%00')
    	->select('pemda as nama',DB::raw("replace(kode::text,'00','') as id"))->get();

    	return view('front.pad.index')->with([
    		'data'=>$data_return,
    		'provinsi'=>$provinsi
    	]);

    }


    public function api_selected_daerah(Request $request){
    	if(($request->provinsi!='')){

    		$data= DB::table('pad.kode_daerah')->where('kode','ilike',($request->provinsi.'%'))->select(
    			'pemda as nama',DB::raw("concat('-',replace(kode::text,'00','')) as id")
    		)->get()->toArray();

    		$data_return=[[
    			'id'=>$request->provinsi,
    			'nama'=>'seluruh kota/kab dan provinsi'
    		]];

    		foreach ($data as $key => $d) {

    			$data_return[]=(array)$d;
    		}

    		return $data_return;


    	}else{
    		return 
    		[
    			array('id'=>'','nama'=>'NASIONAL')
    		];
    	}
    }
}
