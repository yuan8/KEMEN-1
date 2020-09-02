<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use App\MANDAT\MANDAT;
use Excel;
class KEBIJAKAN extends Controller
{
    //


    public function index(){
    	


    }


    public function resume(Request $request){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	$data=MANDAT::where(['tahun'=>$tahun,'id_urusan'=>$meta_urusan['id_urusan']])
    	->with(['_sub_urusan','_integrasi','_uu','_pp','_permen','_perpres'])
    	->withCount(['_list_perkada','_list_perda','_integrasi_sesuai','_integrasi_tidak_sesuai'])
    	->get();


    	$title='RESUME  KEBIJAKAN PUSAT '.$meta_urusan['nama'].' TAHUN '.$tahun;

        // return view('integrasi.mandat.resume_ex')->with(['data'=>$data,'title'=>$title]);
    	if($request->pdf){
    		 $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape')->setOptions(['dpi' => 200, 'defaultFont' => 'sans-serif','isRemoteEnabled' => true]);
                $pdf->loadHTML(view('integrasi.mandat.resume_ex')->with(['data'=>$data,'title'=>$title])->render());
                return $pdf->stream();
    	}else{
            $tt=$title;
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=hasil.xls");
            return view('integrasi.mandat.resume_ex')->with(['data'=>$data,'title'=>$title])->render();
           
        }
    }
}
