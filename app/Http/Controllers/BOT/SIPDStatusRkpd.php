<?php

namespace App\Http\Controllers\BOT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Carbon\Carbon;
use Hp;
use DB;
class SIPDStatusRkpd extends Controller
{
    //


     public static  function getData($tahun=2020){

    	$time=((int)microtime(true));
    	$schema='prokeg';
     	Hp::checkDBProKeg($tahun);

    	$login_url='https://sipd.go.id/run/'.md5($time).'/?m=dashboard';
    	$uid='subpkp@bangda.kemendagri.go.id';
    	$pass='bangdapkp';


    	$connection = static::con($login_url, 'post', array(
    		'userX'=>$uid,
    		'pass'=>md5(md5($pass)),
    		'app'=>'rkpd',
    		'submit'=>1,
    		'user'=>md5(md5(strtolower(trim($uid)))),
    		'tahun'=>$tahun
    	));


    	if($connection){
    		$con=file_get_contents(storage_path('app/cookies/sipd_micro.json'));
     		$con=json_decode($con,true);
    		$time=((int)microtime(true));


    		$list_get='https://sipd.go.id/'.$con['url'].'?m=pusat_rkpd_dashboard&f=ajax_list_pemda&tipe=murni&_='.$time;
    		$data=static::con($list_get,'GET','');


    		
    		 $data=json_decode($data,true);
    		 // return $data;

    		 $data_return=[];

    		 foreach ($data['data'] as $key => $d) {
    		 	$status=0;

    		 	switch (1) {
    		 		case (int)$d['final']:
    		 			$status=5;
    		 			break;
    		 		case (int)$d['rankhir']:
    		 			$status=4;
    		 			break;
    		 		case (int)$d['ranrkpd']:
    		 			$status=3;
    		 			break;
    		 		case (int)$d['ranwal']:
    		 			$status=2;
    		 			break;
    		 		default:
    		 			# code...
    		 			$status=0;
    		 			break;
    		 	}

    		 	$kodar=str_replace('00', '', $d['kodepemda']);
    		 	$data_return[]=array('kode_daerah'=>$kodar,'status'=>$status,'updated_at'=>Carbon::now(),'last_date'=>$d['lastpost']);

    		 }

    		 foreach ($data_return as $key => $d) {


    		 	if(substr($d['kode_daerah'],0,2)!='99'){
    		 		$ds=DB::connection('sink_prokeg')->table($schema."."."tb_".$tahun."_status_file_daerah")
	    		 	->where('kode_daerah',$d['kode_daerah'])->first();
	    		 	if($ds){
	    		 		$ds=DB::connection('sink_prokeg')->table($schema."."."tb_".$tahun."_status_file_daerah")
	    		 		->where('id',$ds->id)
	    		 		->update($d);

	    		 	}else{
	    		 	$ds=DB::connection('sink_prokeg')->table($schema."."."tb_".$tahun."_status_file_daerah")
	    		 	->where('kode_daerah',$d['kode_daerah'])->insertOrIgnore([
	    		 		'kode_daerah'=>$d['kode_daerah'],
	    		 		'status'=>$d['status'],
	    		 		'last_date'=>$d['last_date'],
	    		 		'created_at'=>Carbon::now(),
	    		 		'updated_at'=>Carbon::now()
	    		 		]);
	    		 	}
    		 	}else{
    		 	}
    		 }

    		

    		 Storage::put('BOT/SIPD/'.$tahun.'/status_daerah.json',json_encode($data_return,JSON_PRETTY_PRINT));
    		 return true;

    	}else{
            return false;
        }




    }


	static function con($url, $method='', $vars=''){

		if(!file_exists(storage_path('app/cookies/sipd_cookies.txt')) ){
			Storage::put('cookies/sipd_cookies.txt','');
		}

    	$time=((int)microtime(true));

	 	$ch = curl_init();
	    if ($method == 'post') {
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
	    }else{
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
	    }

	    curl_setopt($ch, CURLOPT_URL, $url);
	    $agent  = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.92 Safari/537.36";


		$headers[] = "Accept: */*";
		$headers[] = "Connection: Keep-Alive";

		// basic curl options for all requests
		curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);         
		curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, storage_path('app/cookies/sipd_cookies.txt'));
	    curl_setopt($ch, CURLOPT_COOKIEFILE, storage_path('app/cookies/sipd_cookies.txt'));
	    

	    $buffer = curl_exec($ch);
	    $prefix = preg_quote('run/');
        $suffix = preg_quote('/');

        $matches=[];
	    preg_match_all("!$prefix(.*?)$suffix!", (string)$buffer, $matches);

	    
	    if((count($matches)>0)and(isset($matches[0]))){
	    	foreach ($matches[1] as $uk=>$u) {
                $temp=(trim(str_replace('/','', str_replace('"','', $u))));
                if($temp!=''){
                    $data_to_bobol=array('url'=>$matches[0][$uk],'time'=>$time);
                    Storage::put(('cookies/sipd_micro.json'),json_encode($data_to_bobol));
                }
                # code...
            }
	    }


	   

	    // curl_close($ch);
	    return $buffer;
 	}

    public static function getRakorteX($tahun,$kodepemda){
        $token='d1d1ab9140c249e34ce356c91e9166a6';
        $host='https://sipd.go.id/';
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Authorization: Bearer ".$token
            ]
        ];

         if(strlen($kodepemda)<4){
            $kodepemda=$kodepemda.'00';

        }
        $kode_daerah=str_replace('00', '', $kodepemda);


        if(file_exists(storage_path('app/'.'BOT/SIPD/RAKORTEK/'.$tahun.'/'.$kode_daerah.'.json'))){
            $data=file_get_contents(storage_path('app/'.'BOT/SIPD/RAKORTEK/'.$tahun.'/'.$kode_daerah.'.json'));
            $data=trim($data,true);
            $data=json_decode($data,true);
            return $data;

        }


        $context = stream_context_create($opts);

       

        $path=$host.'run/serv/get_rakortek.php?kodepemda='.$kodepemda;
        $path=urldecode($path);
        $data=file_get_contents($path,false, $context);
        $data=trim($data,true);
      
        $data=json_decode($data,true);
        Storage::put('BOT/SIPD/RAKORTEK/'.$tahun.'/'.$kode_daerah.'.json',json_encode($data,JSON_PRETTY_PRINT));

        return $data;
    }

   


}
