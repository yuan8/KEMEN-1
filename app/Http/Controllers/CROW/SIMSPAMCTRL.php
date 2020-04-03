<?php

namespace App\Http\Controllers\CROW;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpQuery\PhpQuery;
use DB;
class SIMSPAMCTRL extends Controller
{

 	public function login(){
 		$loginUrl = 'http://airminum.ciptakarya.pu.go.id/sinkronisasi/dashboard.php'; //action from the login form
		$loginFields = array('username'=>'admin', 'password'=>'spam3257','AppType'=>'spam'); //login form field names and values
		$remotePageUrl = 'http://airminum.ciptakarya.pu.go.id/sinkronisasi/rosimspamdatalist.php';
		$login = static::con($loginUrl, 'post', $loginFields);


		return view('bot.simspam.menu');
 	} 

 	public function login_form(){
 		return view('bot.simspam.login');
 	}

 	public function storeKodeDaerah(){
 		// $file=scandir(app_path('NodeJS/SIMSPAM/storage/master_daerah'));
 		// foreach ($file as $key => $d) {
 		// 	# code...
 		// 	if($key>1){
 		// 		$data=file_get_contents(app_path('NodeJS/SIMSPAM/storage/master_daerah/'.$d));
 		// 		$data=json_decode($data,true);
 		// 		DB::connection('simspam')->table('master_daerah_simspam')
 		// 		->insertOrIgnore($data);
 		// 	}
 		// }

 	
 		$dataa=[];
 		$data=DB::connection('simspam')->table('master_daerah_simspam')
 		->orderBy('id','ASC')->get();
 		foreach ($data as $key => $value) {
 			$dataa[str_replace(' ', '_', $value->nama)]=array(
 				'id_permendagri'=>$value->id_permendagri,
 				'nama'=>$value->nama,
 				'id'=>$value->id

 			);
 			// # code...
 			// $nama=str_replace('KABUPATEN ', '', $value->nama);
 			// $nama=str_replace(' ', '', $nama);

 			// $d=DB::table('master_daerah')
 			// ->where('nama','ilike',('%'.$value->nama.'%'))
 			// ->orWhere(DB::raw("replace(nama,' ','')"),'ilike',('%'.$nama.'%'))
 			// ->first();
 			// if($d){
 			// 	DB::connection('simspam')->table('master_daerah_simspam')->where('id',$value->id)
 			// 	->update([
 			// 		'id_permendagri'=>$d->id
 			// 	]);
 			// }
 		}

 		return ($dataa);
 	}


 	static function con($url, $method='', $vars=''){

	 	$ch = curl_init();
	    if ($method == 'post') {
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
	    }

	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, public_path('/cookies/cookies.txt'));
	    curl_setopt($ch, CURLOPT_COOKIEFILE, public_path('/cookies/cookies.txt'));
	    $buffer = curl_exec($ch);
	    curl_close($ch);
	    return $buffer;
 	}


 	public function scrap_jaringan_perpipaan(Request $request){

 		$page=static::con('http://airminum.ciptakarya.pu.go.id/sinkronisasi/rosimspamdatalist.php');

 		// $dom = new \DOMDocument();
 		  // $dom->preserveWhiteSpace = false;
   		// $dom->formatOutput = true;

 		$page=preg_replace('/(\v|\s)+/', ' ', (($page)));
 		// // $page=preg_replace('/&gt;/', '>', $page);
 	 	if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $page, $matches)) {
       	 $body = $matches[1];
    	}
 		// $page=trim($page,true);
 		// $page=(html_entity_decode($page));
 		// 	dd($page);

   //  	$dom->loadHTML(html_entity_decode($page));

   //  	dd($dom);





 		return view('bot.simspam.rekap')->with(['content'=>$body]);

 	}

 	public function download(Request $request){

 		   $htmlPhpExcel = new \Ticketpark\HtmlPhpExcel\HtmlPhpExcel($request->data);
 		   header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
 		   header('Content-Disposition: attachment;filename='.($request->name?$request->name:'excel-report').'.xlsx');

 		   $htmlPhpExcel->process()->save('php://output');
 	}


 	public function rekapKota(Request $request){


 		if(isset($request->provinsi)){

			$page=static::con('http://airminum.ciptakarya.pu.go.id/sinkronisasi/rosimspamdataproplist.php?id='.$request->provinsi);

	 		$page=preg_replace('/(\v|\s)+/', ' ', (($page)));
	 		// // $page=preg_replace('/&gt;/', '>', $page);
	 	 	if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $page, $matches)) {
	       	 $body = $matches[1];
	    	}

	    	$ids=DB::table('master_daerah')
	    	->select('*',DB::raw("CONCAT('".route('bot.simspam.detail.kota')."/',id) as link_detail"))
	    	->where('id','ilike',$request->provinsi.'%' )->get();


	    	$provinsi=DB::table('master_daerah')->where('id',$request->provinsi)->first();

	    	return view('bot.simspam.rekapkota')->with(['content'=>$body,'ids'=>$ids,'provinsi'=>$provinsi]);

 		}


 	

 		
 	}


 	public function detailKota($id,Request $request){

 		$page=static::con('http://airminum.ciptakarya.pu.go.id/sinkronisasi/rosimspamdataunitlist.php?id='.$id);
 		


 		$page=preg_replace('/(\v|\s)+/', ' ', (($page)));
 	 	if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $page, $matches)) {
       	 $body = $matches[1];
    	}

    	// dd($request->data['nama']);

    	return view('bot.simspam.detailkota')->with(['content'=>$body,'nama'=>$request->data['nama']]);


 	}

}

