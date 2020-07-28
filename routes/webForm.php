<?php


Route::prefix('integrasi')->middleware('auth:web')->group(function(){

	Route::prefix('indetifikasi-kebijakan-5-tahun')->group(function(){
		Route::get('/','INT\KEBIJAKANPUSAT5TAHUN@index')->name('int.kb5tahun.index');

		Route::post('/kondisi/store','INT\KEBIJAKANPUSAT5TAHUN@kondisi_store')->name('int.kb5tahun.store');
		Route::get('/kondisi/show-from-create','INT\KEBIJAKANPUSAT5TAHUN@kondisi_create')->name('int.kb5tahun.kondisi.create');
		Route::get('/kondisi/show-from-update/{id}','INT\KEBIJAKANPUSAT5TAHUN@kondisi_view')->name('int.kb5tahun.kondisi.view');
		Route::put('/kondisi/show-from-update/{id}','INT\KEBIJAKANPUSAT5TAHUN@kondisi_update')->name('int.kb5tahun.kondisi.update');
		Route::get('/kondisi/show-from-delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@kondisi_form_delete')->name('int.kb5tahun.kondisi.form.delete');
		Route::delete('/kondisi/delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@kondisi_delete')->name('int.kb5tahun.kondisi.delete');


		Route::get('/isu/show-from-create/{id}','INT\KEBIJAKANPUSAT5TAHUN@isu_create')->name('int.kb5tahun.isu.create');
		Route::get('/isu/show-from-update/{id}','INT\KEBIJAKANPUSAT5TAHUN@isu_view')->name('int.kb5tahun.isu.view');
		Route::get('/isu/show-from-delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@isu_form_delete')->name('int.kb5tahun.isu.form.delete');
		Route::delete('/isu/delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@isu_delete')->name('int.kb5tahun.isu.delete');
		Route::put('/isu/update/{id}','INT\KEBIJAKANPUSAT5TAHUN@isu_update')->name('int.kb5tahun.isu.update');
		Route::post('/isu/store/{id}','INT\KEBIJAKANPUSAT5TAHUN@isu_store')->name('int.kb5tahun.isu.store');



		Route::get('/sasaran/show-from-create/{id}','INT\KEBIJAKANPUSAT5TAHUN@sasaran_create')->name('int.kb5tahun.sasaran.create');
		Route::get('/sasaran/show-from-update/{id}','INT\KEBIJAKANPUSAT5TAHUN@sasaran_view')->name('int.kb5tahun.sasaran.view');
		Route::get('/sasaran/show-from-delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@sasaran_form_delete')->name('int.kb5tahun.sasaran.form.delete');
		Route::delete('/sasaran/delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@sasaran_delete')->name('int.kb5tahun.sasaran.delete');
		Route::put('/sasaran/update/{id}','INT\KEBIJAKANPUSAT5TAHUN@sasaran_update')->name('int.kb5tahun.sasaran.update');
		Route::post('/sasaran/store/{id}','INT\KEBIJAKANPUSAT5TAHUN@sasaran_store')->name('int.kb5tahun.sasaran.store');



		Route::get('/arah-kebijakan/show-from-create/{id}','INT\KEBIJAKANPUSAT5TAHUN@ak_create')->name('int.kb5tahun.ak.create');
		Route::get('/arah-kebijakan/show-from-update/{id}','INT\KEBIJAKANPUSAT5TAHUN@ak_view')->name('int.kb5tahun.ak.view');
		Route::put('/arah-kebijakan/update/{id}','INT\KEBIJAKANPUSAT5TAHUN@ak_update')->name('int.kb5tahun.ak.update');
		Route::get('/arah-kebijakan/show-from-delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@ak_form_delete')->name('int.kb5tahun.ak.form.delete');
		Route::delete('/arah-kebijakan/delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@ak_delete')->name('int.kb5tahun.ak.delete');
		Route::post('/arah-kebijakan/store/{id}','INT\KEBIJAKANPUSAT5TAHUN@ak_store')->name('int.kb5tahun.ak.store');


		Route::get('/indikator/show-from-create/{id}','INT\KEBIJAKANPUSAT5TAHUN@indikator_create')->name('int.kb5tahun.indikator.create');
		Route::get('/indikator/detail/{id}','INT\KEBIJAKANPUSAT5TAHUN@indikator_detail')->name('int.kb5tahun.indikator.detail');


		Route::get('/indikator/show-from-update/{id}','INT\KEBIJAKANPUSAT5TAHUN@indikator_view')->name('int.kb5tahun.indikator.view');
		Route::get('/indikator/show-from-delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@indikator_form_delete')->name('int.kb5tahun.indikator.form.delete');
		Route::put('/indikator/update/{id}','INT\KEBIJAKANPUSAT5TAHUN@indikator_update')->name('int.kb5tahun.indikator.update');
		Route::delete('/indikator/delete/{id}','INT\KEBIJAKANPUSAT5TAHUN@indikator_delete')->name('int.kb5tahun.indikator.delete');
		Route::post('/indikator/store/{id_ak}/{id_kondisi}','INT\KEBIJAKANPUSAT5TAHUN@indikator_store')->name('int.kb5tahun.indikator.store');



	});

	Route::prefix('pelaksanaan-urusan')->group(function(){
		Route::get('/','INT\PELAKSANAANURUSAN@index')->name('int.pelurusan.index');		

	});

	Route::prefix('indetifikasi-kebijakan-tahunan')->group(function(){
		Route::get('/','INT\KEBIJAKANPUSAT1TAHUN@index')->name('int.kb1tahun.index');
		
		Route::get('/show-form-pn','INT\KEBIJAKANPUSAT1TAHUN@pn_create')->name('int.kb1tahun.pn_create');	
		
		Route::post('/store-pn','INT\KEBIJAKANPUSAT1TAHUN@pn_store')->name('int.kb1tahun.pn_store');
		
		Route::get('/show-form-update/{id}','INT\KEBIJAKANPUSAT1TAHUN@pn_view')->name('int.kb1tahun.pn_view');

		Route::get('/show-form-nested/{id}','INT\KEBIJAKANPUSAT1TAHUN@nested_create')->name('int.kb1tahun.nested_create');

		Route::post('/show-form-nested/{id}/{jenis}','INT\KEBIJAKANPUSAT1TAHUN@nested_store')->name('int.kb1tahun.nested_store');

		Route::get('/show-indikator-pn/{id}','INT\KEBIJAKANPUSAT1TAHUN@pn_indikator')->name('int.kb1tahun.pn_indikator');


		Route::get('/delete-indikator/{id}','INT\KEBIJAKANPUSAT1TAHUN@indikator_form_delete')->name('int.kb1tahun.indikator_form_delete');

		Route::delete('/delete-indikator/{id}','INT\KEBIJAKANPUSAT1TAHUN@indikator_delete')->name('int.kb1tahun.indikator_delete');


		Route::post('/store-indikator/{id}','INT\KEBIJAKANPUSAT1TAHUN@store_indikator')->name('int.kb1tahun.store_indikator');

		Route::get('/show-from-delete-pn/{id}','INT\KEBIJAKANPUSAT1TAHUN@pn_form_delete')->name('int.kb1tahun.pn_form_delete');

		Route::put('/show-form-update/{id}','INT\KEBIJAKANPUSAT1TAHUN@pn_update')->name('int.kb1tahun.pn_update');	
		
		Route::delete('/pn/delete/{id}','INT\KEBIJAKANPUSAT1TAHUN@pn_delete')->name('int.kb1tahun.pn_delete');		



	});

	Route::prefix('permasalahan')->group(function(){
		Route::get('/daerah/{kodepemda}','INT\DAERAH\PELAKSANAANURUSAN@detail')->name('int.permasalahan.detail');
		Route::post('/daerah/update/masalah-pokok/{kodepemda}/{id}','Form\PermasalahanCtrl@update_masalah_pokok')->name('int.permasalahan.update_masalah_pokok');
		Route::post('/daerah/update/masalah/{kodepemda}/{id}','Form\PermasalahanCtrl@update_masalah')->name('int.permasalahan.update_masalah');
		Route::post('/daerah/update/akar-masalah/{kodepemda}/{id}','Form\PermasalahanCtrl@update_akar_masalah')->name('int.permasalahan.update_akar_masalah');
		Route::post('/daerah/update/data-dukung/{kodepemda}/{id}','Form\PermasalahanCtrl@update_data_dukung')->name('int.permasalahan.update_data_dukung');

		Route::post('/daerah/delete/masalah-pokok/{kodepemda}/{id}','Form\PermasalahanCtrl@delete_masalah_pokok')->name('int.permasalahan.delete_masalah_pokok');
		Route::post('/daerah/delete/masalah/{kodepemda}/{id}','Form\PermasalahanCtrl@delete_masalah')->name('int.permasalahan.delete_masalah');
		Route::post('/daerah/delete/akar-masalah/{kodepemda}/{id}','Form\PermasalahanCtrl@delete_akar_masalah')->name('int.permasalahan.delete_akar_masalah');
		Route::post('/daerah/delete/data-dukung/{kodepemda}/{id}','Form\PermasalahanCtrl@delete_data_dukung')->name('int.permasalahan.delete_data_dukung');



	});

	Route::prefix('daerah/program-kegiatan')->group(function(){
		Route::get('/','INT\PROGRAMKEGIATAN@index')->name('int.prokeg.index');
		Route::get('/{kodepemda}','INT\PROGRAMKEGIATAN@detail')->name('int.prokeg.detail');

	});
	
	Route::prefix('daerah/rekomendasi')->group(function(){
		Route::get('/','INT\DAERAH\REKOMENDASI@index')->name('int.rekomendasi.index');
		Route::get('/detail/{kodepemda}','INT\DAERAH\REKOMENDASI@detail')->name('int.rekomendasi.detail');
		Route::get('/nomen/show-form-program/{kodepemda}','INT\DAERAH\REKOMENDASI@add_program')->name('int.rekomendasi.add_program');
		Route::post('/nomen/show-form-program/{kodepemda}','INT\DAERAH\REKOMENDASI@store_program')->name('int.rekomendasi.store_program');
		Route::get('/nomen/add-nested/{kodepemda}/{id?}/{jenis?}','INT\DAERAH\REKOMENDASI@nestedCreate')->name('int.rekomendasi.nestedCreate');
		Route::get('/nomen/add-indikator/{kodepemda}/{id?}/{jenis?}','INT\DAERAH\REKOMENDASI@add_indikator')->name('int.rekomendasi.add_indikator');
		Route::post('/nomen/add-indikator/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@store_indikator')->name('int.rekomendasi.store_indikator');

		Route::get('/nomen/delete-nested/{kodepemda}/{id?}/{jenis?}','INT\DAERAH\REKOMENDASI@delete_form_nested')->name('int.rekomendasi.delete_form_nest');
		Route::delete('/nomen/delete-nested/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@delete_nested')->name('int.rekomendasi.delete_nested');

		Route::get('/nomen/delete-indikator/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@delete_form_indikator')->name('int.rekomendasi.delete_form_indikator');
		Route::delete('/nomen/delete-indikator/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@delete_indikator')->name('int.rekomendasi.delete_indikator');


	});


});