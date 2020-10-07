<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use App\MANDAT\MANDAT;
use Excel;

use Storage;
class KEBIJAKAN extends Controller
{
    //


    public function index(){
    	


    }


    public function resume(Request $request){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();
        $data=(new MANDAT);
    	$data=$data->where(['tahun'=>$tahun,'id_urusan'=>$meta_urusan['id_urusan']])
    	->with(['_sub_urusan','_integrasi'=>function($q){
            return $q->whereIn('kesesuaian',[1,2])->whereHas('_perkada')->orWhereHas('_perda');
        },'_uu','_pp','_permen','_perpres'])
    	->withCount(['_list_perkada'=>function($q){
            return $q->whereIn('kesesuaian',[1,2]);

        },'_list_perda'=>function($q){
            return $q->whereIn('kesesuaian',[1,2]);
        },'_integrasi_sesuai','_integrasi_tidak_sesuai'])
    	->orderBy('id_sub_urusan','ASC')
        ->orderBy('id','DESC')->get()->toArray();


    	$title='RESUME  KEBIJAKAN PUSAT '.$meta_urusan['nama'].' TAHUN '.$tahun;
        Storage::put('public/dokumen-integrasi/'.$meta_urusan['nama'].'/'.$tahun.'/FORMAT-1/KEBIJAKAN-PUSAT.json',json_encode(array('export_date'=>\Carbon\Carbon::now(),'status_dokumen'=>1,'urusan'=>$meta_urusan,'data'=>($data))));
                
        // return view('integrasi.mandat.resume_ex')->with(['data'=>$data,'title'=>$title]);
    	if($request->pdf){
         
      
    		$pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape')->setOptions(['dpi' => 200, 'enable_php'=>true,'isRemoteEnabled' => true]);
                $pdf->loadHTML(view('integrasi.mandat.resume_ex')->with(['data'=>$data,'title'=>$title])->render());

                

                $pdf->save(storage_path('app/public/dokumen-integrasi/'.$meta_urusan['nama'].'/'.$tahun.'/FORMAT-1/KEBIJAKAN-PUSAT.pdf'));

                

                return redirect(url('storage/dokumen-integrasi/'.$meta_urusan['nama'].'/'.$tahun.'/FORMAT-1/KEBIJAKAN-PUSAT.pdf'));

    	}else{
            $tt=$title;
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=hasil.xls");
            return view('integrasi.mandat.resume_ex')->with(['data'=>$data,'title'=>$title])->render();
           
        }
    }
}
