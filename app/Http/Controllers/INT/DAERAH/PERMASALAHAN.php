<?php

namespace App\Http\Controllers\INT\DAERAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use App\MASTER\MASALAHPOKOK;
use App\MASALAH\MASALAH;
use App\INTEGRASI\REKOMENDASI;
use App\INTEGRASI\REKOMENDASIKAB;

class PERMASALAHAN extends Controller
{
    //

	public function pilih_daerah(){

	}

    public function index(){
    	
    }

    public function list_tagging(Request $request){
        $tahun=Hp::fokus_tahun();
        $meta_urusan=Hp::fokus_urusan();
        $data=MASALAH::where(['kode_daerah'=>$request->kodepemda,'id_urusan'=>$meta_urusan['id_urusan'],'tahun'=>$tahun])->get();

        if(strlen($request->kodepemda.'')>2 ){
            $model=new REKOMENDASIKAB;
        }else{
            $model=new REKOMENDASI;

        }
        $rekom=$model->with('_nomen')->find($request->idrekom)->toArray();
        if($rekom){
            return view('integrasi.rekomendasi.tagging')->with(
            ['data'=>$data,'jenis'=>'PERMASALAHAN','url_tagging'=>route('int.rekomendasi.tagging_nomen',['jenis'=>'PERMASALAHAN','id_rekom'=>$rekom['id'],'kodepemda'=>$request->kodepemda]),'rekom'=>$rekom]
        );
        }else{
            return 'DATA TIDAK TERSEDIA, MOHON MEREFRESH BROWSER TERLEBIH DAHULU';
        }

    }

    public function namePermasalahan($kode){
    	
    }

        public function download($id,Request $request){
    	$daerah=DB::table('master_daerah')->find($id);
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

        $data=DB::table('ms_pokok as pk')
        ->leftJoin('ms','ms.id_ms_pokok','=','pk.id')
        ->leftJoin('ms_akar as ak','ak.id_ms','=','ms.id')
        ->leftJoin('ms_data_dukung as dt','dt.id_ms_akar','=','ak.id')
        ->select(
            'pk.id as id_pokok',
            'pk.uraian as pokok_uraian',
            'ms.id as id_ms',
            'ms.uraian as ms_uraian',
            'ak.id as id_akar',
            'ak.uraian as akar_uraian',
            'dt.id as id_data',
            'dt.uraian as data_uraian'
        )
        ->where('pk.kode_daerah',$id)
        ->where('pk.tahun',Hp::fokus_tahun())
        ->where('pk.id_urusan',Hp::fokus_urusan()['id_urusan'])


        ->orderBy('pk.id','desc')
        ->orderBy('ms.id','desc')
        ->orderBy('ak.id','desc')
        ->orderBy('dt.id','desc')
        ->get();


        $title='DATA PERMASALAHAN '.$meta_urusan['nama'].' TAHUN '.$tahun;
        $sub_title='DATA PERMASALAHAN DAERAH '.$daerah->nama;
        if($request->pdf){
             $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape')->setOptions(['dpi' => 200, 'defaultFont' => 'sans-serif','isRemoteEnabled' => true]);
                $pdf->loadHTML(view('integrasi.permasalahan.daerah.download')->with(['data'=>$data,'title'=>$title,'sub_title'=>$sub_title])->render());
                return $pdf->stream();
        }

        return view('integrasi.permasalahan.daerah.download')->with(['data'=>$data,'title'=>$title,'sub_title'=>$sub_title])->render().'';
    }


   
}
