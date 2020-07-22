<?php

namespace App\Http\Controllers\FORM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
use Validator;
use Hp;
use Carbon\Carbon;
class Kebijakan5Ctrl extends Controller
{
    //

    public function create(){
        $rpjmn=Hp::get_tahun_rpjmn(Hp::fokus_tahun());

        return view('form.kebijakan-5-tahun.create')->with([
            'rpjmn'=>$rpjmn
        ]);
    }


    public function store(Request $request){
        $rpjmn=Hp::get_tahun_rpjmn(Hp::fokus_tahun());

        $uid=Auth::id();

        $valid=Validator::make($request->all(),[
            'uraian'=>'required|string'
        ]);

        $urusan=Hp::fokus_urusan();

        $time=Carbon::now();

        if($valid->fails()){

            Alert::error('Error','');

            return back()->withInput();


        }else{

              DB::connection('form')->table('form.kb5_kondisi_saat_ini')->insert([
                'tahun_mulai'=>$rpjmn['start'],
                'tahun_selesai'=>$rpjmn['finish'],
                'uraian'=>$request->uraian,
                'id_urusan'=>$urusan['id_urusan'],
                'id_user'=>$uid,
                'created_at'=>$time,
                'updated_at'=>$time
            ]);

            Alert::success('Success','Berhasil menambahkan kondisi saat ini');

            return back();

        }


    }

    public function index(){
        // dd(DB::connection('form')->table('kb5_arah_kebijakan')->get());

        $rpjmn=Hp::get_tahun_rpjmn(Hp::fokus_tahun());
        $data=DB::connection('form')->table('kb5_kondisi_saat_ini as ksi')
        ->leftjoin('kb5_isu_stategis as ist','ist.id_kondisi','=','ksi.id')
        ->leftjoin('kb5_arah_kebijakan as ak','ak.id_isu','=','ist.id')
        ->leftjoin('kb5_indikator as i','i.id_kebijakan','=','ak.id')
        ->select(
            DB::raw("
                ksi.id as id_ksi,
                ksi.uraian as uraian_ksi,
                ist.id as id_ist,
                ist.uraian as uraian_ist,
                ak.id as id_ak,
                ak.uraian as uraian_ak,
                i.id as id_i,
                i.uraian as uraian_i,
                i.satuan as satuan_i,
                i.target as target_i,
                i.target_1 as target_n_i,
                i.tipe_value as tipe_value_i,
                i.kw_nas as kw_nas_i,
                i.kw_p as kw_p_i,
                i.kw_k as kw_k_i

            ")
        )
        ->where('ksi.tahun_mulai','<=',$rpjmn['start'])
        ->where('ksi.tahun_selesai','<=',$rpjmn['finish'])
        ->get()->toArray();



    	return view('form.kebijakan-5-tahun.index')->with([
            'data'=>$data,
            'rpjmn'=>$rpjmn


        ]);

    }
}
