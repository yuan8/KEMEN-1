<?php

namespace App\Http\Controllers\SISTEM_RKPD\RKPD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hp;
class RKPD extends Controller
{
    //

    public function index(){
    	$tahun=Hp::fokus_tahun();
    	$id_urusan=Hp::fokus_urusan()['id_urusan'];

    	$data=DB::connection('rkpd')->table('rkpd.master_'.$tahun.'_program as p')
    	->LeftJoin('rkpd.master_'.$tahun.'_kegiatan as k','k.id_program','=','p.id')
    	->LeftJoin('rkpd.master_'.$tahun.'_status_data as sd','sd.kodepemda','=','p.kodepemda')
    	->LeftJoin('rkpd.master_'.$tahun.'_status as st','st.kodepemda','=','p.kodepemda')

    	->select(
    		DB::raw("
    			p.kodepemda,
    			max(sd.status_data) as status_data,
    			(case when (max(st.status)=max(sd.status_data)) then 1 else 0 end) as status_relevan,
    			(case when (max(st.anggaran)::float=sum(k.pagu)::float) then 1 else 0 end) as anggaran_relevan,
    			max(sd.push_date) as push_date,
    			(select nama from public.master_daerah where id=p.kodepemda) as nama_pemda,
    			sum(k.pagu)::float as pagu,
    			max(st.anggaran)::float as relevan_anggaran,
    			max(st.status) as relevan_satatus,
    			max(st.last_date) as relevan_push


    		")
    	)->where(['k.status'=>5,'p.status'=>5])
    	
		->groupBy('p.kodepemda')
		->paginate(20);

		dd($data);


    }
}
