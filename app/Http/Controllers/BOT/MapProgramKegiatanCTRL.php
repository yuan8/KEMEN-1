<?php

namespace App\Http\Controllers\BOT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use DB;
use Hp;
class MapProgramKegiatanCTRL extends Controller
{
    //

    public function UpdateMap($tahun=2020){
    	set_time_limit(-1);
    	$file=scandir(storage_path('app/bot-sipd/pengkodean_bidang_daerah/'));
    	unset($file[0]);
    	unset($file[1]);

    	foreach ($file as $key => $name) {
    		$kode_daerah=explode('.', $name)[0];
    		$kode=file_get_contents(storage_path('app/bot-sipd/pengkodean_bidang_daerah/'.$name));
    		$kode=json_decode($kode,true);
    		$put=0;
    		$new=[];
			$chek=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_urusan')
			->where('kode_daerah',$kode_daerah)->first();

    		if(!$chek){
    			foreach ($kode as $k=> $d) {
    			# code...
    			$new_p=array(
    				'kode_daerah'=>$kode_daerah,
    				'uraian_urusan_daerah'=>$d['nama'],
    				'kode_urusan'=>$d['kode'],
    				'id_urusan'=>null
    			);

    		
    			try { 
    				

    				$bidang=DB::table('master_urusan')->where('nama','ilke',(string)$d['nama'])->first();
    				
    				
    			}catch(\Illuminate\Database\QueryException $ex){


    			}
    			
    			if($bidang){
    				$put+=1;
    				$kode[$k]['id_urusan']=$bidang->id;
    				$kode[$k]['uraian_bidang']=$bidang->nama;
    				$new_p['id_urusan']=($bidang->id);
    				try { 

	    				DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_urusan')
	    				->updateOrInsert(
	    					[
	    						'kode_daerah'=>$kode_daerah,
	    						'kode_urusan'=>$new_p['kode_urusan']
	    					],
	    					$new_p
	    				);
    				}catch(\Illuminate\Database\QueryException $ex){
    				}

    			}

    			$new[]=$new_p;
    		}

    		if(($put)>0){
    			Storage::put('bot-sipd/pengkodean_bidang_daerah/'.$name,json_encode($kode,JSON_PRETTY_PRINT));
    			}
    		}
    		\App\Http\Controllers\CROW\SIPDCTRL::updateDb($kode_daerah,$tahun);

    	}

    	
    }
}
