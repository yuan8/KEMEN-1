<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MASTER\NOMEN;
use App\MASTER\NOMENKAB;
use Hp;
class MASTER90 extends Controller
{
    //

    public function index($pro=null,Request $request){
    	$tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
    	if($pro){
    		$data=NOMEN::where([
    			['urus','=',$meta_urusan['id_urusan']],
    			['jenis','=','program']

    		]
    	)->with(['_child_kegiatan._child_sub_kegiatan'])->get()->toArray();

    	}

    	$data=NOMENKAB::where([
    			['urus','=',$meta_urusan['id_urusan']],
    			['jenis','=','program']

    	])->with(['_child_kegiatan._child_sub_kegiatan'])->get()->toArray();

    	return view('integrasi.nomen.index')->with([
    		'data'=>$data,
    		'pro'=>$pro?'PROVINSI':'KOTA / KABUPATEN'
    	]);

    }
}
