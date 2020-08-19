<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include __dir__.'/webForm.php';


Route::get('rkpd-i',function(){
	RKPDProvider::init(2021);
	RKPDProvider::init(2020);
	dd(\Carbon\Carbon::parse(explode(',', 'Jumat, 01-08-2020 16:50:22')[1]));
	

	return 'done';
});

Route::get('/', 'LoginBarcodeCtrl@landing');

// Route::get('/aaa','FORM\IntegrasiCtrl@testing');
Route::get('/bot-sipd/{tahun}','BOT\MapProgramKegiatanCTRL@UpdateMap');



Route::get('/push','InitCtrl@push');

Route::post('/up-ddd','LoginBarcodeCtrl@updd');

Route::get('/p/{id}',function($id){
	return Hp::q($id);
});

Route::get('/get-sipd/',function(){
	return view('test');
})->name('sipdd');





Route::get('/psn','Builder@psn');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/sinkron-home', 'HomeController@sinkhome')->name('sinkron-home');


Route::get('meta-login-user','LoginBarcodeCtrl@update_meta')->middleware(['auth:web']);
Route::post('meta-login-user','LoginBarcodeCtrl@update_meta_action')->middleware(['auth:web']);


Route::get('init/{id}','InitCtrl@pindah_urusan')->middleware(['auth:web','can:ifAlive'])->name('init.pindah_urusan');
Route::post('init-tahun','InitCtrl@pindah_tahun')->middleware(['auth:web','can:ifAlive'])->name('init.tahun');

