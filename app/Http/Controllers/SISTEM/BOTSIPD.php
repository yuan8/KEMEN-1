<?php

namespace App\Http\Controllers\SISTEM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use HP;
use DB;
use Storage;
use DBINIT;
use Carbon\Carbon;
class BOTSIPD extends Controller
{

	static function  host(){
		if( strpos($_SERVER['HTTP_HOST'], '192.168.123.190') !== false) {

			return 'http://192.168.123.195/';

		}else{

			return 'https://sipd.go.id/';
		}

	}

	static $token='d1d1ab9140c249e34ce356c91e9166a6';
    //
    public function getDataJson($tahun,$kodepemda,Request $request){	
    	set_time_limit(-1);



    	DBINIT::rkpd_db($tahun);

		if(strlen($kodepemda)<4){
			$kode_daerah=$kodepemda.'00';
		}else{
			$kode_daerah=$kodepemda;
		}
		$kodepemda=str_replace('00', '',$kodepemda);
		$status=0;

    	

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
			$status=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_status_file_daerah')
			->where('kode_daerah',$kodepemda)->where('updated_at','>',Carbon::now()->add(-1, 'hour'))->pluck('status')->first();
			if($status){


			}else{
				\Artisan::call('sipd:status-rkpd '.$tahun);
				$status=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_status_file_daerah')
				->where('kode_daerah',$kodepemda)->pluck('status')->first();
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

			if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json'))){

				$dt=file_get_contents(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json'));
				$dt=json_decode($dt);
				if($dt['status']==$status){
					$approve=false;
					$server_output=$dt;
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
				$server_output= json_decode(trim($server_output));
			}
			
		}else{
			$server_output=array();
		}




		Storage::put('BOT/SIPD/JSON/'.$tahun.'/DATA/'.$kodepemda.'.json',json_encode(array('status'=>$status,'data'=>$server_output),JSON_PRETTY_PRINT));


		Storage::put('BOT/SIPD/JSON/'.$tahun.'/STATUS/'.$status.'/'.$kodepemda.'.json',json_encode(array('status'=>$status,'data'=>$server_output),JSON_PRETTY_PRINT));

		static::makeData($tahun,$kodepemda);


		if($request->json){

			$nextid=DB::table('master_daerah')->where('id','>',$kodepemda)->first();
			
			return view('sistem.sipd.rkpd.next')->with('daerah',$nextid)
			->with(['tahun'=>$tahun,'kodepemda'=>$kodepemda]);

		}

    	static::storingFile($tahun,$kodepemda);


		return back();

		return 'data-transform-done';

    }


    public static function makeData($tahun,$kodepemda){
    	$jumlah_kegiatan=0;
    	$jumlah_program=0;
    	$jumlah_ind_program=0;
    	$jumlah_ind_kegiatan=0;



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
    			$id_bidang=DB::table('master_urusan')->where('nama','ilike',('%'.$u['uraibidang'].'%'))->pluck('id')->first();

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
    					
    					}else{
    					$jumlah_kegiatan+=1;

    					}
    					

    					$data_return['SKPD@'.$kodeskpd]['program']['PROGRAM@.'.$kodeprogram]['kegiatan']['KEGIATAN@'.$kode_kegiatan]=array(
    						'kode_daerah'=>$kodepemda,
    						'id_urusan'=>$id_bidang,
    						'kode_kegiatan'=>$kode_kegiatan,
    						'uraian'=>trim($k['uraikegiatan']),
    						'anggaran'=>(float)$k['pagu'],
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

    		Storage::put('BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json',json_encode(array('status'=>$status,'jumlah_program'=>$jumlah_program,'jumlah_kegiatan'=>$jumlah_kegiatan,'data'=>$data_return),JSON_PRETTY_PRINT));

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

    	if($in_status!=5){
	    	if(file_exists(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json'))){
	    		$data=json_decode(file_get_contents(storage_path('app/BOT/SIPD/JSON/'.$tahun.'/DATA_MAKE/'.$kodepemda.'.json')),true);

	    		$status=$data['status'];
	    		if(true){
	    			// $in_status!=$data['status']
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
				    							'pagu'=>$ksd['pagu'],
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

						DB::table('prokeg.tb_'.$tahun.'_kegiatan')->where([
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
