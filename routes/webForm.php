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

	});


});