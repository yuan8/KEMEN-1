<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\KB5\KONDISI;
use Hp;
use DB;
class PELAKSANAANURUSAN extends Controller
{
    //

    public function index(){
    	$meta_urusan=Hp::fokus_urusan();
    	$tahun=Hp::fokus_tahun();
    	$id_sub_urusan=DB::table('master_sub_urusan')->where('id_urusan',$meta_urusan['id_urusan'])->get()->pluck('id');

    	$data=DB::connection('form')->table('form.kb5_indikator as i')
    	->leftJoin('public.master_sub_urusan as su','su.id','=','i.id_sub_urusan')
    	->whereIn('i.id_sub_urusan',$id_sub_urusan)
    	->where('tahun',$tahun)
    	->select(DB::raw("i.*,su.nama as nama_sub_urusan"))
    	->orderBy('i.id_sub_urusan','asc')
    	->get()->toArray();


    	return view('integrasi.pelaksanaan.index')->with('data',$data);
    }
}
