<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use App\MASTER\MASALAHPOKOK;
use DB;
class PERMASALAHAN extends Controller
{
    //





	public function masalah_pokok(Request $request){
		$meta_urusan=Hp::fokus_urusan();
		$tahun=Hp::fokus_tahun();
		$data=MASALAHPOKOK::where(
			[
				'id_urusan'=>$meta_urusan['id_urusan'],
				'tahun'=>$tahun
			]
		)
		->select(DB::RAW("
			max(id) as id,
			uraian,
			count(distinct(kode_daerah)) as jumlah_pemda

		"))
		->groupBy('uraian')->get();

		return view('integrasi.permasalahan.masalah_pokok')->with('data',$data);
	}


     public function resume($id,Request $request){

    	if($request->pdf){
    		$urai_pok=MASALAHPOKOK::find($id);

    		if($urai_pok){
	    		$tahun=Hp::fokus_tahun();
		    	$meta_urusan=Hp::fokus_urusan();
		    	$data=DB::table('public.ms_pokok as pok')->LeftJoin(
		    		'public.ms as ms','ms.id_ms_pokok','=','pok.id'
		    	)
		    	->LeftJoin(
		    		'public.ms_akar as ms_akar','ms_akar.id_ms','=','ms.id'
		    	)

		    	->where(
		    		[
		    			'pok.uraian'=>$urai_pok['uraian'],
		    			'pok.id_urusan'=>$meta_urusan['id_urusan'],
		    			'pok.tahun'=>$tahun
		    		]
		    	)
		    	->select(
		    		DB::raw("
		    			max(pok.uraian) as urai_pokok,
		    			pok.kode_daerah as kode_daerah,
		    			count(ms.id) as ms_count,
		    			(select nama from public.master_daerah where id=pok.kode_daerah limit 1) as nama_daerah,
		    			(select nama from public.master_daerah where id=left(pok.kode_daerah,2) and length(pok.kode_daerah)>2 limit 1) as nama_provinsi,
		    			count(ms_akar.id) as ms_akar_count
		    			")

		    	)
		    	->groupBy('pok.kode_daerah')
		    	->get()->toArray();
		    	

		    	$title='RESUME  PERMASALAHAN URUSAN '.$meta_urusan['nama'].' TAHUN '.$tahun;
		    		 $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape')->setOptions(['dpi' => 200, 'enable_php'=>true,'isRemoteEnabled' => true]);
		                $pdf->loadHTML(view('integrasi.permasalahan.resume_ex')->with(['meta'=>(array)$data[0],'data'=>$data,'title'=>$title])->render());
		                return $pdf->stream($title.'.pdf');
	    		}
    		
    	}

    }
}
