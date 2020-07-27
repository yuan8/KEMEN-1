<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use DB;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;

class InitCtrl extends Controller
{
    //
    public function test(Request $request){
        return $request->all();
        return (session('fokus_urusan'));

    }


    public function push(Request $request){
       $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
                            ->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic('news');

        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

        $ok=$topicResponse->isSuccess();
        $ok=$topicResponse->shouldRetry();
        dd($ok);
        
        $ok=$topicResponse->error();


    }

    public function refresh(Request $request){

        return view('refreshing')->with('url',url()->previous());
    }


    public function pindah_urusan($id, Request $request){
    	$array=array_keys(session('route_access'));
       


    	if(in_array($id, $array)){
    		Alert::success('Sukses','View Urusan Telah Berubah');

    		session(['fokus_urusan'=>array('id_urusan'=>$id,'nama'=>session('route_access')[$id])]);
    		return redirect()->route('init.refresing')->with('url',url()->previous());

    	}else{

    		Alert::error('Gagal','Anda Tidak Dapat Merubah Urusan');
    		return back();
    	}
    }

    public function pindah_tahun($id=null, Request $request){
       
        if($request->tahun){
            Alert::success('Sukses','View Urusan Telah Berubah');

            session(['fokus_tahun'=>$request->tahun]);
            return redirect()->route('init.refresing')->with('url',url()->previous());

        }else{

            Alert::error('Gagal','Anda Tidak Dapat Merubah Urusan');
            return back();
        }
    }
}
