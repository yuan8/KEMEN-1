<?php

namespace App\Http\Controllers\CROW;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use HP;
use Storage;
use Carbon\Carbon;
class RAKORTEK extends Controller
{
    //

	static function  host(){
		if( strpos($_SERVER['HTTP_HOST'], '192.168.123.190') !== false) {

			return 'http://192.168.123.195/';

		}else{
			
			return 'https://sipd.go.id/';
		}

	}

	static $token='d1d1ab9140c249e34ce356c91e9166a6';


	static function getValue($val){
		$return=[null,null,'nocal'];

		if(strrpos($val, '-')!==false){
			$value=explode('-', $val);
			if(isset($value[0])){
				if(!ctype_alpha($value[0])){
					$return[0]=(float)$value[0];
					if(isset($value[1])){
						if(!ctype_alpha($value[1])){
							$return[1]=(float)$value[1];
							$return[2]='min_accept_range';

						}
					}
				}else{

					$return[0]=$val;
				}
			}

		}else{

			if(!ctype_alpha($val)){
				$return[0]=(float)$val;
				$return[2]='number';
			}else{
				$return[0]=$val;
			}

		}

		return $return;
	}

    public function getData($tahun,$kodepemda){

    	$kode_daerah=str_replace('00', '', $kodepemda);

    	if(strlen($kodepemda)==2){
    		$kodepemda.='00';
    	}

    	$code_list=[];

    	$data='[]';
    	if(file_exists(storage_path('app/public/BOT/SIPD/RAKORTEK/'.$tahun.'/'.$kode_daerah.'.json'))){
    		$data=file_get_contents(storage_path('app/public/BOT/SIPD/RAKORTEK/'.$tahun.'/'.$kode_daerah.'.json'));

    	}else{
		$opts = [
		    "http" => [
		        "method" => "GET",
		        "header" => "Authorization: Bearer ".static::$token
		    ]
		];

		$context = stream_context_create($opts);

		if(strlen($kodepemda)<4){
			$kodepemda=$kodepemda.'00';
		}

		$path=static::host().'run/serv/get_rakortek.php?tahun='.($tahun).'&kodepemda='.$kodepemda;
		$path=urldecode($path);
		$data=file_get_contents($path,false, $context);

    	}

    	$data=json_decode($data,true);
    	Storage::put('public/BOT/SIPD/RAKORTEK/'.$tahun.'/'.$kode_daerah.'.json',json_encode($data,JSON_PRETTY_PRINT));
    	$data_cal=$data;

    	if($request->langsung){
    			$daerah=DB::table('master_daerah')->where('id','>',$kode_daerah)
    			->first();

    		return view('bot.rakortek')->with('daerah',$daerah);

    	}
    	
    	return $data;



    	// $kode_daerah=str_replace('00', '', $data['kodepemda']);

    	foreach ($data['indikator kinerja urusan'] as $key => $d) {
    		if(!empty($d['nama_indikator'])){
    			$value=static::getValue($d['target_nasional']);
    			$kode_bidang=str_replace('P.','', str_replace('K.','',$d['bidang'][0]['kode_urusan']));
	    		DB::connection('sink_prokeg')->table('tb_'.$tahun.'_master_indikator')
	    		->insertOrIgnore([
	    			'kode'=>$d['kode_indikator'],
	    			'uraian'=>strtoupper($d['nama_indikator']),
	    			'target'=>$value[0],
	    			'target_max'=>$value[1],
	    			'data_type'=>$value[2],
	    			'satuan'=>$d['nama_satuan'],
	    			'id_urusan'=>(int)substr($kode_bidang,-2,2),
	    			'pelaksana'=>$kode_bidang,
	    			'jenis'=>'IKU',

	    		]);

	    		if(!empty($d['kegiatan_mendukung_kinerja_urusan'])){

	    			foreach ($d['kegiatan_mendukung_kinerja_urusan'] as  $k) {
	    				DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_kegiatan_indikator_pusat')
	    				->insertOrIgnore([
	    					'kode_daerah'=>$kode_daerah,
	    					'kode_kegiatan'=>$k['kode_kegiatan'],
	    					'kode_indikator'=>$d['kode_indikator'],
	    					'created_at'=>Carbon::now(),
	    					'updated_at'=>Carbon::now()
	    				]);

	    			}

	    		}

    		}
    	}


    	foreach ($data['indikator makro'] as $key => $d) {


    		if(!empty($d['nama_indikator'])){
    			$value=static::getValue($d['target_nasional_2020_2024']);

    			DB::connection('sink_prokeg')->table('tb_'.$tahun.'_master_indikator')
    		->insertOrIgnore([
    			'kode'=>$d['kode_indikator'],
    			'uraian'=>strtoupper($d['nama_indikator']),
    			'target'=>$value[0],
    			'target_max'=>$value[1],
    			'data_type'=>$value[2],
    			'satuan'=>$d['nama_satuan'],
    			'pelaksana'=>$d['bidang']!=''?(str_replace('P.','', str_replace('K.','',$d['bidang'][0]['kode_urusan']))):'',
    			'jenis'=>'IM',

    		]);
    		}


    		if(!empty($d['kegiatan_mendukung_indikator_makro'])){

	    			foreach ($d['kegiatan_mendukung_indikator_makro'] as  $k) {
	    				DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_kegiatan_indikator_pusat')
	    				->insertOrIgnore([
	    					'kode_daerah'=>$kode_daerah,
	    					'kode_kegiatan'=>$k['kode_kegiatan'],
	    					'kode_indikator'=>$d['kode_indikator'],
	    					'created_at'=>Carbon::now(),
	    					'updated_at'=>Carbon::now()
	    				]);

	    			}

	    	}
    	}
    	

    	return $data;

    	$daerah=DB::table('master_daerah')->where('id','>',$kode_daerah)
    	->first();

    	return view('bot.rakortek')->with('daerah',$daerah);

    }

    public function viewRakotek(){
    	$daerah=DB::table('master_daerah')->orderBy('id','ASC')->get();
    	$daerah_return=[];
    	foreach ($daerah as $key => $d) {
    		
    		$data=(array)$d;
    		$data['exist']=false;
    		$data['file']='';


    		if(file_exists(storage_path('app/public/BOT/SIPD/RAKORTEK/2021/'.$d->id.'.json'))){
    			$data['exist']=true;
    			$data['file']='storage/BOT/SIPD/RAKORTEK/2021/'.$d->id.'.json';

    		}

    		$daerah_return[]=$data;
    	}


    	return view('bot.rakortek_view')->with('data',$daerah_return);

    }
}
