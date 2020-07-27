<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->post('/test', 'InitCtrl@test');

Route::post('/int-log-tokenizer','LoginBarcodeCtrl@update_token')->name('br.login.update.token');
Route::post('/ilogin','LoginBarcodeCtrl@force_login')->name('br.login');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('check_login_barcode','LoginBarcodeCtrl@login');

Route::prefix('form')->middleware(['auth:api','can:ifAlive'])->group(function(){

		Route::prefix('kebijakan-pusat/')->group(function(){
			Route::get('/get-uu', 'FORM\KebijakanCtrl@api_get_uu')->name('api.kebijakan.pusat.get.uu');
			Route::post('/store-uu/{id}', 'FORM\KebijakanCtrl@api_store_uu')->name('api.kebijakan.pusat.store.uu');

			Route::get('/get-pp', 'FORM\KebijakanCtrl@api_get_pp')->name('api.kebijakan.pusat.get.pp');
			Route::post('/store-pp/{id}', 'FORM\KebijakanCtrl@api_store_pp')->name('api.kebijakan.pusat.store.pp');

			Route::get('/get-perpres', 'FORM\KebijakanCtrl@api_get_perpres')->name('api.kebijakan.pusat.get.perpres');
			Route::post('/store-perpres/{id}', 'FORM\KebijakanCtrl@api_store_perpres')->name('api.kebijakan.pusat.store.perpres');

			Route::get('/get-permen', 'FORM\KebijakanCtrl@api_get_permen')->name('api.kebijakan.pusat.get.permen');
			Route::post('/store-permen/{id}', 'FORM\KebijakanCtrl@api_store_permen')->name('api.kebijakan.pusat.store.permen');

		});

		Route::prefix('kebijakan-daerah/')->group(function(){
			Route::post('/get-kota', 'FORM\KebijakanCtrl@api_get_table_kota')
			->name('api.kebijakan.daerah.get.table.kota');

			Route::get('/get-perda', 'FORM\KebijakanCtrl@api_get_perda')->name('api.kebijakan.daerah.get.perda');
			Route::post('/store-perda/{id}', 'FORM\KebijakanCtrl@api_store_perda')->name('api.kebijakan.daerah.store.perda');

			Route::get('/get-perkada', 'FORM\KebijakanCtrl@api_get_perkada')->name('api.kebijakan.daerah.get.perkada');
			Route::post('/store-perkada/{id}', 'FORM\KebijakanCtrl@api_store_perkada')->name('api.kebijakan.daerah.store.perkada');



		});

		Route::prefix('permasalahan-daerah/')->group(function(){
			Route::post('/get-kota', 'FORM\PermasalahanCtrl@api_get_table_kota')
			->name('api.permasalahan.daerah.get.table.kota');

			Route::get('/get-masalah-pokok', 'FORM\PermasalahanCtrl@api_get_masalah_pokok')
			->name('api.permasalahan.daerah.get.masalah.pokok');
			
		});

		Route::prefix('kebijakan-pusat-tahunan/')->group(function(){
			Route::get('/get-pn', 'FORM\KebijakanTahunanCtrl@api_get_pn')
			->name('api.kebijakan.tahunan.get.pn');

			Route::get('/get-pp', 'FORM\KebijakanTahunanCtrl@api_get_pp')
			->name('api.kebijakan.tahunan.get.pp');

			Route::get('/get-kp', 'FORM\KebijakanTahunanCtrl@api_get_kp')
			->name('api.kebijakan.tahunan.get.kp');

			Route::get('/get-propn', 'FORM\KebijakanTahunanCtrl@api_get_propn')
			->name('api.kebijakan.tahunan.get.propn');

			
		});

		Route::prefix('kebijakan-pusat-tahunan')->group(function(){
			Route::get('/get-psn', 'FORM\KebijakanTahunanCtrl@api_get_psn_list')
			->name('api.kbt.get.psn');
			Route::get('/get-pp', 'FORM\KebijakanTahunanCtrl@api_get_pp_list')
			->name('api.kbt.get.pp');
			Route::get('/get-kp', 'FORM\KebijakanTahunanCtrl@api_get_kp_list')
			->name('api.kbt.get.kp');

			Route::get('/get-propn', 'FORM\KebijakanTahunanCtrl@api_get_propn_list')
			->name('api.kbt.get.propn');

			Route::get('/get-pn', 'FORM\KebijakanTahunanCtrl@api_get_pn_list')
			->name('api.kbt.get.pn');
		});

		Route::prefix('integrasi')->group(function(){
			Route::get('/get-ind', 'FORM\IntegrasiCtrl@api_get_data_ind')
			->name('api.int.get.ind');

			Route::get('/get-nomen-pro', 'FORM\IntegrasiCtrl@api_get_nomen_pro')
			->name('api.int.get.nomen.pro');

		});

		Route::prefix('glob')->group(function(){
			Route::post('detail-ind-psn/{id?}','FORM\GlobCtrl@detail_ind_psn')->name('glob.det.ind.psn');
			Route::post('detail-psn/{id?}','FORM\GlobCtrl@detail_psn')->name('glob.det.psn');

		});

		Route::prefix('program-kegiatan')->group(function(){
			Route::get('get-daerah','FORM\ProgramKegiatanCtrl@api_get_daerah')->name('api.pk.daerah');

		});


});