Route::get('init-refresing/','InitCtrl@refresh')->middleware(['auth:web','can:ifAlive'])->name('init.refresing');


	
Route::prefix('form')->middleware(['auth:web','can:ifAlive'])->group(function(){

	
	// -----------------------------------------------------------------------------------

		Route::prefix('kebijakan-pusat/')->group(function(){
			Route::get('/', 'FORM\KebijakanCtrl@index')->name('kebijakan.pusat.index');

			Route::delete('/delete/mandat/{id}', 'FORM\KebijakanCtrl@delete_mandat')->name('kebijakan.pusat.delete');

			Route::post('/tambah/sub/{id}/mandat/', 'FORM\KebijakanCtrl@store_mandat')->name('kebijakan.pusat.store.mandat');

			Route::put('/update/sub/{id}/mandat/{id_mandat}', 'FORM\KebijakanCtrl@update_mandat')->name('kebijakan.pusat.update');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/uu', 'FORM\KebijakanCtrl@store_uu')->name('kebijakan.pusat.store.mandat.uu');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/pp', 'FORM\KebijakanCtrl@store_pp')->name('kebijakan.pusat.store.mandat.pp');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/perpres', 'FORM\KebijakanCtrl@store_perpres')->name('kebijakan.pusat.store.mandat.perpres');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/permen', 'FORM\KebijakanCtrl@store_permen')->name('kebijakan.pusat.store.mandat.permen');
			Route::post('/tambah/sub/{id}/mandat/{mandat}/lainnya', 'FORM\KebijakanCtrl@store_lainnya')->name('kebijakan.daerah.store.mandat.lainnya');


		});


		Route::prefix('kebijakan-daerah/')->group(function(){
			Route::get('/', 'FORM\KebijakanCtrl@index_daerah')->name('kebijakan.daerah.index');

			Route::get('/tambah', 'FORM\KebijakanCtrl@create_daerah')->name('kebijakan.daerah.create');
			
			Route::get('/fokus/{id}', 'FORM\KebijakanCtrl@view_daerah')->name('kebijakan.daerah.view.daerah');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/perda', 'FORM\KebijakanCtrl@store_perda')->name('kebijakan.daerah.store.mandat.perda');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/perkada', 'FORM\KebijakanCtrl@store_perkada')->name('kebijakan.daerah.store.mandat.perkada');
			Route::post('/tambah/sub/{id}/mandat/{mandat}/lainnya', 'FORM\KebijakanCtrl@store_lainnya')->name('kebijakan.daerah.store.mandat.lainnya');


			Route::put('/tambah/sub/kesesuian/{id}', 'FORM\KebijakanCtrl@update_kesesuaian')->name('kebijakan.daerah.store.mandat.update.kesesuian');

			Route::put('/tambah/sub/kesesuian/delete/{id}', 'FORM\KebijakanCtrl@delete_kesesuaian')->name('kebijakan.daerah.store.mandat.delete.kesesuian');


		});

		Route::prefix('permasalahan/')->group(function(){
			Route::get('/', 'FORM\PermasalahanCtrl@index')->name('permasalahan.index');

			Route::get('/daerah/fokus/{id}', 'FORM\PermasalahanCtrl@view_daerah')->name('permasalahan.daerah.view.daerah');

			Route::post('/daerah/fokus/{id}/tambah-masalah-pokok', 'FORM\PermasalahanCtrl@store_masalah_pokok')->name('permasalahan.daerah.store.masalah_pokok');

			Route::post('/daerah/fokus/{id}/masalah-pokok/{id_ms_pokok}/tambah-masalah', 'FORM\PermasalahanCtrl@store_masalah')->name('permasalahan.daerah.store.masalah');

			Route::post('/daerah/fokus/{id}/masalah-pokok/{id_ms_pokok}/masalah/{id_masalah}/tambah-akar-masalah', 'FORM\PermasalahanCtrl@store_akar_masalah')->name('permasalahan.daerah.store.akar_masalah');

			Route::post('/daerah/fokus/{id}/masalah-pokok/{id_ms_pokok}/masalah/{id_masalah}/akar-masalah/{id_akar}/tambah-data-masalah', 'FORM\PermasalahanCtrl@store_data_sukung')->name('permasalahan.daerah.store.data_dukung');

			Route::get('/tambah', 'FORM\PermasalahanCtrl@create')->name('permasalahan.create');
		});

		Route::prefix('pelaksanaan-urusan/')->group(function(){
			Route::get('/', 'FORM\PelaksanaanUrusanCtrl@index')->name('pelaksanaan.urusan.index');
			Route::get('/sub-urusan/{id}', 'FORM\PelaksanaanUrusanCtrl@view')->name('pelaksanaan.urusan.view');
			Route::post('/sub-urusan/{id}/tambah-indikator', 'FORM\PelaksanaanUrusanCtrl@store_indikator')->name('pelaksanaan.urusan.store.indikator');

			Route::post('/sub-urusan/{id}/indikator/{id_indikator}/tambah-data', 'FORM\PelaksanaanUrusanCtrl@store_data')->name('pelaksanaan.urusan.store.data');
			
		});

		Route::prefix('kebijakan-pusat-5-tahun/')->group(function(){
			Route::get('/', 'FORM\Kebijakan5Ctrl@index')->name('kebijakan.pusat.5.tahun.index');
			Route::get('/tambah/kodisi-saat-ini', 'FORM\Kebijakan5Ctrl@create')->name('kebijakan.pusat.5.tahun.create');
			Route::post('/tambah/kodisi-saat-ini', 'FORM\Kebijakan5Ctrl@store')->name('kebijakan.pusat.5.tahun.store');


		});

		Route::prefix('kebijakan-pusat-tahunan/')->group(function(){
			Route::get('/', 'FORM\KebijakanTahunanCtrl@index')->name('kebijakan.pusat.tahunan.index');
			Route::post('/tambah/pn', 'FORM\KebijakanTahunanCtrl@store_pn')->name('kebijakan.pusat.tahunan.store.pn');
			Route::post('/tambah/pn/{id}/pp', 'FORM\KebijakanTahunanCtrl@store_pp')->name('kebijakan.pusat.tahunan.store.pp');

			Route::post('/tambah/target/propn/{id}/target', 'FORM\KebijakanTahunanCtrl@store_target_psn')->name('kebijakan.pusat.tahunan.store.target.proyek');

			Route::post('/tambah/kp/{id}/propn', 'FORM\KebijakanTahunanCtrl@store_propn')->name('kebijakan.pusat.tahunan.store.propn');
			Route::post('/tambah/propn/{id}/psn', 'FORM\KebijakanTahunanCtrl@store_psn')->name('kebijakan.pusat.tahunan.store.psn');

			Route::post('/tambah/pn/{id}/pp/{id_pp}/kp', 'FORM\KebijakanTahunanCtrl@store_kp')->name('kebijakan.pusat.tahunan.store.kp');

			Route::get('/major', 'FORM\KebijakanTahunanCtrl@index')->name('kebijakan.pusat.tahunan.major.index');

			Route::get('/proyek', 'FORM\KebijakanTahunanCtrl@proyek')->name('kebijakan.pusat.tahunan.proyek.index');


			Route::get('/proyek/{id}/indikator', 'FORM\KebijakanTahunanCtrl@proyek_indikator')->name('kebijakan.pusat.tahunan.proyek.indikator.index');


			Route::post('/store-proyek', 'FORM\KebijakanTahunanCtrl@store_proyek')->name('kebijakan.pusat.tahunan.proyek.store');

			Route::get('/indikator/{id}', 'FORM\KebijakanTahunanCtrl@view_ind_psn')->name('kebijakan.pusat.tahunan.proyek.view_ind_psn');

			Route::put('/indikator/{id}', 'FORM\KebijakanTahunanCtrl@update_ind_psn')->name('kebijakan.pusat.tahunan.proyek.update_ind_psn');

			Route::put('/indikator-psn-meta/{id}', 'FORM\KebijakanTahunanCtrl@update_ind_psn_meta')->name('kebijakan.pusat.tahunan.proyek.update_ind_psn_meta');
			
		});

		Route::prefix('integrasi/')->group(function(){
		
			Route::get('/', 'FORM\IntegrasiCtrl@index')->name('integrasi.index');
			
			Route::get('/provinsi', 'FORM\IntegrasiCtrl@provinsi')->name('integrasi.provinsi');
			
			Route::get('/kota-kab', 'FORM\IntegrasiKabKotaCtrl@index')->name('integrasi.kota');

			Route::get('/provinsi/{id}', 'FORM\IntegrasiCtrl@detail_provinsi')->name('integrasi.provinsi.detail');

			Route::get('/provinsi/{id}/integrasi/{idn?}', 'FORM\IntegrasiCtrl@target_pro')->name('integrasi.provinsi.int');

			Route::get('/kota-kab/{id}', 'FORM\IntegrasiCtrl@detail_kota')->name('integrasi.kota.detail');

			Route::get('/map/provinsi/{ind?}', 'FORM\IntegrasiCtrl@mapingPro')->name('map.provinsi');

			Route::post('/map/provinsi-store-ind/{id}/{ind}', 'FORM\IntegrasiCtrl@maping_ind_pro_store_target')->name('map.provinsi.ind.store');

			Route::post('/map/provinsi-store/{id}', 'FORM\IntegrasiCtrl@mapingProStore')->name('map.provinsi.store');

			Route::get('/result/provinsi/', 'FORM\IntegrasiCtrl@result_pro')->name('res.pro');
			
			Route::post('/pel-nomen/provinsi/{id}', 'FORM\IntegrasiNomenCTRL@store_pel_nomen_pro')->name('pel.pro');

			Route::get('/provinsi-nomen/', 'FORM\IntegrasiNomenCTRL@index_pro')->name('nomen.pro.index');
			
			Route::get('/provinsi-nomen/{kode_daerah}', 'FORM\IntegrasiNomenCTRL@detail_pro')->name('nomen.pro.detail');


			// Route::get('//{kode_daerah}', 'FORM\IntegrasiNomenCTRL@detail_pro')->name('nomen.pro.detail');

			
		});

		Route::prefix('program-kegiatan/')->group(function(){
		
			Route::get('/', 'FORM\ProgramKegiatanCtrl@index')->name('program.kegiatan.index');
			Route::get('/detail/{id?}','FORM\ProgramKegiatanCtrl@detail')->name('pk.detail');
			Route::get('/detail-pemetaan/{id?}','FORM\ProgramKegiatanCtrl@detail_pemetaan')->name('pk.peta.detail');
			Route::post('/detail-pemetaan/{id?}','FORM\ProgramKegiatanCtrl@store_pemetaan')->name('pk.peta.store');
			Route::get('create-program-kegiatan-template','DokumentCtrl@createTemplate')->name('program.kegiatan.download-template');


			
		});
		Route::prefix('pemetaan_kebijakan/')->group(function(){
			Route::get('/','FORM\pemetaanKebijakanRpjmn@index')->name('pemetaan.kebijakan.index');
			Route::delete('/delete/mandat/{id}', 'FORM\pemetaanKebijakanRpjmn@delete_pemetaan')->name('pemetaan.kebijakan.delete');

		});
