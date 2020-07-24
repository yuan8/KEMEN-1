<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use Alert;
use Auth;
use App\RKP\RKP;
class KEBIJAKANPUSAT1TAHUN extends Controller
{
    //

    public function index(){
    	$tahun=Hp::fokus_tahun();
    	$data=RKP::where(['jenis'=>1,'tahun'=>$tahun])->with(['_indikator','_child_pp._child_kp._child_propn._child_proyek'])->get();

    	return view('integrasi.kb1tahun.index')->with('data',$data);
    }
}
