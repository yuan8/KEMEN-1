<?php

namespace App\Http\Controllers\CROW;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use DB;
use Carbon\Carbon;
use Hp;
class SIPDCTRL extends Controller
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


	static public function codeLibrari($tahun,$kodepemda){
		$code_list=[];

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

		$path=static::host().'run/serv/get.php?tahun='.($tahun).'&kodepemda='.$kodepemda;
		// dd($path);
		$path=urldecode($path);
		$data=file_get_contents($path,false, $context);
		dd($data);

	}

    public function getData($tahun,$kodepemda){


        Hp::checkDBProKeg($tahun);

    	set_time_limit(-1);

    	$kode_bidang=[];
    	$opts = [
		    "http" => [
		        "method" => "GET",
		          "header" => "Authorization: bearer ".static::$token

		    ]
		];

		if(strlen($kodepemda)<4){
			$kode_daerah=$kodepemda.'00';
		}else{
			$kode_daerah=$kodepemda;
		}

		$context = stream_context_create($opts);

		// Open the file using the HTTP headers set above
		$file=null;
		try {

			if(file_exists(storage_path('app/bot-sipd/pro-keg-data-daerah/'.$tahun.'/'.$kodepemda.'.json'))){
				$file=file_get_contents(storage_path('app/bot-sipd/pro-keg-data-daerah/'.$tahun.'/'.$kodepemda.'.json'));
			}else{
				$path=static::host().'run/serv/get.php?tahun='.($tahun).'&kodepemda='.$kode_daerah;
				$path=urldecode($path);
				$file=file_get_contents($path,false, $context);
				if(!(strpos($file, '[')!==false)){
					$file='[]';
				}
			}


		}
		catch (exception $e) {
			$file=[];
		}
		finally {
		    //optional code that always runs
			if($file){
				$data_recorded=[];
		   		$file=json_decode($file,true);
		   		// dd($file);

		   		// if($file!=[]){
		   		// 	Storage::put('bot-sipd/pro-keg-data-daerah/'.$tahun.'/'.$kodepemda.'.json',json_encode($file,JSON_PRETTY_PRINT));
		   		// }

		   		foreach ($file as $key => $value) {
		   			$data=[];
		   			$kode_skpd=isset($value['kodeskpd'])?$value['kodeskpd']:null;


		   			foreach ($value['program'] as $key2 => $value2) {
		   				# code...

		   				$kodeprogram=(isset($value2['kodeprogram'])?$value2['kodeprogram']:null);

		   				$id_bidang_daerah=isset($value2['kodebidang'])?$value2['kodebidang']:null;
		   				$data=array(
		   					'kode_pro'=>$tahun.'d'.$kodepemda.'@'.$kodeprogram,
		   					'kodeskpd'=>$kode_skpd,
		   					'id_bidang_daerah'=>$id_bidang_daerah,
		   					'kode'=>$kodeprogram,
		   					'uraian_bidang_daerah'=>isset($value2['uraibidang'])?$value2['uraibidang']:null,
		   					'uraian'=>static::lower(isset($value2['uraiprogram'])?$value2['uraiprogram']:null),
		   					'tahun'=>$tahun,
		   					'kode_daerah'=>$kodepemda,
		   					'id_nomenlatur'=>null,
		   					'id_bidang'=>null,
		   					'id_sub_bidang'=>null,
		   					'id_psn'=>null,
		   					'id_sdgs'=>null,
		   					'id_spm'=>null,
		   					'id_nspk'=>null,
		   					'indikator'=>[],
		   					'kegiatan'=>[],
		   				);

		   				$kode_bidang[isset($value2['kodebidang'])?$value2['kodebidang']:'xxx']=array(
		   					'nama'=>isset($value2['uraibidang'])?$value2['uraibidang']:null,
		   					'kode'=>isset($value2['kodebidang'])?$value2['kodebidang']:'xxx',
		   					'id_bidang'=>null,
		   					'uraian_bidang'=>null);

		   				if(isset($value2['capaian']) and is_array($value2['capaian'])){
		   					$indikator=[];
		   					foreach ($value2['capaian'] as $key3 => $value3) {
		   						$indikator=array(
		   							'kode_ind'=>$tahun.'d'.$kodepemda.'@'.$kodeprogram.'.ind.'.$value3['kodeindikator'],
		   							'kodeskpd'=>$kode_skpd,
		   							'id_bidang_daerah'=>$id_bidang_daerah,
		   							'kode'=>isset($value3['kodeindikator'])?$value3['kodeindikator']:NULL,
		   							'kode_program'=>$kodeprogram,
		   							'id_nomenlatur'=>null,
		   							'uraian'=>static::lower(isset($value3['tolokukur'])?$value3['tolokukur']:null),
		   							'target'=>isset($value3['target'])?$value3['target']:null,
		   							'satuan_target'=>isset($value3['satuan'])?$value3['satuan']:null,
		   							'tahun'=>$tahun,
		   							'anggaran'=>isset($value3['pagu'])?(float)$value3['pagu']:null,
		   							'kode_daerah'=>$kodepemda,
		   						);

		   						if((!empty($indikator['kode']))and(!empty($indikator['uraian']))){
		   								$data['indikator'][]=$indikator;
			   					}

		   					}

		   				}

		   				if(isset($value2['kegiatan']) and is_array($value2['kegiatan'])){
			   				foreach ($value2['kegiatan'] as $key3 => $value3) {

			   					$kodekegiatan=$tahun.'d'.$kodepemda.'@'.$kodeprogram.'.k.'.$value3['kodekegiatan'];

			   					$kegiatan=array(
			   						'kode_keg'=>$tahun.'d'.$kodepemda.'@'.$kodeprogram.'.k.'.$value3['kodekegiatan'],
		   							'kode'=>isset($value3['kodekegiatan'])?$value3['kodekegiatan']:null,
		   							'uraian'=>static::lower(isset($value3['uraikegiatan'])?$value3['uraikegiatan']:null),
		   							'kodeskpd'=>$kode_skpd,
		   							'id_bidang_daerah'=>$id_bidang_daerah,

		   							'anggaran'=>isset($value3['pagu'])?(float)$value3['pagu']:null,
		   							'tahun'=>$tahun,
		   							'kode_daerah'=>$kodepemda,
		   							'indikator'=>[],
		   							'sub_kegiatan'=>[],
			   					);


			   					if(isset($value3['indikator']) and is_array($value3['indikator'])){
			   						foreach ($value3['indikator'] as $key4 => $value4) {
			   							$indikator2=array(
					   						'kode_ind'=>$tahun.'d'.$kodepemda.'@'.$kodeprogram.'.k.'.$value3['kodekegiatan'].'.ind.'.$value4['kodeindikator'],
		   									'kode'=>isset($value4['kodeindikator'])?$value4['kodeindikator']:null,
					   						'kode_kegiatan'=>$value3['kodekegiatan'],
				   							'uraian'=>static::lower(isset($value4['tolokukur'])?$value4['tolokukur']:null),
		   									'kodeskpd'=>$kode_skpd,
		   									'id_bidang_daerah'=>$id_bidang_daerah,
				   							'kode_daerah'=>$kodepemda,
				   							'anggaran'=>isset($value4['pagu'])?(float)$value4['pagu']:null,
		   									'satuan_target'=>isset($value4['satuan'])?$value4['satuan']:null,
		   									'target'=>isset($value4['target'])?$value4['target']:null,
		   									'tahun'=>$tahun,

					   					);

					   					if(strlen($indikator2['satuan_target'])>255){
					   						$indikator2['target'].=$indikator2['satuan_target'];
					   						$indikator2['satuan_target']='';
					   					}


						   				if((!empty($indikator2['kode']))and(!empty($indikator2['uraian']))){
						   					$kegiatan['indikator'][]=$indikator2;
				   						}

			   						}

			   					}

			   					if(isset($value3['subkegiatan']) and is_array($value3['subkegiatan'])){
			   						foreach ($value3['subkegiatan'] as $key5 => $value5){
			   							$sub=array(
			   								'kode_sub'=>$tahun.'d'.$kodepemda.'@'.$kodeprogram.'.k.'.$value3['kodekegiatan'].'.sub.'.$value5['kodesubkegiatan'],
		   									'kode'=>isset($value5['kodesubkegiatan'])?$value5['kodesubkegiatan']:NULL,
			   								'urian'=>static::lower(isset($value5['uraisubkegiatan'])?$value5['uraisubkegiatan']:null),
			   								'anggaran'=>isset($value5['pagu'])?(float)$value5['pagu']:null,
		   									'tahun'=>$tahun,
		   									'kode_daerah'=>$kodepemda,
		   									'indikator'=>[]
			   							);

			   							if(isset($value5['indikator']) and is_array($value5['indikator']) ){

			   								foreach ($value5['indikator'] as $key6 => $value6) {
			   									$sub_ind=array(
						   						'kode_ind'=>$tahun.'d'.$kodepemda.'@'.$kodeprogram.'.k.'.$value3['kodekegiatan'].'.sub.'.$value5['kodesubkegiatan'].'.ind.'.$value6['kodeindikator'],
		   										'kode'=>isset($value6['kodeindikator'])?$value6['kodeindikator']:NULL,
		   										'tahun'=>$tahun,
						   						'kode_sub_kegiatan'=>$value5['kodesubkegiatan'],
					   							'uraian'=>static::lower(isset($value6['tolokukur'])?$value6['tolokukur']:null),
					   							'kode_daerah'=>$kodepemda,
					   							'anggaran'=>isset($value6['pagu'])?(float)$value6['pagu']:null,
					   							'satuan_target'=>isset($value6['satuan'])?$value6['satuan']:null,
		   										'target'=>isset($value6['target'])?$value6['target']:null,
				   								);


				   								if((!empty($sub_ind['kode']))and(!empty($sub_ind['uraian']))){
			   										$sub['indikator'][]=$sub_ind;
			   									}



			   								}


			   							}

			   							if((!empty($sub['kode']))and(!empty($sub['uraian']))){

			   								$kegiatan['sub_kegiatan'][]=$sub;
			   							}
			   						}




			   					}
			   					if((!empty($kegiatan['kode']))and(!empty($kegiatan['uraian']))){

			   						$data['kegiatan'][]=$kegiatan;
			   					}


			   				}
		   				}

		   				if((!empty($data['kode']))and(!empty($data['uraian']))){
		   					$data_recorded[]=$data;
		   				}


		   			}
		   		}





		   		$drah=DB::table('master_daerah as d')
				->join('prokeg.tb_'.$tahun.'_kegiatan as k','k.kode_daerah','=','d.id','left outer')
				->where('k.id',NULL)
				->where('d.id','>',$kodepemda)
				->select('d.*')
				->orderBy('d.id','ASC')
				->first();

		   		if($data_recorded!=[]){
		   			static::storeDB($data_recorded,$tahun,$kodepemda);
		   			Storage::put('bot-sipd/pengkodean_bidang_daerah/'.$kodepemda.'.json',json_encode($kode_bidang,JSON_PRETTY_PRINT));
		   			Storage::put('bot-sipd/integrasi-sipd/'.$tahun.'/'.$kodepemda.'.json',json_encode($data_recorded,JSON_PRETTY_PRINT));
		   			$data_dat_recorded=[$kodepemda];

				   	// 		if(file_exists(storage_path('app/bot-sipd/daerah-recorded/'.Carbon::now()->format('Y').'/data.json'))){
				   	// 			$data_dat_recorded=json_decode(file_get_contents(storage_path('app/bot-sipd/daerah-recorded/'.Carbon::now()->format('Y').'/data.json')));
								// array_push($data_dat_recorded,$kodepemda);
								// array_unique($data_dat_recorded);
				   	// 		}

		   			$json_2=[];
			    	foreach ($kode_bidang as  $k) {
			    		$json_2[]=array(
			    			'kode_daerah'=>$kodepemda,
			    			'kode_urusan'=>$k['kode'],
			    			'uraian_urusan_daerah'=>static::lower($k['nama']?$k['nama']:'-')
			    		);
			    	}

				  	DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_urusan')
				  	->insertOrIgnore($json_2);

		   			Storage::put('bot-sipd/daerah-recorded/'.Carbon::now()->format('Y').'/data.json',json_encode($data_dat_recorded,JSON_PRETTY_PRINT));


		   		}



		   		if(!$drah){
		   			return 'data selesai';
		   		}


		   		return redirect()->route('sipdd',['id_next'=>$drah->id,'nama'=>$drah->nama,'tahun'=>$tahun]);

			}else{
			}


		// success


		}

		return [];




    }

    static function lower($text=null){

    	if((!empty($text))){
    		return mb_strtolower(trim($text),'UTF-8');
   		}else{
    	return null;
    	}

    }

    public static function storeDB($data,$tahun=null,$kodepemda=null){
        if($tahun==null){
            return '';
        }

        foreach($data as $d){
            $idp=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_program')
            ->where(
            	[
            		['kode_daerah','=',$d['kode_daerah']],
            		['kode_program','=',$d['kode']],
            		['tahun','=',$d['tahun']],
            		['kodeskpd','=',$d['kodeskpd']],
            		['id_bidang_daerah','=',$d['id_bidang_daerah']]
            	])
            ->orWhere([
            		['kode_daerah','=',$d['kode_daerah']],
            		['uraian','ilike',$d['uraian']],
            		['tahun','=',$d['tahun']],
            		['kodeskpd','=',$d['kodeskpd']],
            		['id_bidang_daerah','=',$d['id_bidang_daerah']]


            ])->pluck('id')->first();

           

            if(!$idp){
                $idp=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_program')
                ->insertGetId([
                    'kode_daerah'=>$d['kode_daerah'],
                    'kode_program'=>$d['kode'],
                    'uraian'=>$d['uraian'],
                    'tahun'=>$d['tahun'],
            		'kodeskpd'=>$d['kodeskpd'],
            		'id_bidang_daerah'=>$d['id_bidang_daerah'],

                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ]);

            }

            foreach($d['kegiatan'] as $d2){

                $idk=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_kegiatan')->where([
                    'kode_daerah'=>$d2['kode_daerah'],
                    'kode_kegiatan'=>$d2['kode'],
                    'tahun'=>$d2['tahun'],
                    'kodeskpd'=>$d2['kodeskpd'],
            		'id_bidang_daerah'=>$d2['id_bidang_daerah']

                ])->pluck('id')->first();
                if(!$idk){

                    $idk=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_kegiatan')
                    ->insertGetId([
                        'kode_daerah'=>$d2['kode_daerah'],
                        'kode_kegiatan'=>$d2['kode'],
                        'uraian'=>$d2['uraian'],
                        'tahun'=>$d2['tahun'],
                        'id_program'=>$idp,
                        'anggaran'=>$d2['anggaran'],
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                        'kodeskpd'=>$d2['kodeskpd'],
            			'id_bidang_daerah'=>$d2['id_bidang_daerah']
                    ]);

                }


                foreach ($d2['indikator'] as  $i) {
                            # code...
                    $idik=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_ind_kegiatan')->where([
                        'id_kegiatan'=>$idk,
                        'kode_ind'=>$i['kode'],
                        'kode_daerah'=>$i['kode_daerah'],
                        'tahun'=>$i['tahun'],
                        'kodeskpd'=>$i['kodeskpd'],
            			'id_bidang_daerah'=>$i['id_bidang_daerah']

                    ])->pluck('id')->first();
                    if(!$idik){
                        $idik=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_ind_kegiatan')->insertGetId([
                        'id_kegiatan'=>$idk,
                        'kode_ind'=>$i['kode'],
                        'indikator'=>$i['uraian'],
                        'target_awal'=>$i['target'],
                        'satuan'=>$i['satuan_target'],
                        'anggaran'=>$i['anggaran'],
                        'tahun'=>$i['tahun'],
                        'kode_daerah'=>$i['kode_daerah'],
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                        'kodeskpd'=>$i['kodeskpd'],
            			'id_bidang_daerah'=>$i['id_bidang_daerah']


                        ]);
                    }

                }


            }

            foreach ($d['indikator'] as $ip) {


                $idip=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_ind_program')
                ->where([
                    'id_program'=>$idp,
                    'kode_ind'=>$ip['kode'],
                    'tahun'=>$ip['tahun'],
                    'kode_daerah'=>$ip['kode_daerah'],
                    'kodeskpd'=>$ip['kodeskpd'],
            		'id_bidang_daerah'=>$ip['id_bidang_daerah']

                ])->pluck('id')->first();

                if(!$idip){
                    $idip=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_ind_program')->insertGetId([
                    'id_program'=>$idp,
                    'kode_ind'=>$ip['kode'],
                    'indikator'=>$ip['uraian'],
                    'target_awal'=>$ip['target'],
                    'satuan'=>$ip['satuan_target'],
                    'anggaran'=>$ip['anggaran'],
                    'kode_daerah'=>$ip['kode_daerah'],

                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                     'tahun'=>$ip['tahun'],
                     'kodeskpd'=>$ip['kodeskpd'],
            		'id_bidang_daerah'=>$ip['id_bidang_daerah']


                    ]);
                }
            }


        }


        // sini
        if($kodepemda!=null){
        	static::updateDb($kodepemda,$tahun);
        }

    }


    public static function updateDb($kodepemda,$tahun=null,$id_bidang_daerah=null){

    	$kode_bid=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_urusan')
    			->where('id_urusan','=',null)
    			->where('kode_daerah',$kodepemda)->get();

    	foreach ($kode_bid as $key => $k) {
    		$bid=DB::table('master_urusan')->where('nama','ilike',('%'.$k->uraian_urusan_daerah.'%'))->first();
    		if($bid){

    			DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_urusan')->where('id',$k->id)
    			->where('id_urusan',null)
    			->update([
    				'id_urusan'=>$bid->id
    			]);
    		}
    		# code...
    	}



    	if($id_bidang_daerah==null){
    			$map=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_urusan')
    			->where('id_urusan','!=',null)
    			->where('kode_daerah',$kodepemda)->get();
    	}else{

    		$map=DB::connection('sink_prokeg')->table('tb_'.$tahun.'_map_urusan')
    			->where('id_urusan','!=',null)
    			->where('kode_daerah',$kodepemda)->where('id',$id_bidang_daerah)->get();
    	}


    	foreach ($map as $key => $value) {

    		DB::connection('sink_prokeg')->table('tb_'.$tahun.'_kegiatan')
    		->where('id_urusan',null)->where('kode_daerah',$kodepemda)
    		->where('kode_kegiatan','ilike',($value->kode_urusan.'%'))
    		->update([
    			'id_urusan'=>$value->id_urusan,
    			'updated_at'=>Carbon::now()
    		]);
    		# code...
    	}

    }



    public function storeUpdateTagging(){
    	
    }

}
