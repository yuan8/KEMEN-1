<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
use Validator;
use Hp;

class ProgramKegiatanCtrl extends Controller
{
    //

	public function  api_get_daerah(){
		$tahun=Hp::fokus_tahun();
		$id_urusan=Hp::fokus_urusan()['id_urusan'];

		$schema='prokeg';
		$data=DB::table('master_daerah as d')
		->select(
			'd.id','d.nama',
			DB::raw("(case when d.kode_daerah_parent is null then 1 else 0 end) as is_provinsi"),
			DB::raw("count(k.id) as jumlah_kegiatan")
		)
		->leftJoin(DB::raw($schema.".tb_".($tahun-1)."_kegiatan as k"),function($q) use ($id_urusan){
			return $q->on('k.kode_daerah','=','d.id');
			// ->on('k.id_urusan','=',DB::raw($id_urusan));
		})
		->groupBy('d.id')
		->orderBy(DB::raw("count(k.id)"),'DESC')
		->get();

		return ($data);

		// $data=DB::table('master_sub_urusan')
		// ->where('id_urusan',Hp::fokus_urusan()['id_urusan'])
		// ->orderBy('id','DESC')
		// ->get();
		
		// return view('form.program-kegiatan.index')->with('data',$data);
	}

	public function index(){
		$data='';
		$tahun=Hp::fokus_tahun();
		$id_urusan=Hp::fokus_urusan()['id_urusan'];
		Hp::checkDBProKeg((int)$tahun-1);

		return view('form.program-kegiatan.index')->with('data',$data);


	}

	public function detail($id=null,Request $request){
		if($id){
			$tahun=Hp::fokus_tahun();
			$tahun2=$tahun-1;
			$id_urusan=Hp::fokus_urusan()['id_urusan'];
			$daerah=DB::table('master_daerah')->find($id);
			if($daerah){
				$data=DB::connection('sink_prokeg')->table('tb_'.$tahun2.'_kegiatan as k')
				->join(DB::raw('tb_'.$tahun2.'_program as p'),'p.id','=','k.id_program')
				->leftJoin(DB::raw('tb_'.$tahun2.'_ind_program as ip'),'ip.id_program','=','p.id')
				->leftJoin(DB::raw('tb_'.$tahun2.'_ind_kegiatan as ik'),'ik.id_kegiatan','=','k.id')				
				->select(
					'p.id as id_program',
					'p.uraian as uraian_program',
					'k.id as id_kegiatan',
					'k.uraian as uraian_kegiatan',
					'k.kode_kegiatan as nomenklatur_kegiatan',
					'k.anggaran as anggran_kegiatan',
					'k.id_urusan as id_urusan',
					DB::raw("(select nama from public.master_urusan as u where u.id=k.id_urusan ) as uraian_urusan"),
					DB::raw("(select nama from public.master_sub_urusan as su where su.id=k.id_sub_urusan ) as uraian_sub_urusan"),
					'ip.indikator as ind_p',
					'ip.id as id_ind_p',
					'ip.target_awal as ind_p_target',
					'ip.satuan as ind_p_satuan',
					'ip.anggaran as ind_p_anggaran',
					'ik.indikator as ind_k',
					'ik.id as id_ind_k',
					'ik.target_awal as ind_k_target',
					'ik.satuan as ind_k_satuan',
					'ik.anggaran as ind_k_anggaran'
				)
				->orderBy('p.id','asc')
				->orderBy('ip.id','asc')
				->orderBy('k.id','asc')
				->orderBy('ik.id','asc');
				


				if($request->q){
					$data=$data->where([
						['k.kode_daerah','=',$id],
						['k.id_urusan','=',$id_urusan],
						['k.id_sub_urusan','!=',null],
						['k.uraian','ilike',('%'.$request->q.'%')]
					]);

				}else{
					$data=$data->where([
						['k.kode_daerah','=',$id],
						['k.id_urusan','=',$id_urusan],
						['k.id_sub_urusan','!=',null],
					]);

				}
				
				$data=$data->paginate(10)->appends(['q'=>$request->q]);
				
				return view('form.program-kegiatan.detail')->with([
					'data'=>$data,
					'daerah'=>$daerah,
					'back_link'=>route('program.kegiatan.index')
				]);
			}
		}




	}

	public function detail_pemetaan($id,Request $request){

			$tahun=Hp::fokus_tahun();
			$tahun2=$tahun-1;
			$id_urusan=Hp::fokus_urusan()['id_urusan'];
			$daerah=DB::table('master_daerah')->find($id);
			if($daerah){
				$sub=DB::table('master_sub_urusan')->where('id_urusan',$id_urusan)->get();
				// DB::connection('sink_prokeg')->enableQueryLog();

				$data=DB::connection('sink_prokeg')->table('tb_'.$tahun2.'_kegiatan as k')
				->join(DB::raw('tb_'.$tahun2.'_program as p'),'p.id','=','k.id_program')
								
				->select(
					'p.id as id_program',
					'p.uraian as uraian_program',
					'k.id as id_kegiatan',
					'k.uraian as uraian_kegiatan',
					'k.kode_kegiatan as nomenklatur_kegiatan',
					'k.id_urusan',
					'k.id_sub_urusan',
					DB::raw("(select nama from public.master_urusan as u where u.id=k.id_urusan ) as uraian_urusan"),
					DB::raw("(select nama from public.master_sub_urusan as su where su.id=k.id_sub_urusan ) as uraian_sub_urusan")
					
				)
				->orderBy('p.id','asc')
				->orderBy('k.id_program','asc')
				->orderBy('k.id','asc');
				if($request->q){

					$data=$data->where([
						['k.kode_daerah','=',$id],
						['k.id_urusan','=',$id_urusan],
						['k.uraian','ilike',('%'.$request->q.'%')]
						
					])
				
					->orWhere([
						['k.kode_daerah','=',$id],
						['k.id_urusan','=',null],
						['k.uraian','ilike',('%'.$request->q.'%')]

					]);

				}else{

					$data=$data->where([
						['k.kode_daerah','=',$id],
						['k.id_urusan','=',$id_urusan]
					])
				
					->orWhere([
						['k.kode_daerah','=',$id],
						['k.id_urusan','=',null],
					]);
				}
				
				

				$data=$data->paginate(15)->appends(['q'=>$request->q]);
				// dd(DB::connection('sink_prokeg')->getQueryLog());

				return view('form.program-kegiatan.detail_peta')->with([
					'data'=>$data,
					'daerah'=>$daerah,
					'sub'=>$sub,
					'back_link'=>route('pk.detail',['id'=>$daerah->id])
				]);

			}
		}

	
		public function store_pemetaan($id,Request $request){
			$data=array_filter($request->sub);
			$tahun=Hp::fokus_tahun();
			$tahun2=$tahun-1;
			$id_urusan=Hp::fokus_urusan()['id_urusan'];
			$daerah=DB::table('master_daerah')->find($id);
			if($daerah){
				foreach($data as $i=>$d){
					DB::connection('sink_prokeg')->table('tb_'.$tahun2.'_kegiatan')
					->where('id_sub_urusan',null)
					->where('id',$i)
					->update([
						'id_urusan'=>$id_urusan,
						'id_sub_urusan'=>$d
					]);
				}
			
				Alert::success('Berhasil','Data di Perbarui');
				return back();
			}

		}
}
