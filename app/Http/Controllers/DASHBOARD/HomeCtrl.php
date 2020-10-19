<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class HomeCtrl extends Controller
{
    //

    public function index(){
      dd(md5(12345678));
      dd(DB::table('users')->where('id',1)->get());
    	return view('dashboard.home.index');
    }
}
