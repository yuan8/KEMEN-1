<?php

namespace App\Http\Controllers\SISTEM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use HP;
use DB;
use Storage;
use DBINIT;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class BOTSIPD extends Controller
{

	static public function listing($tahun,$status_min=0,$cron=false){
    	set_time_limit(-1);
    	if($status_min<4){
    		$con='myranwal';
    		$schema='';
    	}else if($status_sipd>=4){
    		$con='myfinal';
    		$schema='';
    	}else if($status_min==6){
    		$con='pgsql';
    		$schema='rkpd.';
    	}



  //   	$dt='1';
		// if(file_exists(storage_path('app/chace-cron.text'))){
		// 	$dt=file_get_contents(storage_path('app/chace-cron.text'));

		// }

		$data=DB::connection($con)->table(DB::raw("(select d.id as kodepemda,d.nama,(select f.anggaran from ".$schema."master_".$tahun."_status as f where f.kodepemda=d.id)".($schema!=''?'::numeric':'')." as sipd_anggaran,(select f.status from ".$schema."master_".$tahun."_status as f where f.kodepemda=d.id)".($schema!=''?'::numeric':'')." as sipd_status ,max(k.status)".($schema!=''?'::numeric':'')." as status ,sum(k.pagu)".($schema!=''?'::numeric':'')." as  anggaran from ".$schema."master_daerah as d 
			left join ".$schema."master_".$tahun."_kegiatan as k on k.kodepemda=d.id  group by d.id) as t"))
		->where([
			['sipd_status','!=',DB::raw('status')],
			['sipd_status','>=',DB::raw($status_min)],

		])
		->OrWhere([
			[($schema!=''?DB::raw("round( CAST(anggaran as numeric), 0)"):'anggaran'),'!=',($schema!=''?DB::raw("round( CAST(sipd_anggaran as numeric), 0)"):'anggaran')],
			['sipd_status','>=',$status_min],
		])
		->OrWhere([
			['status','=',null],
			['sipd_status','>=',$status_min],

		])
		->orderBy('sipd_anggaran','desc')->first();



		if($data){

			$request=new Request;
			$kodepemda=$data->kodepemda;

			$s=static::getDataJson($tahun,$kodepemda,$status_min,true,$request);



			if($cron){
				Log::info('SIPD '.$data->nama.'||'.$data->kodepemda.' --- done');

				echo 'SIPD '.$data->nama.'||'.$data->kodepemda.' --- done';
			}
			Storage::put('chace-cron.text',$data->kodepemda);
		}else{

			\Artisan::call('sipd:status-rkpd '.$tahun);
		}

		return (array) $data;

	}


	static public function init($tahun){
    	DBINIT::rkpd_db($tahun);
	}

	static function  host(){
		// if( strpos($_SERVER['HTTP_HOST'], '192.168.123.190') !== false) {

		// 	return 'http://192.168.123.195/';

		// }else{

			return 'https://sipd.go.id/';
		// }

	}

	static $token='d1d1ab9140c249e34ce356c91e9166a6';
    //
    static public function getDataJson($tahun,$kodepemda,$min_status,$cron=false,Request $request){	
    	set_time_limit(-1);

		if(strlen($kodepemda)<4){
			$kode_daerah=$kodepemda.'00';
		}else{
			$kode_daerah=$kodepemda;
		}
		$kodepemda=str_replace('00', '',$kodepemda);
		$status=0;


		$schema='';

		if($min_status<4){
			$con='myranwal';
		}else if($min_status==6){
			$con='pgsql';
			$schema='rkpd.';
		}else{
			$con='myfinal';
		}

    	

    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$response = curl_exec($ch);

		$headers = [
		    "Authorization: bearer ".static::$token
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output=null;

		try {

			$status=DB::connection($con)->table($schema.'master_'.$tahun.'_status')
			->where('kodepemda',$kodepemda)->where('updated_at','>',Carbon::now()->add(-3, 'hour'))->pluck('status')->first();
			if($status){

			}else{
				// dd(Carbon::now()->add(-4, 'hour'));
				\Artisan::call('sipd:status-rkpd '.$tahun);
				$status=DB::connection($con)->table($schema.'master_'.$tahun.'_status')
				->where('kodepemda',$kodepemda)->pluck('status')->first();
			}

			if($status==null){
				$status=0;
			}

			if($status<=2){
    			curl_setopt($ch, CURLOPT_URL,static::host().'run/serv/ranwal.php?tahun='.($tahun).'&kodepemda='.$kode_daerah);

			}else{
    			curl_setopt($ch, CURLOPT_URL,static::host().'run/serv/get.php?tahun='.($tahun).'&kodepemda='.$kode_daerah);
				# code...
			}

			$approve=true;

			if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/BUILD/'.$kodepemda.'.json'))){

				$dt=file_get_contents(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json'));
				$dt=json_decode($dt,true);
				if($dt['status']==$status){
					if($dt['data']!=[]){
						$approve=false;
						$server_output=$dt['data'];
					}
					
				}

			}

			if($approve){

				$server_output = curl_exec ($ch);
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$server_output=substr($server_output, $header_size);
				curl_close ($ch);
			}

			

		} catch (Exception $e) {
		
			$server_output=null;	
		}


		if($server_output){
			if(is_array($server_output)){
				
			}else{
				$server_output= json_decode(trim($server_output),true);
			}
			
		}else{
			$server_output=array();
		}


		$data_json=array('status'=>$status,'data'=>$server_output);

		Storage::put('BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json',json_encode($data_json,JSON_PRETTY_PRINT));


		Storage::put('BOT/SIPD/JSON/'.$tahun.'/STATUS/'.$status.'/'.$kodepemda.'.json',json_encode($data_json,JSON_PRETTY_PRINT));

		$data_returning_build=static::building($tahun,$kodepemda,$data_json);

		if($request->json==true){

			$nextid=DB::table('master_daerah')->where('id','>',$kodepemda)->first();
			
			return view('sistem.sipd.rkpd.next')->with('daerah',$nextid)
				   ->with(['tahun'=>$tahun,'kodepemda'=>$kodepemda]);
			
		}


    	static::storingData($tahun,$kodepemda,$data_returning_build,$min_status);

    	if($cron){
    		return true;
    	}


		return back();

		return 'data-transform-done';

    }



   public static function  building($tahun,$kodepemda,$data=null){
    	set_time_limit(-1);


   	if(strpos((string)$kodepemda, '00')!==false){
   		$kodepemda=str_replace('00', '', (string)$kodepemda);
   	
   	}

   	if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json'))){
   		if($data==null){
   			$data=file_get_contents(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json'));
   			$data=json_decode($data,true);
   		}
   		
   		$status=$data['status'];
   		$nama_daerah=DB::table('master_daerah')->where('id',$kodepemda)->pluck('nama')->first();
   		$data_return=[
   			'kodepemda'=>$kodepemda,
   			'nama_daerah'=>$nama_daerah,
   			'status'=>$status,
   			'jumlah_kegiatan'=>0,
   			'jumlah_program'=>0,
   			'jumlah_anggaran'=>0,
   			'jumlah_indikator_program'=>0,
   			'jumlah_indikator_kegiatan'=>0,
   			'data'=>[]
   		];


   		$kodecapaian=0;
   		$kodeprioritas=0;
   		$kodekegiatansumberdata=0;


   		foreach ($data['data'] as $key => $u) {
   			foreach ($u['program'] as $key => $p) {
   				$id_urusan=DB::table('master_urusan')->where('nama','ilike',('%'.$u['uraibidang'].'%'))->pluck('id')->first();

   				$kodeskpd=$u['kodeskpd'];
   				$uraiskpd=$u['uraiskpd'];
   				$kodebidang=$p['kodebidang'];
   				$uraibidang=$p['uraibidang'];
   				$kodeprogram=$p['kodeprogram'];

   				$kode_p='P.'.$kodebidang.'.'.$kodeskpd.'.'.$kodeprogram;

   				if(!isset($data_return['data'][$kode_p])){
   					$data_return['jumlah_program']+=1;

   					$data_return['data'][$kode_p]=array(
   						'status'=>$status,
   						'kodepemda'=>$kodepemda,
   						'tahun'=>$tahun,
   						'kodebidang'=>$kodebidang,
   						'uraibidang'=>$uraibidang,
   						'id_urusan'=>$id_urusan,
   						'kodeprogram'=>$kodeprogram,
   						'uraiprogram'=>$p['uraiprogram'],
   						'kodeskpd'=>$kodeskpd,
   						'uraiskpd'=>$uraiskpd,
   						'capaian'=>[],
   						'prioritas'=>[],
   						'kegiatan'=>[]
   					);
   				}

   				foreach ($p['capaian'] as $key => $c) {

   					if((!empty($c['tolokukur']))AND($c['tolokukur']!='')){

   						$data_return['jumlah_indikator_program']+=1;

						$data_return['data'][$kode_p]['capaian'][]=array(
							'status'=>$status,

							'kodepemda'=>$kodepemda,
							'tahun'=>$tahun,
							'kodebidang'=>$kodebidang,
							'kodeskpd'=>$kodeskpd,
							'kodeprogram'=>$kodeprogram,
							'kodeindikator'=>$c['kodeindikator'],
							'tolokukur'=>$c['tolokukur'],
							'satuan'=>$c['satuan'],
							'satuan'=>$c['satuan'],
							'real_p3'=>$c['real_p3'],
							'pagu_p3'=>(float)$c['pagu_p3'],
							'real_p2'=>$c['real_p2'],
							'pagu_p2'=>(float)$c['pagu_p2'],
							'real_p1'=>$c['real_p1'],
							'pagu_p1'=>(float)$c['pagu_p1'],
							'target'=>$c['target'],
							'pagu'=>(float)$c['pagu'],
							'pagu_p'=>(float)$c['pagu_p'],
							'pagu_n1'=>(float)$c['pagu_n1'],

						);	

   					}

					
   				}

   				foreach ($p['prioritas'] as $l => $pprio) {
   					foreach ($pprio as $keypprio => $prio) {

	   					if((!empty($prio))AND($prio!='')){

							$data_return['data'][$kode_p]['prioritas'][]=array(
								'status'=>$status,

								'kodepemda'=>$kodepemda,
								'tahun'=>$tahun,
								'kodebidang'=>$kodebidang,
								'kodeskpd'=>$kodeskpd,
								'kodeprogram'=>$kodeprogram,
								'kodeprioritas'=>$l,
								'jenis'=>$keypprio,
								'uraiprioritas'=>$prio
							);

	   					}
   						# code...
   					}
					
   				}



   				foreach ($p['kegiatan'] as $key => $k) {

   					$kodekegiatan=$k['kodekegiatan'];

   					$kode_k=$kode_p.'.'.$kodekegiatan;

   					if(!isset($data_return['data'][$kode_p]['kegiatan'][$kode_k])){
   						$data_return['jumlah_kegiatan']+=1;
   						$data_return['jumlah_anggaran']+=$k['pagu'];


   						$data_return['data'][$kode_p]['kegiatan'][$kode_k]=array(
   							'status'=>$status,
   							'kodepemda'=>$kodepemda,
   							'tahun'=>$tahun,
   							'kodebidang'=>$kodebidang,
   							'id_urusan'=>$id_urusan,
   							'kodeskpd'=>$kodeskpd,
   							'kodeprogram'=>$kodeprogram,
   							'kodekegiatan'=>$kodekegiatan,
   							'uraikegiatan'=>$k['uraikegiatan'],
   							'pagu'=>(float)$k['pagu'],
   							'pagu_p'=>(float)$k['pagu_p'],
   							'sumberdana'=>[],
   							'prioritas'=>[],
   							'lokasi'=>[],
   							'indikator'=>[],
   							'sub_kegiatan'=>[]

   						);

   					}

   					foreach ($k['prioritas'] as $l => $pprio) {
	   					foreach ($pprio as $keypprio => $prio) {

		   					if((!empty($prio))AND($prio!='')){

								$data_return['data'][$kode_p]['kegiatan'][$kode_k]['prioritas'][]=array(
									'status'=>$status,

									'kodepemda'=>$kodepemda,
									'tahun'=>$tahun,
									'kodebidang'=>$kodebidang,
									'kodeskpd'=>$kodeskpd,
   									'kodeprogram'=>$kodeprogram,
									'kodekegiatan'=>$kodekegiatan,
									'kodeprioritas'=>$l,
									'jenis'=>$keypprio,
									'uraiprioritas'=>$prio,
								);	

		   					}
	   						# code...
	   					}
						
	   				}

	   				if(is_array($k['sumberdana'])){
	   					foreach ($k['sumberdana'] as $keyl => $c) {


		   					if((!empty($c['sumberdana']))AND($c['sumberdana']!='')){

		   						$kode_sd=strtolower(str_replace(' ', '_', trim($c['sumberdana'])));

								if(!isset($data_return['data'][$kode_p]['kegiatan'][$kode_k]['sumberdana'][$kode_sd])){
									$data_return['data'][$kode_p]['kegiatan'][$kode_k]['sumberdana'][$kode_sd]=array(
										'status'=>$status,
										'kodepemda'=>$kodepemda,
										'tahun'=>$tahun,
										'kodebidang'=>$kodebidang,
										'kodeskpd'=>$kodeskpd,
		   								'kodeprogram'=>$kodeprogram,
										'kodekegiatan'=>$kodekegiatan,
										'kodesumberdana'=>$c['kodesumberdana']!=''?$c['kodesumberdana']:$keyl,
										'sumberdana'=>$c['sumberdana'],
										'pagu'=>(isset($c['pagu']))?(float)$c['pagu']:0,
									);	
								}else{
									$data_return['data'][$kode_p]['kegiatan'][$kode_k]['sumberdana'][$kode_sd]+=(isset($c['pagu']))?(float)$c['pagu']:0;
								}

		   					}

	   					}
	   				}


	   				foreach ($k['lokasi'] as $keyl => $c) {

	   					if((!empty($c['lokasi']))AND($c['lokasi']!='')){

							$data_return['data'][$kode_p]['kegiatan'][$kode_k]['lokasi'][]=array(
								'status'=>$status,

								'kodepemda'=>$kodepemda,
								'tahun'=>$tahun,
								'kodebidang'=>$kodebidang,
								'kodeskpd'=>$kodeskpd,
   								'kodeprogram'=>$kodeprogram,
								'kodekegiatan'=>$kodekegiatan,
								'kodelokasi'=>$c['kodelokasi']!=''?$c['kodelokasi']:$keyl,
								'lokasi'=>$c['lokasi'],
								'detaillokasi'=>$c['detaillokasi'],
							);	

	   					}

	   				}



	   				foreach ($k['indikator'] as $key => $c) {

	   					if((!empty($c['tolokukur']))AND($c['tolokukur']!='')){

	   						$data_return['jumlah_indikator_kegiatan']+=1;
							$data_return['data'][$kode_p]['kegiatan'][$kode_k]['indikator'][]=array(
								'status'=>$status,
								'kodepemda'=>$kodepemda,
								'tahun'=>$tahun,
								'kodebidang'=>$kodebidang,
								'kodeskpd'=>$kodeskpd,
   								'kodeprogram'=>$kodeprogram,
								'kodekegiatan'=>$kodekegiatan,
								'kodeindikator'=>$c['kodeindikator'],
								'tolokukur'=>$c['tolokukur'],
								'satuan'=>$c['satuan'],
								'satuan'=>$c['satuan'],
								'real_p3'=>$c['real_p3'],
								'pagu_p3'=>(float)$c['pagu_p3'],
								'real_p2'=>$c['real_p2'],
								'pagu_p2'=>(float)$c['pagu_p2'],
								'real_p1'=>$c['real_p1'],
								'pagu_p1'=>(float)$c['pagu_p1'],
								'target'=>$c['target'],
								'pagu'=>(float)$c['pagu'],
								'pagu_p'=>(float)$c['pagu_p'],
								'pagu_n1'=>(isset($c['pagu_n1']))?(float)$c['pagu_n1']:0,

							);	

	   					}

						
	   				}

	   				if(isset($k['sub_kegiatan'])){
	   					foreach ($k['sub_kegiatan'] as $key => $s) {
		   					$kodesubkegiatan=$s['kodesubkegiatan'];
		   					$kode_s=$kode_k.'.'.$kodesubkegiatan;

		   					if(!isset($data_return['data'][$kode_p]['kegiatan'][$kode_k]['sub_kegiatan'][$kode_s])){


		   						$data_return['data'][$kode_p]['kegiatan'][$kode_k]['sub_kegiatan'][$kode_s]=array(
									'status'=>$status,
		   							'kodepemda'=>$kodepemda,
		   							'tahun'=>$tahun,
		   							'kodebidang'=>$kodebidang,
		   							'id_urusan'=>$id_urusan,
		   							'kodeskpd'=>$kodeskpd,
		   							'kodeprogram'=>$kodeprogram,
		   							'kodekegiatan'=>$kodekegiatan,
		   							'kodesubkegiatan'=>$kodesubkegiatan,
		   							'uraisubkegiatan'=>$s['uraisubkegiatan'],
		   							'pagu'=>(float)$s['pagu'],
		   							'pagu_p'=>(float)$s['pagu_p'],
		   							'prioritas'=>[],
		   							'lokasi'=>[],
		   							'indikator'=>[],
		   							'sub_kegiatan'=>[]
		   						);

		   					}



	   						foreach ($s['prioritas'] as $l => $pprio) {
			   					foreach ($pprio as $keypprio => $prio) {

				   					if((!empty($prio))AND($prio!='')){

										$data_return['data'][$kode_p]['kegiatan'][$kode_k]['sub_kegiatan'][$kode_s]['prioritas'][]=array(
											'status'=>$status,
											'kodepemda'=>$kodepemda,
											'tahun'=>$tahun,
											'kodebidang'=>$kodebidang,
											'kodeskpd'=>$kodeskpd,
											'kodeprogram'=>$kodeprogram,
											'kodekegiatan'=>$kodekegiatan,
											'kodesubkegiatan'=>$kodesubkegiatan,
											'kodeprioritas'=>$l,
											'jenis'=>$keypprio,
											'uraiprioritas'=>$prio,
										);	

				   					}
			   						# code...
			   					}
								
			   				}


			   				foreach ($s['lokasi'] as $keyl => $c) {

			   					if((!empty($c['lokasi']))AND($c['lokasi']!='')){

									$data_return['data'][$kode_p]['kegiatan'][$kode_k]['sub_kegiatan'][$kode_s]['lokasi'][]=array(
										'status'=>$status,

										'kodepemda'=>$kodepemda,
										'tahun'=>$tahun,
										'kodebidang'=>$kodebidang,
										'kodeskpd'=>$kodeskpd,
		   								'kodeprogram'=>$kodeprogram,
										'kodekegiatan'=>$kodekegiatan,
										'kodesubkegiatan'=>$kodesubkegiatan,
										'kodelokasi'=>$c['kodelokasi']!=''?$c['kodelokasi']:$keyl,
										'lokasi'=>$c['lokasi'],
										'detaillokasi'=>$c['detaillokasi'],
									);	

			   					}

			   				}

			   				foreach ($s['indikator'] as $key => $c) {

			   					if((!empty($c['tolokukur']))AND($c['tolokukur']!='')){

									$data_return['data'][$kode_p]['kegiatan'][$kode_k]['sub_kegiatan'][$kode_s]['indikator'][]=array(
										'status'=>$status,
										'kodepemda'=>$kodepemda,
										'tahun'=>$tahun,
										'kodebidang'=>$kodebidang,
										'kodeskpd'=>$kodeskpd,
		   								'kodeprogram'=>$kodeprogram,
										'kodekegiatan'=>$kodekegiatan,
										'kodeindikator'=>$c['kodeindikator'],
										'tolokukur'=>$c['tolokukur'],
										'satuan'=>$c['satuan'],
										'satuan'=>$c['satuan'],
										'real_p3'=>$c['real_p3'],
										'pagu_p3'=>(float)$c['pagu_p3'],
										'real_p2'=>$c['real_p2'],
										'pagu_p2'=>(float)$c['pagu_p2'],
										'real_p1'=>$c['real_p1'],
										'pagu_p1'=>(float)$c['pagu_p1'],
										'target'=>$c['target'],
										'pagu'=>(float)$c['pagu'],
										'pagu_p'=>(float)$c['pagu_p'],
										'pagu_n1'=>(float)$c['pagu_n1'],

									);	

			   					}
	
			   				}

		   				}
	   				}
	   				// sub kegiatan

   					

   				}
   				// kegiatan




   				# code...
   			}
   			// pro
   			# code...
   		}
   		// urusan

   		// selesai

   		Storage::put('BOT/SIPD/JSON/'.$tahun.'/BUILD/'.$kodepemda.'.json',json_encode($data_return,JSON_PRETTY_PRINT));

   		return $data_return;

   	}

   	return null;


   }


   static function dataInsert($data){
   		$data_return=$data;
   		foreach ($data as $key => $value) {
   			if(is_array($data[$key])){
   				unset($data_return[$key]);
   			}
   		}

   		return $data_return;

   }

   static function storingData($tahun,$kodepemda,$data=null,$min_status){
    	set_time_limit(-1);


   		if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/BUILD/'.$kodepemda.'.json'))){

	   		if($data==null){
	   			$data=file_get_contents(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/BUILD/'.$kodepemda.'.json'));
	   			$data=json_decode($data,true);
	   		}

	   			$schema='';

	   			if($min_status!=6){
	   				if((int)$data['status'] >3) {
	   					$con='myfinal';
	   					$schema='';
	   				}else{
	   					$con='myranwal';
	   					$schema='';
	   				}

	   			}else{
	   				$con='pgsql';
	   				$schema='rkpd.';
	   			}

	   			if($schema!=''){
	   				$sqllike='ilike';

	   			}else{
	   				$sqllike='like';
	   			}




	   			foreach ($data['data'] as $key => $p) {
	   				$px=DB::connection($con)->table($schema.'master_'.$tahun.'_program')
	   				->where([
   						['kodepemda','=',$p['kodepemda']],
	   					['kodebidang','=',$p['kodebidang']],
	   					['kodeskpd','=',$p['kodeskpd']],
	   					['kodeprogram','=',$p['kodeprogram']]
	   				])->first();

	   				if($px){
	   					DB::connection($con)->table($schema.'master_'.$tahun.'_program')
	   					->where('id',$px->id)->update(static::dataInsert($p));
	   					$id_program=$px->id;
	   				}else{

	   					$id_program=DB::connection($con)->table($schema.'master_'.$tahun.'_program')
	   					->insertGetId(static::dataInsert($p));
	   				}


	   				foreach($p['prioritas'] as $dt){

	   					$ex=DB::connection($con)->table($schema.'master_'.$tahun.'_program_prio')
		   				->where([
		   					['kodepemda','=',$dt['kodepemda']],
		   					['kodebidang','=',$dt['kodebidang']],
		   					['kodeskpd','=',$dt['kodeskpd']],
		   					['kodeprogram','=',$dt['kodeprogram']],
		   					['jenis','=',$dt['jenis']],
		   					['uraiprioritas',$sqllike,('%'.$p['uraiprioritas'].'%')],
		   					['id_program','=',$id_program]

		   				])->first();

		   				if($ex){
		   					DB::connection($con)->table($schema.'master_'.$tahun.'_program_prio')
		   					->where('id',$ex->id)->update(static::dataInsert($dt));
		   				}else{
		   					$dt['id_program']=$id_program;
		   					DB::connection($con)->table($schema.'master_'.$tahun.'_program_prio')
		   					->insertGetId(static::dataInsert($dt));
		   				}
	   				}

	   				foreach ($p['capaian'] as $key => $dt) {

	   					$ex=DB::connection($con)->table($schema.'master_'.$tahun.'_program_capaian')
		   				->where([
		   					['kodepemda','=',$dt['kodepemda']],
		   					['kodebidang','=',$dt['kodebidang']],
		   					['kodeskpd','=',$dt['kodeskpd']],
		   					['kodeprogram','=',$dt['kodeprogram']],
		   					['kodeindikator','=',$dt['kodeindikator']],
		   					['tolokukur',$sqllike,('%'.$dt['tolokukur'].'%')],
		   					['id_program','=',$id_program]


		   				])->first();

		   				if($ex){
		   					DB::connection($con)->table($schema.'master_'.$tahun.'_program_capaian')
		   					->where('id',$ex->id)->update(static::dataInsert($dt));
		   				}else{
		   					$dt['id_program']=$id_program;
		   					DB::connection($con)->table($schema.'master_'.$tahun.'_program_capaian')
		   					->insertOrIgnore(static::dataInsert($dt));
		   				}
	   					# code...
	   				}


	   				foreach ($p['kegiatan'] as $key => $dt) {

   						$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan')
		   				->where([
	   						['kodepemda','=',$dt['kodepemda']],
		   					['kodebidang','=',$dt['kodebidang']],
		   					['kodeskpd','=',$dt['kodeskpd']],
		   					['kodeprogram','=',$dt['kodeprogram']],
		   					['kodekegiatan','=',$dt['kodekegiatan']],
		   					['id_program','=',$id_program]
		   				])->first();

		   				if($px){
		   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan')
		   					->where('id',$px->id)->update(static::dataInsert($dt));
		   					$id_kegiatan=$px->id;
		   				}else{
		   					$dt['id_program']=$id_program;
		   					$id_kegiatan=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan')
		   					->insertGetId(static::dataInsert($dt));
		   				}

		   				foreach ($dt['indikator'] as $key => $dk) {

	   						$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_indikator')
			   				->where([
		   						['kodepemda','=',$dk['kodepemda']],
			   					['kodebidang','=',$dk['kodebidang']],
			   					['kodeskpd','=',$dk['kodeskpd']],
			   					['kodeprogram','=',$dk['kodeprogram']],
			   					['kodekegiatan','=',$dk['kodekegiatan']],
			   					['kodeindikator','=',$dk['kodeindikator']],
			   					['tolokukur',$sqllike,('%'.$dk['tolokukur'].'%')],
			   					['id_kegiatan','=',$id_kegiatan]
			   				])->first();

			   				if($px){
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_indikator')
			   					->where('id',$px->id)->update(static::dataInsert($dk));
			   				}else{
			   					$dk['id_kegiatan']=$id_kegiatan;
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_indikator')
			   					->insertOrIgnore(static::dataInsert($dk));
			   				}

		   				}

		   				foreach ($dt['sumberdana'] as $key => $dk) {

	   						$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sumberdana')
			   				->where([
		   						['kodepemda','=',$dk['kodepemda']],
			   					['kodebidang','=',$dk['kodebidang']],
			   					['kodeskpd','=',$dk['kodeskpd']],
			   					['kodeprogram','=',$dk['kodeprogram']],
			   					['kodekegiatan','=',$dk['kodekegiatan']],
			   					['sumberdana','=',$dk['sumberdana']],
			   					['id_kegiatan','=',$id_kegiatan]
			   				])->first();

			   				if($px){
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sumberdana')
			   					->where('id',$px->id)->update(static::dataInsert($dk));
			   				}else{
			   					$dk['id_kegiatan']=$id_kegiatan;
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sumberdana')
			   					->insertGetId(static::dataInsert($dk));
			   				}

		   				}

		   				foreach ($dt['lokasi'] as $key => $dk) {

	   						$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_lokasi')
			   				->where([
		   						['kodepemda','=',$dk['kodepemda']],
			   					['kodebidang','=',$dk['kodebidang']],
			   					['kodeskpd','=',$dk['kodeskpd']],
			   					['kodeprogram','=',$dk['kodeprogram']],
			   					['kodekegiatan','=',$dk['kodekegiatan']],
			   					['detaillokasi',$sqllike,('%'.$dk['detaillokasi'].'%')],
			   					['id_kegiatan','=',$id_kegiatan]
			   				])->first();

			   				if($px){
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_lokasi')
			   					->where('id',$px->id)->update(static::dataInsert($dk));
			   				}else{
			   					$dk['id_kegiatan']=$id_kegiatan;
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_lokasi')
			   					->insertGetId(static::dataInsert($dk));
			   				}

		   				}

		   				foreach ($dt['prioritas'] as $key => $dk) {

	   						$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_prio')
			   				->where([
		   						['kodepemda','=',$dk['kodepemda']],
			   					['kodebidang','=',$dk['kodebidang']],
			   					['kodeskpd','=',$dk['kodeskpd']],
			   					['kodeprogram','=',$dk['kodeprogram']],
			   					['kodekegiatan','=',$dk['kodekegiatan']],
			   					['jenis','=',$dk['jenis']],
			   					['uraiprioritas',$sqllike,('%'.$dk['uraiprioritas'].'%')],
			   					['id_kegiatan','=',$id_kegiatan]
			   				])->first();

			   				if($px){
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_prio')
			   					->where('id',$px->id)->update(static::dataInsert($dk));
			   				}else{
			   					$dk['id_kegiatan']=$id_kegiatan;
			   					$id_sub_kegiatan=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_prio')
			   					->insertGetId(static::dataInsert($dk));
			   				}

		   				}



		   				foreach ($dt['sub_kegiatan'] as $key => $dk) {

	   						$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub')
			   				->where([
		   						['kodepemda','=',$dk['kodepemda']],
			   					['kodebidang','=',$dk['kodebidang']],
			   					['kodeskpd','=',$dk['kodeskpd']],
			   					['kodeprogram','=',$dk['kodeprogram']],
			   					['kodekegiatan','=',$dk['kodekegiatan']],
			   					['kodesubkegiatan','=',$dk['kodesubkegiatan']],
			   					['id_kegiatan','=',$id_kegiatan]
			   				])->first();

			   				if($px){
			   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub')
			   					->where('id',$px->id)->update(static::dataInsert($dk));
			   					$id_sub_kegiatan=$px->id;
			   				}else{
			   					$dk['id_kegiatan']=$id_kegiatan;
			   					$id_sub_kegiatan=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub')
			   					->insertGetId(static::dataInsert($dk));
			   				}


			   				foreach($dk['lokasi'] as $key => $ds) {
			   					$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_lokasi')
				   				->where([
			   						['kodepemda','=',$ds['kodepemda']],
				   					['kodebidang','=',$ds['kodebidang']],
				   					['kodeskpd','=',$ds['kodeskpd']],
				   					['kodeprogram','=',$ds['kodeprogram']],
				   					['kodekegiatan','=',$ds['kodekegiatan']],
				   					['kodesubkegiatan','=',$ds['kodesubkegiatan']],
				   					['kodelokasi','=',$ds['kodelokasi']],
				   					['detaillokasi',$sqllike,('%'.$ds['detaillokasi'].'%')],
				   					['id_sub_kegiatan','=',$id_sub_kegiatan]
				   				])->first();

				   				if($px){
				   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_lokasi')
				   					->where('id',$px->id)->update(static::dataInsert($ds));
				   				}else{
				   					$ds['id_sub_kegiatan']=$id_sub_kegiatan;
				   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_lokasi')
				   					->insertGetId(static::dataInsert($ds));
				   				}
			   					# code...
			   				}

			   				foreach($dk['indikator'] as $key => $ds) {
			   					$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_indikator')
				   				->where([
			   						['kodepemda','=',$ds['kodepemda']],
				   					['kodebidang','=',$ds['kodebidang']],
				   					['kodeskpd','=',$ds['kodeskpd']],
				   					['kodeprogram','=',$ds['kodeprogram']],
				   					['kodekegiatan','=',$ds['kodekegiatan']],
				   					['kodesubkegiatan','=',$ds['kodesubkegiatan']],
				   					['kodeindikator','=',$ds['kodeindikator']],
				   					['tolokukur',$sqllike,('%'.$ds['tolokukur'].'%')],
				   					['id_sub_kegiatan','=',$id_sub_kegiatan]
				   				])->first();

				   				if($px){
				   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_indikator')
				   					->where('id',$px->id)->update(static::dataInsert($ds));
				   				}else{
				   					$ds['id_sub_kegiatan']=$id_sub_kegiatan;
				   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_indikator')
				   					->insertGetId(static::dataInsert($ds));
				   				}
			   					# code...
			   				}

			   				foreach($dk['prioritas'] as $key => $ds) {
			   					$px=DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_prio')
				   				->where([
			   						['kodepemda','=',$ds['kodepemda']],
				   					['kodebidang','=',$ds['kodebidang']],
				   					['kodeskpd','=',$ds['kodeskpd']],
				   					['kodeprogram','=',$ds['kodeprogram']],
				   					['kodekegiatan','=',$ds['kodekegiatan']],
				   					['kodesubkegiatan','=',$ds['kodesubkegiatan']],
				   					['jenis','=',$ds['jenis']],
				   					['uraiprioritas',$sqllike,('%'.$ds['uraiprioritas'].'%')],
				   					['id_sub_kegiatan','=',$id_sub_kegiatan]
				   				])->first();

				   				if($px){
				   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_prio')
				   					->where('id',$px->id)->update(static::dataInsert($ds));
				   				}else{
				   					$ds['id_sub_kegiatan']=$id_sub_kegiatan;
				   					DB::connection($con)->table($schema.'master_'.$tahun.'_kegiatan_sub_prio')
				   					->insertGetId(static::dataInsert($ds));
				   				}
			   					# code...
			   				}


		   				}
		   				// sub kegiatan




	   				}
	   				// kegiatan

	   			}
	   			// program


	   	}

	   	// deleteing






   } 



    public static function makeData($tahun,$kodepemda){
    	$jumlah_kegiatan=0;
    	$jumlah_program=0;
    	$jumlah_ind_program=0;
    	$jumlah_ind_kegiatan=0;
    	$jumlah_anggaran=0;


    	$kodepemda=str_replace('00', '', $kodepemda);
    	if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json'))){
    		$data=json_decode(file_get_contents(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json')),true);
    		$data_return=[];
    		// dd($data['data'][0]['program'][0]['kegiatan'][0]);
    		$status=$data['status'];
    		foreach ($data['data'] as  $u) {
    			$kodeskpd=$u['kodeskpd'];
    			$uraiskpd=$u['uraiskpd'];
    			$kodebidang=$u['kodebidang'];
    			$id_bidang=DB::table('master_urusan')->where('nama',$sqllike,('%'.$u['uraibidang'].'%'))->pluck('id')->first();

    			$data_return['SKPD@'.$u['kodeskpd']]=array(
    				'kode_daerah'=>$kodepemda,
    				'uraian'=>$u['uraibidang'],
    				'kode_bidang'=>$kodebidang,
    				'kode_skpd'=>$kodeskpd,
    				'uraian_skpd'=>$uraiskpd,
    				'penjabat'=>json_encode(isset($u['penjabat'])?$u['penjabat']:[]),
    				'id_urusan'=>$id_bidang,
    				'program'=>[]
    			);

    			foreach ($u['program'] as  $p) {
    				$jumlah_program+=1;

    				$kodeprogram=$p['kodeprogram'];

    				$id_bidang=DB::table('master_urusan')->where('nama',$sqllike,('%'.$p['uraibidang'].'%'))->pluck('id')->first();
    				$kodebidang=$p['kodebidang'];

    				if(isset($data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram])){
    				}

    				$data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram]=array(
    					'kode_daerah'=>$kodepemda,
    					'kode_program'=>$p['kodeprogram'],
    					'uraian'=>trim($p['uraiprogram']),
    					'id_urusan'=>$id_bidang,
    					'kode_bidang'=>$kodebidang,
	    				'kode_skpd'=>$kodeskpd,
	    				'uraian_skpd'=>$uraiskpd,
    					'status'=>$status,
    					'indikator'=>[],
    					'kegiatan'=>[]
    				);

    				foreach ($p['capaian'] as $ip) {
    					$jumlah_ind_program+=1;

    					$kode_indikator_p=$ip['kodeindikator'];
    					$data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram]['indikator'][$kode_indikator_p]=array(
    						'kode_daerah'=>$kodepemda,
    						'status'=>$status,
    						'kode_bidang'=>$kodebidang,
		    				'kode_skpd'=>$kodeskpd,
		    				'uraian_skpd'=>$uraiskpd,
    						'kode_ind'=>$kode_indikator_p,
    						'uraian'=>trim($ip['tolokukur']),
    						'satuan'=>$ip['satuan'],
    						'target_awal'=>$ip['target'],
    						// 'target_n1'=>$ip['target_n1'],
    					);
    				}

    				foreach ($p['kegiatan'] as $k) {
    					$kode_kegiatan=$k['kodekegiatan'];

    					if(isset($data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram]['kegiatan']['KEGIATAN@'.$kode_kegiatan])){
    						dd($k);
    					
    					}else{
    					$jumlah_kegiatan+=1;

    					}

    					$jumlah_anggaran+=(float)($k['pagu']?$k['pagu']:0);

 

    					$data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram]['kegiatan']['KEGIATAN@'.$kode_kegiatan]=array(
    						'kode_daerah'=>$kodepemda,
    						'id_urusan'=>$id_bidang,
    						'kode_kegiatan'=>$kode_kegiatan,
    						'uraian'=>trim($k['uraikegiatan']),
    						'anggaran'=>(float)($k['pagu']?$k['pagu']:0),
    						'status'=>$status,
    						'kode_bidang'=>$kodebidang,
		    				'kode_skpd'=>$kodeskpd,
		    				'uraian_skpd'=>$uraiskpd,
    						'sumber_dana'=>[],
    						'indikator'=>[],
    						'sub_kegiatan'=>[]
    					);


    					foreach ((is_array($k['sumberdana'])?$k['sumberdana']:[]) as $isd=> $sd) {
    						

    						$sumberdana='';
    						if(isset($sd['sumberdana'])){
    							$sumberdana=$sd['sumberdana'];
    						}else{
    							$sumberdana=isset($sd['kodelokasi'])?((strpos($sd['kodelokasi'],'APBD')!==false)?'APBD':''):'';
    						}

    						$data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram]['kegiatan']['KEGIATAN@'.$kode_kegiatan]['sumber_dana'][]=array(
    							'kode_dana'=>$kodepemda.'@'.$kodeskpd.'@'.$kodebidang.'@'.$kode_kegiatan.'@'.$isd,
    							'status'=>$status,
    							'kode_daerah'=>$kodepemda,
    							// 'kode_kegiatan'=>$kode_kegiatan,
	    						'kode_bidang'=>$kodebidang,
			    				'kode_skpd'=>$kodeskpd,
			    				'uraian_skpd'=>$uraiskpd,
    							'pagu'=>(float)isset($sd['pagu'])?$sd['pagu']:0,
    							'sumber_dana'=>strtoupper($sumberdana),
    							'kode_sumber_dana'=>isset($sd['kodesumberdana'])?$sd['kodesumberdana']:null

    						);
    						# code...
    					}

    					foreach ($k['indikator'] as $ik) {
    							$jumlah_ind_kegiatan+=1;

    							$kode_kegiatan_k=$ik['kodeindikator'];
	    						$data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram]['kegiatan']['KEGIATAN@'.$kode_kegiatan]['indikator'][$ik['kodeindikator']]=array(
	    							'kode_daerah'=>$kodepemda,
		    						'kode_ind'=>$kode_kegiatan_k,
		    						'uraian'=>trim($ik['tolokukur']),
		    						'satuan'=>$ik['satuan'],
		    						'target_awal'=>$ik['target'],
		    						'anggaran'=>$ik['pagu'],
		    						'status'=>$status,
		    						'kode_bidang'=>$kodebidang,
				    				'kode_skpd'=>$kodeskpd,
				    				'uraian_skpd'=>$uraiskpd,
	    						);
    						# code...
    					}

    					foreach ($k['subkegiatan'] as $sk) {
    							
    						# code...
    					}


    				}

    				# code...
    			}

    		}

    		Storage::put('BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json',json_encode(array('status'=>$status,'jumlah_program'=>$jumlah_program,'jumlah_kegiatan'=>$jumlah_kegiatan,'jumlah_anggaran'=>$jumlah_anggaran,'data'=>$data_return),JSON_PRETTY_PRINT));

    	}else{

    	}

    }



    public static function storingFile($tahun,$kodepemda){
    	$now=Carbon::now();
    	DBINIT::rkpd_db($tahun);
    	$approve=false;
    	$jumlah_kegiatan=0;

    	$kodepemda=str_replace('00', '', $kodepemda);
    	$in_status=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_kegiatan')->where([
    		'kode_daerah'=>$kodepemda
    	])->pluck('status')->first();

    	if(true){
	    	if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json'))){
	    		$data=json_decode(file_get_contents(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json')),true);

	    		$status=$data['status'];
	    		if(true){
	    			foreach ($data['data'] as $key => $u){
	    				$id_program=null;
	    				$id_kegiatan=null;

		    			foreach ($u['program'] as $p) {
	    					$id_program=null;

    						$exp=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_program as p')->where([
	    						'kode_daerah'=>$p['kode_daerah'],
	    						'kode_program'=>$p['kode_program'],
	    						'kode_skpd'=>$p['kode_skpd'],
	    						'kode_bidang'=>$p['kode_bidang'],
	    					])->first();

    						
	    					if(($exp) AND ($exp->status!=$p['status'])){

	    						$id_kegiatan=$exp->id;
	    						DB::table('prokeg.tb_'.$tahun.'_program  as k')->where('id',$id_kegiatan)->update([
	    							'status'=>$p['status'],
	    							'uraian'=>$p['uraian'],
	    						]);
				    			$approve=true;


	    					}else if(empty($exp)){
	    						$id_program=DB::table('prokeg.tb_'.$tahun.'_program as p')->insertGetId([
		    							'uraian'=>$p['uraian'],
		    							'kode_program'=>$p['kode_program'],
		    							'kode_daerah'=>$p['kode_daerah'],
		    							'kode_skpd'=>$p['kode_skpd'],
		    							'uraian_skpd'=>$p['uraian_skpd'],
		    							'kode_bidang'=>$p['kode_bidang'],
		    							'updated_at'=>$now,
		    							'created_at'=>$now,
		    							'status'=>$p['status']
		    					]);

	    					}else{
	    						$id_program=$exp->id;
	    					}

		    				
		    				if($id_program){

		    					foreach ($p['indikator'] as  $ip) {
		    						$exip=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_ind_program as k')->where([
				    						'kode_daerah'=>$ip['kode_daerah'],
				    						'kode_skpd'=>$ip['kode_skpd'],
				    						'id_program'=>$id_program,
				    						'kode_bidang'=>$ip['kode_bidang'],
				    						'kode_ind'=>$ip['kode_ind']
		    						])->first();

		    						if(($exip)AND ($exip->status!=$ip['status'])){
			    						$id_ind_program=$exip->id;
			    						DB::table('prokeg.tb_'.$tahun.'_ind_program as k')->where('id',$id_ind_program)->update([
			    							'status'=>$ip['status'],
			    							'indikator'=>$ip['uraian'],
			    							'target_awal'=>$ip['target_awal'],
			    							'satuan'=>$ip['satuan'],
			    							// 'anggaran'=>$ip['anggaran'],
			    						]);
				    					$approve=true;


			    					}else if(empty($exip)){

			    						DB::table('prokeg.tb_'.$tahun.'_ind_program as k')->insertOrIgnore([
			    							'status'=>$ip['status'],
			    							'kode_daerah'=>$ip['kode_daerah'],
				    						'kode_skpd'=>$ip['kode_skpd'],
				    						'id_program'=>$id_program,
				    						'kode_bidang'=>$ip['kode_bidang'],
				    						'kode_ind'=>$ip['kode_ind'],
			    							'indikator'=>$ip['uraian'],
			    							'target_awal'=>$ip['target_awal'],
			    							'satuan'=>$ip['satuan'],
			    							// 'anggaran'=>$ip['anggaran'],
		    								'uraian_skpd'=>$ip['uraian_skpd'],

			    						]);



			    					}

		    					}

		    					foreach ($p['kegiatan'] as $k) {
		    						$jumlah_kegiatan+=1;
		    						$id_kegiatan=null;
			    					$exk=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_kegiatan as k')->where([
			    						'kode_daerah'=>$k['kode_daerah'],
			    						'kode_kegiatan'=>$k['kode_kegiatan'],
			    						'kode_skpd'=>$k['kode_skpd'],
			    						'id_program'=>$id_program,
			    						'kode_bidang'=>$k['kode_bidang'],

			    					])->first();

			    					if(($exk)AND ($exk->status!=$k['status'])){
			    						$id_kegiatan=$exk->id;
			    						DB::table('prokeg.tb_'.$tahun.'_kegiatan as k')->where('id',$id_kegiatan)->update([
			    							'status'=>$k['status'],
			    							'uraian'=>$k['uraian'],
			    							'anggaran'=>$k['anggaran'],
			    						]);
				    					$approve=true;


			    					}else if(empty($exk)){
			    						$id_kegiatan=DB::table('prokeg.tb_'.$tahun.'_kegiatan as k')->insertGetId([
			    							'uraian'=>$k['uraian'],
		    								'kode_daerah'=>$p['kode_daerah'],
		    								'kode_kegiatan'=>$k['kode_kegiatan'],
			    							'anggaran'=>$k['anggaran'],
			    							'id_urusan'=>$k['id_urusan'],
			    							'kode_skpd'=>$k['kode_skpd'],
			    							'uraian_skpd'=>$k['uraian_skpd'],
			    							'kode_bidang'=>$k['kode_bidang'],
			    							'id_program'=>$id_program,
			    							'updated_at'=>$now,
			    							'created_at'=>$now,
			    							'status'=>$k['status']
			    						]);

			    					}else{
			    						$id_kegiatan=$exk->id;
			    					}


			    					foreach ($k['indikator'] as  $ik) {
			    						$exik=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_ind_kegiatan as k')->where([
					    						'kode_daerah'=>$ik['kode_daerah'],
					    						'kode_skpd'=>$ik['kode_skpd'],
					    						'id_kegiatan'=>$id_kegiatan,
					    						'kode_bidang'=>$ik['kode_bidang'],
					    						'kode_ind'=>$ik['kode_ind']
			    						])->first();

			    						if(($exik)AND ($exik->status!=$ik['status'])){
				    						$id_ind_kegiatan=$exik->id;
				    						DB::table('prokeg.tb_'.$tahun.'_ind_kegiatan as k')->where('id',$id_ind_kegiatan)->update([
				    							'status'=>$ik['status'],
				    							'indikator'=>$ik['uraian'],
				    							'target_awal'=>$ik['target_awal'],
				    							'satuan'=>$ik['satuan'],
				    							'anggaran'=>$ik['anggaran'],
				    						]);
				    						$approve=true;

				    					}else if(empty($exik)){

				    						DB::table('prokeg.tb_'.$tahun.'_ind_kegiatan as k')->insertOrIgnore([
				    							'status'=>$ik['status'],
				    							'kode_daerah'=>$ik['kode_daerah'],
					    						'kode_skpd'=>$ik['kode_skpd'],
					    						'id_kegiatan'=>$id_kegiatan,
					    						'kode_bidang'=>$ik['kode_bidang'],
					    						'kode_ind'=>$ik['kode_ind'],
				    							'indikator'=>$ik['uraian'],
				    							'target_awal'=>$ik['target_awal'],
				    							'satuan'=>$ik['satuan'],
				    							'anggaran'=>$ik['anggaran'],
			    								'uraian_skpd'=>$ik['uraian_skpd'],

				    						]);



				    					}

			    					}

			    					foreach ($k['sumber_dana'] as  $ksd) {
			    						$exksd=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_s_dana as k')->where([
					    						'kode_daerah'=>$ksd['kode_daerah'],
					    						'kode_skpd'=>$ksd['kode_skpd'],
					    						'id_kegiatan'=>$id_kegiatan,
					    						'kode_bidang'=>$ksd['kode_bidang'],
					    						'kode_dana'=>$ksd['kode_dana']
			    						])->first();

			    						if(($exksd)AND ($exksd->status!=$ksd['status'])){
				    						$id_sd_kegiatan=$exksd->id;
				    						DB::table('prokeg.tb_'.$tahun.'_s_dana as k')->where('id',$id_sd_kegiatan)->update([
				    							'status'=>$ksd['status'],
				    							'sumber_dana'=>$ksd['sumber_dana'],
				    							'pagu'=>$ksd['pagu'],
				    							'kode_sumber_dana'=>$ksd['kode_sumber_dana'],				    							
				    						]);
				    					$approve=true;


				    					}else if(empty($exksd)){

				    						DB::table('prokeg.tb_'.$tahun.'_s_dana as k')->insertOrIgnore([
				    							'status'=>$ksd['status'],
				    							'sumber_dana'=>$ksd['sumber_dana'],
				    							'pagu'=>(float)$ksd['pagu'],
				    							'kode_sumber_dana'=>$ksd['kode_sumber_dana'],	
				    							'kode_daerah'=>$ksd['kode_daerah'],
					    						'kode_skpd'=>$ksd['kode_skpd'],
					    						'id_kegiatan'=>$id_kegiatan,
					    						'kode_bidang'=>$ksd['kode_bidang'],
					    						'kode_dana'=>$ksd['kode_dana']			    							
				    						]);

				    					}

			    						# code...
			    					}
			    					# code...
		    					}

		    				}
		    			}

		    			# code...
		    		}

		    		if($approve){
	    
				    
				    	DB::table('prokeg.tb_'.$tahun.'_program')->where([
							['kode_daerah','=',$kodepemda],
							['status','!=',$status],
						])->delete();

						$kk=DB::table('prokeg.tb_'.$tahun.'_kegiatan')->where([
							['kode_daerah','=',$kodepemda],
							['status','!=',$status],
						])->delete();
						
						DB::table('prokeg.tb_'.$tahun.'_ind_program')->where([
							['kode_daerah','=',$kodepemda],
							['status','!=',$status],
						])->delete();
						
						DB::table('prokeg.tb_'.$tahun.'_ind_kegiatan')->where([
							['kode_daerah','=',$kodepemda],
							['status','!=',$status],
						])->delete();
						
						DB::table('prokeg.tb_'.$tahun.'_s_dana')->where([
							['kode_daerah','=',$kodepemda],
							['status','!=',$status],
						])->delete();

						// dd($kk);

				    }


		    		
	    		}

	    		
	    	}
    	}

	    
	    // dd($jumlah_kegiatan);


    } 


    public function change($tahun=2020){
    	DBINIT::rkpd_db($tahun);
    

    	$datax=DB::table('prokeg_2.tb_'.$tahun.'_ind_program')->orderBy('id','asc')
    	->select('id','kode_daerah','kode_ind','anggaran','id_program','kode_skpd','kode_bidang','pelaksana as uraian_skpd','indikator')->chunk(500, function($data)use ($tahun){
    		$data=json_decode(json_encode($data),true);
    		DB::table('prokeg.tb_'.$tahun.'_ind_program')->insertOrIgnore($data);
    	});

    }


    public function indexing($tahun=2020,Request $request){

    	$provinsi=DB::table('master_daerah as d')->where('kode_daerah_parent',null)->get();

    	$data=DB::table('master_daerah as d')
    	->leftJoin("prokeg.tb_".$tahun."_status_file_daerah as f",'f.kode_daerah','=','d.id')
    	->select(
    		DB::RAW("(SELECT count(k.*) as exist FROM prokeg.tb_".$tahun."_kegiatan as k where k.kode_daerah=d.id group by k.kode_daerah limit 1) as exist"),
    		DB::RAW("(SELECT (k.status) as status FROM prokeg.tb_".$tahun."_program as k where k.kode_daerah=d.id  limit 1) as status"),
    		'd.nama',
    		'f.status as status_sipd',
    		'd.id as id',
    		DB::raw($tahun.' as tahun'),
    		DB::raw("(select concat(c.nama,
                (case when length(c.id)>3 then (select concat(' / ',d5.nama) from public.master_daerah as d5 where d5.id = left(c.id,2) ) end  )) from public.master_daerah as c where c.id=d.id) as nama_daerah")
    	);

    	if($request->provinsi){
    		$data=$data->where('d.kode_daerah_parent',$request->provinsi)->OrWhere('d.id',$request->provinsi);
    	}
    	$data=$data->orderBy('d.id','asc')->paginate(20);
    	$data->appends(['provinsi'=>$request->provinsi]);

    	return view('sistem.sipd.rkpd.index')->with('data',$data)->with('tahun',$tahun)->with('provinsi',$provinsi);


    }
}
