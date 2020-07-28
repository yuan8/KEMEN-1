<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use App\RKPD\PROGRAM;
use DB;
use Auth;
class PROGRAMKEGIATAN extends Controller
{
    //


	public function update_target(Request $request){

		if($request->jenis=='K'){
			$uid=Auth::User()->id;


			DB::connection('meta_rkpd')->table('meta_rkpd.indikator_kegiatan_'.$request->tahun)->updateOrInsert([
				'id_indikator'=>$request->id
			],[

				'id_indikator'=>$request->id,
				'target'=>$request->target,
				'satuan'=>$request->satuan,
				'id_user'=>$uid
			]);

			return array('code'=>200);
		}else{
			$tahun=HP::fokus_tahun();
			$uid=Auth::User()->id;

			DB::connection('meta_rkpd')->table('meta_rkpd.indikator_program_'.$request->tahun)->updateOrInsert([
				'id_indikator'=>$request->id
			],[

				'id_indikator'=>$request->id,
				'target'=>$request->target,
				'satuan'=>$request->satuan,
				'id_user'=>$uid
			]);

			return array('code'=>200);

		}

	}

    public function index(){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();

    	$data=DB::connection('rkpd')->table('public.master_daerah as d')
    	->leftJoin(DB::RAW("(select kodepemda,count(*) as jumlah_kegiatan from rkpd.master_".$tahun."_kegiatan where id_urusan=".$meta_urusan['id_urusan']." group by kodepemda ) as k"),'k.kodepemda','=','d.id')
    	->select(DB::RAW("*"))
    	->get();
    
    	return view('integrasi.prokeg.index')->with('data',$data);
    }


    public function detail($id){
    	$tahun=Hp::fokus_tahun();
    	$meta_urusan=Hp::fokus_urusan();


    	$data=[];
    	$data=DB::connection('rkpd')->table("rkpd.master_".$tahun."_program as p")
    	->leftJoin(DB::RAW("rkpd.master_".$tahun."_program_capaian as pi"),'pi.id_program','=','p.id')
    	->leftJoin(DB::RAW("meta_rkpd.indikator_program_".$tahun." as pix"),'pix.id_indikator','=','pi.id')
    	->join(DB::RAW("rkpd.master_".$tahun."_kegiatan as k"),'k.id_program','=','p.id')
    	->leftJoin(DB::RAW("rkpd.master_".$tahun."_kegiatan_indikator as ki"),'ki.id_kegiatan','=','k.id')
    	->leftJoin(DB::RAW("meta_rkpd.indikator_kegiatan_".$tahun." as kix"),'kix.id_indikator','=','ki.id')
    	->where('k.id_urusan',$meta_urusan['id_urusan'])
    	->where('k.kodepemda',$id)
    	->where('p.kodepemda',$id)
    	->select(DB::RAW("
    		p.kodepemda as kodepemda,
    		p.id as id_p,
    		p.kodeprogram as kode_p,
    		p.uraiprogram as urai_p,
    		pi.id as id_pi,
    		pi.kodeindikator as kode_pi,
    		pi.tolokukur as urai_pi,
    		pi.target as target_pi,
    		pi.satuan as satuan_pi,
    		pix.id_indikator as id_pix,
    		pix.target as target_pix,
    		pix.satuan as satuan_pix,
    		k.id as id_k,
    		k.kodekegiatan as kode_k,
    		k.uraikegiatan as urai_k,
    		ki.id as id_ki,
    		ki.kodeindikator as kode_ki,
    		ki.tolokukur as urai_ki,
    		ki.target as target_ki,
    		ki.satuan as satuan_ki,
    		kix.id_indikator as id_kix,
    		kix.target as target_kix,
    		kix.satuan as satuan_kix
    	"))
    	->orderBy('p.id','asc')
    	->orderBy('pi.id_program','asc')
    	->orderBy('pi.id','asc')
    	->orderBy('pix.id_indikator','asc')
    	->orderBy('k.id','asc')
    	->orderBy('ki.id_kegiatan','asc')
    	->orderBy('ki.id','asc')
    	->orderBy('kix.id_indikator','asc')
    	->get();
    	$daerah=DB::table('master_daerah')->find($id);

    	return view('integrasi.prokeg.detail')->with(['data'=>$data])->with('daerah',$daerah);



    }



}
