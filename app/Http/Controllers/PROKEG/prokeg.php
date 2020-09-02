<?php

namespace App\Http\Controllers\prokeg;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hp;
use Alert;
use App\pemetaanperencanaan;

class prokeg extends Controller
{
   public function index_prokeg()
   {

        $urusan=\Hp::fokus_urusan();
		$tahun=\Hp::fokus_tahun();
					DB::enableQueryLog();
          // dd

	   $tabel_prokeg=DB::table('master_daerah as a')
	   ->select(DB::Raw("id,(select nama from public.master_daerah b where id=left(a.id,2)) as provinsi, nama ,
(select count(*) from rpjmd.rpjmd_misi where tahun=".(int)$tahun." and kode_daerah=a.id::integer and id_urusan=".$urusan['id_urusan'].") as jumlah_kegiatan"))
	   ->get();
//dd(DB::getQueryLog());
return view('prokeg.index')->with('data',$tabel_prokeg);
   }
public function detail_prokeg(Request $request)
   {
      	$urusan=\Hp::fokus_urusan();
		$tahun=\Hp::fokus_tahun();
		$namapemda=$request->namapemda;
					DB::enableQueryLog();
//dd($request);
	   $tabel_prokeg=DB::table('rpjmd.rpjmd_misi as a')
	   ->select(DB::Raw("a.kode_daerah as kode_daerah,a.id as id_misi,b.id as id_sasaran,d.id as id_program_rkpd,c.id as id_program,
            case when row_number() over(partition by a.id order by a.id)=1 then a.misi else '' end as misi,
      case when row_number() over(partition by b.id order by b.id)=1 then b.sasaran else '' end as sasaran,
      case when row_number() over(partition by c.id order by c.id)=1 then c.program_daerah else '' end as program_daerah,
      case when row_number() over(partition by d.id order by d.id)=1 then e.uraiprogram else '' end as program_rkpd,
      case when row_number() over(partition by f.id order by f.id)=1 then f.uraikegiatan else '' end as kegiatan,
      case when row_number() over(partition by f.id order by g.id)=1 then g.tolokukur else '' end as indikator,
      case when row_number() over(partition by f.id order by g.id)=1 then g.target else '' end as target,
      case when row_number() over(partition by f.id order by g.id)=1 then g.satuan else '' end as satuan"))
->leftJoin('rpjmd.rpjmd_sasaran as b','a.id','=','b.id_misi')
->leftJoin('rpjmd.rpjmd_program as c','b.id','=','c.id_sasaran')
->leftJoin('rpjmd.pemetaan_perencanaan as d','c.id','=','d.id_program_rpjmd')
->leftJoin('rkpd.master_'.(int)$tahun.'_program as e','e.id','=','d.id_program_rkpd')
->leftJoin('rkpd.master_'.(int)$tahun.'_kegiatan as f','f.id_program','=','e.id')
->leftJoin('rkpd.master_'.(int)$tahun.'_kegiatan_indikator  as g','f.id','=','g.id_kegiatan')
->where('a.id_urusan' ,$urusan['id_urusan'])
->where('a.tahun' ,(int)$tahun)
->where('a.kode_daerah' ,$request->id)
->orderByRaw('id_misi,id_sasaran')
	   ->get();
//	dd(DB::getQueryLog());
return view('prokeg.prokeg')->with('data',$tabel_prokeg)->with('namapemda',$namapemda)->with('tahun',(int)$tahun)->with('kodepemda',$request->id);
   }
   public function tambah_misi(Request $request){

	   return view('prokeg.partials.input')->with('kodepemda',$request->id);
   }
   public function insert_misi(Request $request){
	   $tahun=Hp::fokus_tahun();
    	$urusan=Hp::fokus_urusan();

		//$data=DB::table('form.pemetaan_kebijakan')->where(['tahun'=>$tahun,'id_user'=>$uid['id_urusan']])->first();
		//dd($request);


    		if($request->kodepemda){
    			DB::table('rpjmd.rpjmd_misi')->insertOrIgnore(
    ['kode_daerah' => $request->kodepemda, 'id_urusan' => $urusan['id_urusan'],'tahun'=> (int)$tahun, 'misi'=>$request->uraian ]
);

	    		Alert::success('Success','Berhasil Menambahkan Indikator');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menambahkan Indikator');
	    		return back();

    		}
    	}
	public function tambah_sasaran($id){
			return	view('prokeg.partials.inputsasaran')->with('id',$id);
	}
	public function insert_sasaran(Request $request){
	   $tahun=Hp::fokus_tahun();
    	$urusan=Hp::fokus_urusan();

		//$data=DB::table('form.pemetaan_kebijakan')->where(['tahun'=>$tahun,'id_user'=>$uid['id_urusan']])->first();
		//dd($request);


    		if($request->kodepemda){
    			DB::table('rpjmd.rpjmd_sasaran')->insertOrIgnore(
    ['id_misi' => $request->kodepemda,  'sasaran'=>$request->uraian ]
);

	    		Alert::success('Success','Berhasil Menambahkan Indikator');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menambahkan Indikator');
	    		return back();

    		}
    	}
	public function tambah_program($id){
			return	view('prokeg.partials.inputprogram')->with('id',$id);
	}
	public function insert_program(Request $request){
	   $tahun=Hp::fokus_tahun();
    	$urusan=Hp::fokus_urusan();

		//$data=DB::table('form.pemetaan_kebijakan')->where(['tahun'=>$tahun,'id_user'=>$uid['id_urusan']])->first();
		//dd($request);


    		if($request->kodepemda){
    			DB::table('rpjmd.rpjmd_program')->insertOrIgnore(
    ['id_sasaran' => $request->kodepemda,  'program_daerah'=>$request->uraian ]
);

	    		Alert::success('Success','Berhasil Menambahkan Indikator');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menambahkan Indikator');
	    		return back();

    		}
    	}
		public function ubah_sasaran($id){
			$data=DB::table('rpjmd.rpjmd_sasaran')
			->select('id','sasaran')
			->where('id',$id)
			->first();
			//dd($data->sasaran);
			return view('prokeg.partials.updatesasaran')->with('data',$data);
		}
		public function update_sasaran(Request $request){
			if($request->id){
			DB::table('rpjmd.rpjmd_sasaran')
              ->where('id', $request->id)
              ->update(['sasaran' => $request->uraian]);
			 // dd(DB::getQueryLog());
				Alert::success('Success','Berhasil Menambahkan sasaran');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menambahkan Sasaran');
	    		return back();

			}

		}
		public function hapus_sasaran($id){
			if($id){
				DB::table('rpjmd.rpjmd_sasaran')->where('id',$id)->delete();
				Alert::success('Success','Berhasil Menghapus Sasaran');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menghapus Sasaran');
	    		return back();

			}

		}
		public function ubah_misi($id){
			$data=DB::table('rpjmd.rpjmd_misi')
			->select('id','misi')
			->where('id',$id)
			->first();
			//dd($data->sasaran);
			return view('prokeg.partials.updatemisi')->with('data',$data);
		}
		public function update_misi(Request $request){
			if($request->id){
			DB::table('rpjmd.rpjmd_misi')
              ->where('id', $request->id)
              ->update(['misi' => $request->uraian]);
			 // dd(DB::getQueryLog());
				Alert::success('Success','Berhasil Mengubah Misi');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Mengubah Misi');
	    		return back();

			}

		}
		public function ubah_program($id){
			$data=DB::table('rpjmd.rpjmd_program')
			->select('id','program_daerah')
			->where('id',$id)
			->first();
			//dd($data->sasaran);
			return view('prokeg.partials.updateprogram')->with('data',$data);
		}
		public function update_program(Request $request){
			if($request->id){
			DB::table('rpjmd.rpjmd_program')
              ->where('id', $request->id)
              ->update(['program_daerah' => $request->uraian]);
			 // dd(DB::getQueryLog());
				Alert::success('Success','Berhasil Mengubah Program');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Mengubah Program');
	    		return back();

			}

		}
		public function hapus_misi($id){
			if($id){
				DB::table('rpjmd.rpjmd_misi')->where('id',$id)->delete();
				Alert::success('Success','Berhasil Menghapus Misi');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menghapus Misi');
	    		return back();

			}
		}
public function hapus_program($id){
			if($id){
				DB::table('rpjmd.rpjmd_program')->where('id',$id)->delete();
				Alert::success('Success','Berhasil Menghapus Program');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menghapus Program');
	    		return back();

			}
		}
public function hapus_program_rkpd($id){
			if($id){
				DB::table('rpjmd.pemetaan_perencanaan')->where('id',$id)->delete();
				Alert::success('Success','Berhasil Menghapus Program');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Menghapus Program');
	    		return back();

			}
		}
public function pemetaan_program($id,$kodepemda){
	$tahun=Hp::fokus_tahun();
	DB::enableQueryLog();
	$program_rpjmd=DB::table('rpjmd.rpjmd_program')
			->where('id',$id)
			->pluck('program_daerah');
	$program_exist=DB::table('rpjmd.pemetaan_perencanaan as a')
			->select('a.id as id','a.id_program_rpjmd as id_rpjmd','a.id_program_rkpd as id_rkpd','b.kodeprogram as kodeprogram','b.uraiprogram as uraiprogram')
			->leftJoin('rkpd.master_'.$tahun.'_program as b', 'a.id_program_rkpd','b.id')
			->where('id_program_rpjmd',$id)
			->get();

	$nama=DB::table('master_daerah as a')
			->where('id',$kodepemda)
			->first();
	$program=DB::table('rkpd.master_'.(int)Hp::fokus_tahun().'_program as a')
			->where('kodepemda',$kodepemda)
			->get();
			//dd($program_exist);
			return view('prokeg.prokegpemetaan')->with('id',$id)->with('kodepemda',$kodepemda)->with('program',$program)->with('namapemda',$nama->nama)->with('tahun',(int)Hp::fokus_tahun())->with('program_rpjmd',$program_rpjmd[0])->with('exist',$program_exist) ;
		}
public function insert_pemetaan_program(Request $request){
		$tahun=Hp::fokus_tahun();
    	$uid=Hp::fokus_urusan();
    	DB::enableQueryLog();

    		if($request->id_rkpd){
			foreach ($request->id_rpjmd as $key => $j)
			{
				$id_rpjmd=$j;

			}

    			foreach ($request->id_rkpd as $key => $i) {
				$id_rkpd=$i;
				if(!(pemetaanperencanaan::where(['id_program_rpjmd'=>$id_rpjmd,'id_program_rkpd'=>$id_rkpd])->first())){
	    				pemetaanperencanaan::insertOrIgnore(['id_program_rpjmd'=>$id_rpjmd,'id_program_rkpd'=>$id_rkpd]);

	    			}

	    		}

	    		Alert::success('Success','Berhasil Memetakan Program');
	    		return back();
    		}else{
    			Alert::error('Gagal','Gagal Mememetakan Program');
	    		return back();

    		}
    	}


}