Route::prefix('prokeg/')->group(function(){
			Route::get('/', 'PROKEG\prokeg@index_prokeg')->name('prokeg.index');
			Route::get('/detail/{id}/{namapemda}', 'PROKEG\prokeg@detail_prokeg')->name('prokeg.detail');
			Route::get('/tambah/misimodal/{id}', 'PROKEG\prokeg@tambah_misi')->name('prokeg.tambah.misi.modal');
			Route::get('/ubah/misimodal/{id}', 'PROKEG\prokeg@ubah_misi')->name('prokeg.ubah.misimodal');
			Route::post('/ubah/misi/', 'PROKEG\prokeg@update_misi')->name('prokeg.ubah.misi');

			Route::post('/tambah/misi/', 'PROKEG\prokeg@insert_misi')->name('prokeg.tambah.misi');
			
			Route::delete('/hapus/misi/{id}', 'PROKEG\prokeg@hapus_misi')->name('prokeg.hapus.misi');

			Route::put('/ubah/misi/{id}', 'PROKEG\prokeg@ubah_misi')->name('prokeg.ubah.sasaran');

			Route::get('/tambah/sasaranmodal/{id_misi}', 'PROKEG\prokeg@tambah_sasaran')->name('prokeg.tambah.sasaranmodal');
			Route::post('/tambah/sasaran/', 'PROKEG\prokeg@insert_sasaran')->name('prokeg.tambah.sasaran');
			Route::delete('/hapus/sasaran/{id}', 'PROKEG\prokeg@hapus_sasaran')->name('prokeg.hapus.sasaran');

			Route::post('/ubah/sasaran/', 'PROKEG\prokeg@update_sasaran')->name('prokeg.ubah.sasaran');
			Route::get('/ubah/sasaranmodal/{id}', 'PROKEG\prokeg@ubah_sasaran')->name('prokeg.ubah.sasaranmodal');

			Route::post('/tambah/program/', 'PROKEG\prokeg@insert_program')->name('prokeg.tambah.program');
			Route::get('/tambah/programmodal/{id}', 'PROKEG\prokeg@tambah_program')->name('prokeg.tambah.programmodal');
			
			Route::delete('/hapus/program/{id}', 'PROKEG\prokeg@hapus_program')->name('prokeg.hapus.program');
			Route::delete('/hapus/programrkpd/{id}', 'PROKEG\prokeg@hapus_program_rkpd')->name('prokeg.hapus.program_rkpd');

			Route::post('/ubah/program/', 'PROKEG\prokeg@update_program')->name('prokeg.ubah.program');
			Route::get('/ubah/programmodal/{id}', 'PROKEG\prokeg@ubah_program')->name('prokeg.ubah.programmodal');

			Route::get('/pemetaan/program/{id}/{kodepemda}','PROKEG\prokeg@pemetaan_program')->name('prokeg.pemetaan.pilihprogram');
			Route::post('/pemetaan/program/insert','PROKEG\prokeg@insert_pemetaan_program')->name('prokeg.pemetaan.program.insert');
		});



});

include __dir__.'/webBot.php';
include __dir__.'/webDash.php';

