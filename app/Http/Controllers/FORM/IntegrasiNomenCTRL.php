<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hp;
use Carbon\Carbon;
use Alert;

class IntegrasiNomenCTRL extends Controller
{
    //

    public function index_pro(){

    	$tahun=Hp::fokus_tahun();
        Hp::checkdb($tahun);

        $id_urusan=Hp::fokus_urusan()['id_urusan'];
    	$data=DB::table('master_daerah as d')
    	->where(DB::raw("length(d.id)"),'=',2)
    	->select('d.*',
    		DB::raw("(
    			select count(*) from map_nomen_pro_".$tahun." as mp_nom  
    			join master_nomenklatur_provinsi as np on np.id=mp_nom.id_nomen and np.jenis in ('kegiatan','sub_kegiatan')
    			where  mp_nom.kode_daerah=d.id
    		) as jumlah_kegiatan ")
    	)
    	->orderBy('d.nama','ASC')
    	->paginate(10);


    	return view('form.integrasi.pro.nomen.index')->with('data',$data);
    }

    public function detail_pro($id,Request $request){
    	$daerah=DB::table('master_daerah')->where('id',$id)->first();
    	if($daerah){
    		$tahun=Hp::fokus_tahun();
        	$id_urusan=Hp::fokus_urusan()['id_urusan'];

        	Hp::checkdb();
    		$data=[];
            DB::enableQueryLog();
    		

            $data=DB::table(DB::raw("map_nomen_pro_".$tahun." as np"))
            ->join('master_nomenklatur_provinsi as mnp','mnp.id','=','np.id_nomen')
            ->join('ind_nomen_prokeg_pro as smp','smp.id_nomen','=','np.id_nomen','full outer')
            ->join('master_ind_psn as ind','ind.id','=','smp.id_ind_psn','full outer')
            ->where('np.kode_daerah',$id)
            ->where('np.tahun',$tahun)
            ->select(
                "np.kode_daerah",
                "ind.id_pn",
                "ind.id as id_ind",
                "ind.id_pp",
                "ind.id_kp",
                "ind.id_propn",
                "ind.id_psn",
                DB::raw("(select nama from master_pn as  a where a.id=ind.id_pn limit 1) as nama_pn"),
                DB::raw("(select nama from master_pp as  a where a.id=ind.id_pp limit 1) as nama_pp"),
                DB::raw("(select nama from master_kp as  a where a.id=ind.id_kp limit 1) as nama_kp"),
                DB::raw("(select nama from master_propn as  a where a.id=ind.id_propn limit 1) as nama_propn"),
                DB::raw("(select nama from master_psn as  a where a.id=ind.id_psn limit 1) as nama_psn"),
                'ind.uraian as nama_indikator',
                DB::raw("(select kode from master_satuan ms where ms.id=ind.id_satuan) as satuan"),
                DB::raw("(select target from ind_psn_target ipt  where ipt.id_ind_psn =ind.id and ipt.tahun=".$tahun.") as target_pusat"),
                "mnp.kode as kode",
                "mnp.id as id_nomen",
                'mnp.jenis',
                DB::raw("(select nomenklatur from master_nomenklatur_provinsi as nm where nm.kode=concat(mnp.urusan,'.',mnp.bidang_urusan,'.',mnp.program) and nm.jenis='program') as nama_program"),
                DB::raw("(case when mnp.jenis='kegiatan' then mnp.nomenklatur else (select nomenklatur from master_nomenklatur_provinsi as nm where nm.kode=concat(mnp.urusan,'.',mnp.bidang_urusan,'.',mnp.program,'.',mnp.kegiatan) and nm.jenis='kegiatan') end) as nama_kegiatan"),
                DB::raw("(case when mnp.jenis='sub_kegiatan' then mnp.nomenklatur else null end) as nama_sub_kegiatan")
            )
            ->orderBy('mnp.kode','asc')
            ->orderBy('ind.id_psn','asc');
            if($request->q){
                $data=$data->where('mnp.nomenklatur','ilike',('%'.$request->q.'%'));
            }

            $data=$data->paginate(10)->appends(['q'=>$request->q]);

            



        	return view('form.integrasi.pro.nomen.detail')->with('data',$data)->with('daerah',$daerah);

    	}

    	return abort('404');
    }


    public function store_pel_nomen_pro(Request $request,$id){

    	$tahun=Hp::fokus_tahun();
        Hp::checkdb($tahun);
        $result=[];
        $id_urusan=Hp::fokus_urusan()['id_urusan'];

    	foreach ($request->id as $key => $d) {

    	$result[]=DB::table('map_nomen_pro_'.$tahun." as nm")->insertOrIgnore([
    		'id_nomen'=>$d,
    		'nomen'=>$key,
    		'kode_daerah'=>$id,
    		'created_at'=>Carbon::now(),
    		'updated_at'=>Carbon::now(),
    		'tahun'=>$tahun

    		]);
    		# code...
    	}

    	if(count($result)){
    		Alert::success('success');
    		return back();
    	}

    	
    }
}
