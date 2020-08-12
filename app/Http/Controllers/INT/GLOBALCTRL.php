<?php

namespace App\Http\Controllers\INT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class GLOBALCTRL extends Controller
{
    //


    public function show_list_select_satuan(Request $request){
        $data = DB::table('master_satuan')->select('kode as text', 'kode as id');
        if ($request->has('q')) {
            $cari = $request->q;
            $data=$data->where('kode', 'ILIKE', ('%'.$cari.'%'))->paginate(5);
            return response()->json($data);
        }else{
            $data=$data->paginate(5);
            return response()->json($data);
        }
    }

}
