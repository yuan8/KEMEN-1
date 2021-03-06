<?php

use App\MASTER\INDIKATOR;

Route::prefix('integrasi')->middleware('auth:web')->group(function(){

	Route::prefix('master-nomenklatur/')->group(function(){
		Route::get('listing/{pro?}','INT\MASTER90@index')->name('int.nomen.index');
		Route::get('api-web/get/nomen/{pro}/{id?}','INT\MASTER90@api_get_nomen')->name('int.nomen.api_data');

		Route::post('handle/{pro?}/program','INT\MASTER90@store_program')->name('int.nomen.store_program');
		Route::post('handle/{pro?}/kegiatan/{id_program}','INT\MASTER90@store_kegiatan')->name('int.nomen.store_kegiatan');

		Route::post('handle-delete/{pro}/{id_nomen}','INT\MASTER90@delete')->name('int.nomen.delete');
		Route::post('handle/{pro?}/subkegiatan/{id_program}/{id_kegiatan}','INT\MASTER90@store_subkegiatan')->name('int.nomen.store_subkegiatan');
	});


	Route::prefix('kebijakan')->group(function(){
		Route::get('resume','INT\KEBIJAKAN@resume')->name('int.kb.resume');
		Route::prefix('kebijakan-pusat/')->group(function(){
			Route::get('/', 'INT\KEBIJAKAN@index')->name('kebijakan.pusat.index');

			Route::delete('/delete/mandat/{id}', 'INT\KEBIJAKAN@delete_mandat')->name('kebijakan.pusat.delete');

			Route::post('/tambah/sub/{id}/mandat/', 'INT\KEBIJAKAN@store_mandat')->name('kebijakan.pusat.store.mandat');

			Route::put('/update/sub/{id}/mandat/{id_mandat}', 'INT\KEBIJAKAN@update_mandat')->name('kebijakan.pusat.update');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/uu', 'INT\KEBIJAKAN@store_uu')->name('kebijakan.pusat.store.mandat.uu');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/pp', 'INT\KEBIJAKAN@store_pp')->name('kebijakan.pusat.store.mandat.pp');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/perpres', 'INT\KEBIJAKAN@store_perpres')->name('kebijakan.pusat.store.mandat.perpres');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/permen', 'INT\KEBIJAKAN@store_permen')->name('kebijakan.pusat.store.mandat.permen');
			Route::post('/tambah/sub/{id}/mandat/{mandat}/lainnya', 'INT\KEBIJAKAN@store_lainnya')->name('kebijakan.daerah.store.mandat.lainnya');


		});


		Route::prefix('kebijakan-daerah/')->group(function(){


			Route::get('/', 'INT\KEBIJAKAN@index_daerah')->name('kebijakan.daerah.index');


			Route::get('/tambah', 'INT\KEBIJAKAN@create_daerah')->name('kebijakan.daerah.create');

			Route::get('/fokus/{id}', 'INT\KEBIJAKAN@view_daerah')->name('kebijakan.daerah.view.daerah');

			Route::get('desk/{id}', 'INT\KEBIJAKAN@desk_daerah')->name('kebijakan.daerah.desk_daerah');


			Route::post('/tambah/sub/{id}/mandat/{mandat}/perda', 'INT\KEBIJAKAN@store_perda')->name('kebijakan.daerah.store.mandat.perda');

			Route::post('/tambah/sub/{id}/mandat/{mandat}/perkada', 'INT\KEBIJAKAN@store_perkada')->name('kebijakan.daerah.store.mandat.perkada');
			Route::post('/tambah/sub/{id}/mandat/{mandat}/lainnya', 'INT\KEBIJAKAN@store_lainnya')->name('kebijakan.daerah.store.mandat.lainnya');


			Route::put('/tambah/sub/kesesuian/{id}', 'INT\KEBIJAKAN@update_kesesuaian')->name('kebijakan.daerah.store.mandat.update.kesesuian');

			Route::put('/tambah/sub/kesesuian/delete/{id}', 'INT\KEBIJAKAN@delete_kesesuaian')->name('kebijakan.daerah.store.mandat.delete.kesesuian');


		});


	});

	Route::prefix('spm')->group(function(){
		Route::get('/','INT\SPM@index')->name('int.spm.index');
		Route::post('/store','INT\SPM@store')->name('int.spm.store');
		Route::post('/update','INT\SPM@update')->name('int.spm.update');
		Route::post('/indikator/{id}','INT\SPM@indikator')->name('int.spm.indikator');

		Route::post('/store/indikator/{id}','INT\SPM@store_indikator')->name('int.spm.store.indikator');

	});

	Route::prefix('master-indikator')->group(function(){
		Route::get('/','INT\INDIKATOR@index')->name('int.m.indikator');
		Route::get('/create','INT\INDIKATOR@create')->name('int.m.indikator.create');
		Route::post('/store','INT\INDIKATOR@store')->name('int.m.indikator.store');
		Route::get('/edit/{id}','INT\INDIKATOR@form_edit')->name('int.m.indikator.form_edit');
		Route::put('/update/{id}','INT\INDIKATOR@update')->name('int.m.indikator.update');
		Route::get('/delete/{id}','INT\INDIKATOR@form_delete')->name('int.m.indikator.form_delete');
		Route::delete('/delete/{id}','INT\INDIKATOR@delete')->name('int.m.indikator.delete');
		//
		// Route::get('/print',function(){
		// 	// $pdf = App::make('dompdf.wrapper');
		// 	// $pdf->loadHTML('<h1>Test</h1>');
		// 	// return $pdf->stream();
		// 	// return view('integrasi.indikator.print')->with('data',INDIKATOR::get());
		// });


	});

	Route::prefix('indetifikasi-kebijakan-5-tahun')->group(function(){
		Route::get('/','INT\KEBIJAKANPUSAT5TAHUN@index')->name('int.kb5tahun.index');
		Route::get('/resume','INT\KEBIJAKANPUSAT5TAHUN@download')->name('int.kb5tahun.resume');

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
		Route::post('/indikator/store/{id_ak}','INT\KEBIJAKANPUSAT5TAHUN@indikator_store')->name('int.kb5tahun.indikator.store');



	});

	Route::prefix('global')->group(function(){

		Route::get('/listing-satuan','INT\GLOBALCTRL@show_list_select_satuan')->name('api.global.listing-satuan');

		Route::get('/listing-urusan-prio','INT\MASTER90@list_api_urusan_prio')->name('api.global.list_api_urusan_prio');

	});

	Route::prefix('pelaksanaan-urusan')->group(function(){

		Route::get('/','INT\PELAKSANAANURUSAN@index')->name('int.pelurusan.index');

		Route::get('/download','INT\PELAKSANAANURUSAN@download')->name('int.pelurusan.download');


		Route::delete('/delete/{id}','INT\PELAKSANAANURUSAN@delete')->name('int.pelurusan.delete');

		Route::get('/form-delete/{id?}','INT\PELAKSANAANURUSAN@form_delete')->name('int.pelurusan.form_delete');

		Route::put('/update/{id}','INT\PELAKSANAANURUSAN@update')->name('int.pelurusan.update');

		Route::get('/form-update/{id?}','INT\PELAKSANAANURUSAN@form_update')->name('int.pelurusan.form_update');

		Route::get('/form-delete-indikator/{id?}','INT\PELAKSANAANURUSAN@form_delete_indikator')->name('int.pelurusan.form_delete_indikator');

		Route::delete('/delete-indikator/{id?}','INT\PELAKSANAANURUSAN@delete_indikator')->name('int.pelurusan.delete_indikator');



		Route::get('/create/{id?}','INT\PELAKSANAANURUSAN@create')->name('int.pelurusan.create');

		Route::get('/create-kewenangan','INT\PELAKSANAANURUSAN@create_kewenangan')->name('int.pelurusan.create_kewenangan');


		Route::post('/store-kewenangan','INT\PELAKSANAANURUSAN@store_kewenangan')->name('int.pelurusan.store_kewenangan');


		Route::post('/store/{id?}','INT\PELAKSANAANURUSAN@store_indikator')->name('int.pelurusan.store_indikator');

		Route::get('/view/{id}','INT\PELAKSANAANURUSAN@view')->name('int.pelurusan.view');
		Route::post('/update/{id}','INT\PELAKSANAANURUSAN@update')->name('int.pelurusan.update');
		Route::delete('/delete/{id}','INT\PELAKSANAANURUSAN@delete')->name('int.pelurusan.delete');
		Route::get('/delete/{id}','INT\PELAKSANAANURUSAN@show_form_delete')->name('int.pelurusan.show_form_delete');


	});

	Route::prefix('indetifikasi-kebijakan-tahunan')->group(function(){

		Route::get('/','INT\KEBIJAKANPUSAT1TAHUN@index')->name('int.kb1tahun.index');
		Route::get('/download','INT\KEBIJAKANPUSAT1TAHUN@download')->name('int.kb1tahun.download');


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

		Route::post('/store-indikator-rkp/','INT\KEBIJAKANPUSAT1TAHUN@store_indikator_rkp')->name('int.kb1tahun.add.store_indikator');



	});

	Route::prefix('permasalahan')->group(function(){

		// Route::get('/daerah/{kodepemda}','INT\DAERAH\PELAKSANAANURUSAN@detail')->name('int.permasalahan.detail');

		Route::get('/daerah/{kodepemda}/download','INT\DAERAH\PERMASALAHAN@download')->name('int.permasalahan.daerah.download');

		Route::get('/resume-masalah-pokok','INT\PERMASALAHAN@masalah_pokok')->name('int.permasalahan.mpokok');

		Route::get('/resume/{id}','INT\PERMASALAHAN@resume')->name('int.permasalahan.resume');

		Route::post('/daerah/update/masalah-pokok/{kodepemda}/{id}','FORM\PermasalahanCtrl@update_masalah_pokok')->name('int.permasalahan.update_masalah_pokok');
		Route::post('/daerah/update/masalah/{kodepemda}/{id}','FORM\PermasalahanCtrl@update_masalah')->name('int.permasalahan.update_masalah');
		Route::post('/daerah/update/akar-masalah/{kodepemda}/{id}','FORM\PermasalahanCtrl@update_akar_masalah')->name('int.permasalahan.update_akar_masalah');
		Route::post('/daerah/update/data-dukung/{kodepemda}/{id}','FORM\PermasalahanCtrl@update_data_dukung')->name('int.permasalahan.update_data_dukung');

		Route::post('/daerah/delete/masalah-pokok/{kodepemda}/{id}','FORM\PermasalahanCtrl@delete_masalah_pokok')->name('int.permasalahan.delete_masalah_pokok');
		Route::post('/daerah/delete/masalah/{kodepemda}/{id}','FORM\PermasalahanCtrl@delete_masalah')->name('int.permasalahan.delete_masalah');
		Route::post('/daerah/delete/akar-masalah/{kodepemda}/{id}','FORM\PermasalahanCtrl@delete_akar_masalah')->name('int.permasalahan.delete_akar_masalah');
		Route::post('/daerah/delete/data-dukung/{kodepemda}/{id}','FORM\PermasalahanCtrl@delete_data_dukung')->name('int.permasalahan.delete_data_dukung');



	});

	Route::prefix('daerah/program-kegiatan')->group(function(){
		Route::get('/','INT\PROGRAMKEGIATAN@index')->name('int.prokeg.index');
		Route::get('/{kodepemda}','INT\PROGRAMKEGIATAN@detail')->name('int.prokeg.detail');


	});

	Route::prefix('daerah/rekomendasi')->group(function(){

		Route::get('/','INT\DAERAH\REKOMENDASI@index')->name('int.rekomendasi.index');
		Route::post('tagging-nomen/{jenis}/{id_rekom}/{kodepemda?}','INT\DAERAH\REKOMENDASI@tagging_nomen')->name('int.rekomendasi.tagging_nomen');


		Route::get('/detail/{kodepemda}','INT\DAERAH\REKOMENDASI@detail')->name('int.rekomendasi.detail');
		Route::get('/nomen/show-form-program/{kodepemda}/{id_rkpd?}','INT\DAERAH\REKOMENDASI@add_program')->name('int.rekomendasi.add_program');
		Route::post('/nomen/show-form-program/{kodepemda}/{id_rkpd?}','INT\DAERAH\REKOMENDASI@store_program')->name('int.rekomendasi.store_program');
		Route::get('/nomen/add-nested/{kodepemda}/{id?}/{jenis?}','INT\DAERAH\REKOMENDASI@nestedCreate')->name('int.rekomendasi.nestedCreate');
		Route::get('/nomen/add-indikator/{kodepemda}/{id?}/{jenis?}','INT\DAERAH\REKOMENDASI@add_indikator')->name('int.rekomendasi.add_indikator');
		Route::post('/nomen/add-indikator/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@store_indikator')->name('int.rekomendasi.store_indikator');

		Route::get('/nomen/delete-nested/{kodepemda}/{id?}/{jenis?}','INT\DAERAH\REKOMENDASI@delete_form_nested')->name('int.rekomendasi.delete_form_nest');
		Route::delete('/nomen/delete-nested/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@delete_nested')->name('int.rekomendasi.delete_nested');

		Route::get('/nomen/delete-indikator/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@delete_form_indikator')->name('int.rekomendasi.delete_form_indikator');
		Route::delete('/nomen/delete-indikator/{kodepemda}/{id?}','INT\DAERAH\REKOMENDASI@delete_indikator')->name('int.rekomendasi.delete_indikator');


		Route::get('finalisasi/{kodepemda}','INT\DAERAH\REKOMENDASI@form_final')->name('int.rekomendasi.form_final');
		Route::get('export-integrasi/{kodepemda}','INT\DAERAH\REKOMENDASI@view_format_export')->name('int.rekomendasi.export');

		Route::post('finalisasi/{kodepemda}','INT\DAERAH\REKOMENDASI@finalisasi')->name('int.rekomendasi.finalisasi');
	});




});


Route::prefix('pemetaan/')->group(function(){
	Route::get('/{id}','INT\pemetaanarahkebijakan@pn_indikator')->name('form.pemetaan');
	Route::POST('/insert/{id}','INT\pemetaanarahkebijakan@insert_arah_kebijakan')->name('form.pemetaan.insert');
});
