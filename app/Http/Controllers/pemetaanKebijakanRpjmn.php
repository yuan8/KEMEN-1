<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use Alert;

class pemetaanKebijakanRpjmn extends Controller
{
	public function delete_pemetaan($id){
DB::enableQueryLog();
 
 $d=DB::table('form.pemetaan_kebijakan')->find($id);
$lihat=DB::table('form.kb5_arah_kebijakan')->find($d->id_arah_kebijakan);
        if($d){
            $a=DB::table('form.pemetaan_kebijakan')->where('id',$id)->delete();
DB::enableQueryLog();  
  if($a){
                Alert::success($lihat->uraian,'Indikator Telah di Hapus');
                return redirect()->back();
            }
        }else{

        }

        Alert::error('','Mandat Tidak terhapus Hapus');
        return back();

    }
   public function pemetaan(Request $request){
        $urusan=\Hp::fokus_urusan();

        $kebijakan=DB::table(DB::raw('master_sub_urusan as su'))
        ->select('su.id as id','su.nama as nama','man.id as id_mandat','man.uraian as mandat','man.tipe',
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_uu as ux where ux.id_mandat=man.id ) as uu"),
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_pp as ux where ux.id_mandat=man.id ) as pp"),
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_perpres as ux where ux.id_mandat=man.id ) as perpres"),
            DB::raw("(select STRING_AGG(CONCAT(ux.id,'(@)',ux.uraian),'|@|' order by ux.id DESC) AS x from ikb_permen as ux where ux.id_mandat=man.id ) as permen")
        )
        ->leftJoin('ikb_mandat as man','man.id_sub_urusan','=','su.id')
        ->where('su.id_urusan',$urusan['id_urusan'])
        ->orderBy('su.id','ASC')
        ->orderBy('man.id','DESC')


        ->paginate(10);
dd(DB::getQueryLog());
    	return view('form.pemetaan.index')->with('kebijakan',$kebijakan);
    }
public function index(Request $request){
        $urusan=\Hp::fokus_urusan();
		$tahun=\Hp::fokus_tahun();
		        DB::enableQueryLog();

        $kebijakan=DB::table(DB::raw('public.ikb_mandat as a'))
        ->select(DB::raw("a.id as id_mandat,case when row_number() over (partition by min(d.id) order by min(b.id))=1 then min(d.nama) else '' end as sub_urusan,
min(a.uraian) as mandat,string_agg(concat(b.id,'(@)',c.uraian) ,'<br>') as arah_kebijakan")
        )
        ->leftJoin('form.pemetaan_kebijakan as b','b.id_mandat','=','a.id')
		->leftJoin('form.kb5_arah_kebijakan  as c','b.id_arah_kebijakan','=','c.id')
		->leftJoin('public.master_sub_urusan as d','a.id_sub_urusan','=','d.id')
        ->where('a.id_urusan',$urusan['id_urusan'])
		->where('a.tahun',(int)$tahun)
		->groupBy('a.id')
        ->orderByRaw('min(d.id)')
         ->paginate(10);
//dd(DB::getQueryLog());
    	return view('form.pemetaan.index')->with('kebijakan',$kebijakan);
    }

}
