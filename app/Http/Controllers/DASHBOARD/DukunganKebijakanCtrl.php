<?php

namespace App\Http\Controllers\DASHBOARD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class DukunganKebijakanCtrl extends Controller
{
    //

    public function index(){
    	$tahun=2020;
    	return view('dashboard.dukungan-kebijakan.index')->with(['tahun'=>$tahun]);
    }

    public function detail($tahun,$kodepemda){

    	$slug=
    	return view('dashboard.dukungan-kebijakan.detail');
    }
}


// =IF(NOT(ISBLANK(E3));
// 	(A3 & "." & B3 & "." &C3&"."&D3&"."&E3);
// 	IF(NOT(ISBLANK(D3));
// 		(A3 & "." & B3 & "." &C3&"."&D3);
// 		IF(NOT(ISBLANK(C3));
// 			(A3 & "." & B3 & "." &C3);
// 			IF(NOT(ISBLANK(B3));(A3 & "." & B3);
// 				IF(NOT(ISBLANK(A3));(A3);"")
// 			)
// 		)
// 	)
// )