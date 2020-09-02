<?php

namespace App\Http\Controllers\MONEVDOKRENDA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hp;
use DB;
use Alert;
class monevdokrenda extends Controller
{
    function index(){
		$urusan=Hp::fokus_urusan();
		DB::enableQueryLog();
$data=DB::table('master_daerah as a')
			->select('id','nama',DB::Raw('(Select nama from master_daerah where id=left(a.id,2)) as provinsi,(select count(*) from rkpd.master_2020_program where kodepemda=a.id and  id in (select id_program_rkpd from rpjmd.pemetaan_perencanaan k left join rpjmd.rpjmd_program l on k.id_program_rpjmd =l.id left join rpjmd.rpjmd_sasaran m on l.id_sasaran =m.id left join rpjmd.rpjmd_misi n on m.id_misi =n.id where n.id_urusan ='.$urusan["id_urusan"].')) as jumlah'))
			->orderByRaw('left(a.id,2)')
			->orderByRaw('a.id')
			->get();
//dd(DB::getQueryLog());
	return	view('monevdokrenda.index')->with('data',$data);
	
	}
	function monev($kodepemda){
			$urusan=Hp::fokus_urusan();
			$tahun=HP::fokus_tahun();
			DB::enableQueryLog();
			$pemda=DB::table('master_daerah')
				->where('id',$kodepemda)
				->pluck('nama');
			$data=DB::table('rkpd.master_'.$tahun.'_program as a')
			->select(DB::Raw("a.id as id_program,b.id as id_kegiatan,c.id as id_indikator_kegiatan,a.tahun as tahun,case when row_number() over(partition by a.id order by a.id,b.id,c.id)=1 then  
a.uraiprogram else '' end as program,
case when row_number() over(partition by b.id order by b.id,c.id)=1 then b.kodekegiatan else '' end  as kode,
case when row_number() over(partition by b.id order by b.id,c.id)=1 then b.uraikegiatan else '' end  as kegiatan,c.tolokukur as indikator,
c.target as target,c.satuan as satuan,concat(d.progres,' %') as progres,d.permasalahan as permasalahan,d.tindak_lanjut as tindak_lanjut,d.id as id_progres"))
			->leftJoin('rkpd.master_'.$tahun.'_kegiatan as b','a.id','=','b.id_program')
			->leftJoin('rkpd.master_'.$tahun.'_kegiatan_indikator as c','b.id','=','c.id_kegiatan')
			->leftJoin('rkpd.tb_progres_'.$tahun.' as d','d.id_kegiatan','=','c.id')
			->where('a.kodepemda',$kodepemda)
			->whereRaw('a.id in(select id_program_rkpd from rpjmd.pemetaan_perencanaan k left join rpjmd.rpjmd_program l on k.id_program_rpjmd =l.id left join rpjmd.rpjmd_sasaran m on l.id_sasaran =m.id left join rpjmd.rpjmd_misi n on m.id_misi =n.id where n.id_urusan ='.$urusan["id_urusan"].')')
			->get();
			//dd(db::getQueryLog());
			
	return	view('monevdokrenda.monev')->with('data',$data)->with('pemda',$pemda[0]);
	}
	function insert($id){
		return view('monevdokrenda.insert')->with('id',$id);
	}
	function update($id){
		$tahun=Hp::fokus_tahun();
		DB::enableQueryLog();
		$data=DB::table('rkpd.tb_progres_'.(int)$tahun)
				->where('id',$id)
				->first();
		return view('monevdokrenda.update')->with('id',$id)->with('progres',$data->progres)->with('permasalahan',$data->permasalahan)->with('tindak_lanjut',$data->tindak_lanjut)->with('tanggal',$data->tanggal);
	}
	function insert_commit(Request $request){
		$tahun=Hp::fokus_tahun();
		$data=DB::table('rkpd.tb_progres_'.(int)$tahun)
				->insertOrIgnore([
				'id_kegiatan'=>$request->id_kegiatan,'progres'=>$request->progres,'permasalahan'=>$request->permasalahan,
				'tindak_lanjut'=>$request->tindak_lanjut,'tanggal'=>$request->tanggal
				]);
		if($data){
    		Alert::success('Success','Berhasil Menambahkan Indikator');
			return back();
		}else{
			Alert::error('Gagal','Ada kesalahan pada saat penginputan');
	    		return back();
		}
			
	}
	function update_commit(Request $request){
		$tahun=Hp::fokus_tahun();	
		$data=DB::table('rkpd.tb_progres_'.(int)$tahun)
				->where('id',$request->id_progres)
				->update(['progres'=>$request->progres,'permasalahan'=>$request->permasalahan,'tindak_lanjut'=>$request->tindak_lanjut,'tanggal'=>$request->tanggal]);
				if($data){
				Alert::success('Success','Berhasil Merubah Data');
				return back();
				}
				else{
				Alert::error('Gagal','Ada Permasalahan pada saat penginputan')	;
				return back();
				}
	}
	function delete($id){
		$tahun=Hp::fokus_tahun();
		$data=DB::table('rkpd.tb_progres_'.(int)$tahun)
				->where('id',$id)
				->delete();
				if($data){
					Alert::success('Berhasil','Data Telah Dihapus');
					return back();
				} else{
					Alert::error('Gagal','Ada Masalah saat menghapus data');
					return bcak();
				}
	}
}
