<?php
Route::middleware('auth:web')->group(function(){
	Route::get('program-kegiatan-urusan','FRONT\ProgramKegiatan@index');
	Route::get('program-kegiatan-daerah','FRONT\ProgramKegiatan@daerah');
	Route::get('program-kegiatan/daerah','FRONT\ProgramKegiatan@per_provinsi');
	Route::get('program-kegiatan-per-kota/{id}','FRONT\ProgramKegiatan@per_kota');
	Route::get('program-kegiatan-per-daerah-urusan/{id}','FRONT\ProgramKegiatan@dearah_per_urusan');
	Route::get('program-kegiatan-rkpd','FRONT\ProgramKegiatan@dash_daerah')->name('pp.index');
	Route::get('program-kegiatan-rkpd/urusan','FRONT\ProgramKegiatan@dash_urusan')->name('pp.urusan');

	Route::get('program-kegiatan-per-daerah-sub-urusan/{id}/{id_urusan}','FRONT\ProgramKegiatan@dearah_per_sub_urusan');
	Route::get('program-kegiatan-per-daerah-sub-urusan-per-program/{id}/{id_sub_urusan}','FRONT\ProgramKegiatan@dearah_per_program');
	Route::get('program-kegiatan-detail-program/{id}','FRONT\ProgramKegiatan@detail_program')->name('pr.program.det');
	Route::get('program-kegiatan-data/{id}','FRONT\ProgramKegiatan@data')->name('pr.data');

	Route::get('program-kegiatan/urusan','FRONT\ProgramKegiatan@per_urusan');
	Route::get('program-kegiatan-per-sub-urusan/{id}','FRONT\ProgramKegiatan@per_sub_urusan');
	Route::get('program-kegiatan-per-program/{id}','FRONT\ProgramKegiatan@per_program');

	Route::post('catatan/{id}','FRONT\ProgramKegiatan@storeCatatan')->name('front.store.catatan');



	Route::prefix('rakortek')->group(function(){
		Route::get('/','FRONT\Rakortek@index')->name('front.r.index');
		Route::get('/per-urusan','FRONT\Rakortek@iku_perurusan')->name('front.r.iku_perurusan');

		Route::get('/sebaran-indikator-iku/{tahun}/{kodeiku}','FRONT\Rakortek@sebaran_indikator_iku_daerah')->name('front.r.sebaran_indikator_iku_daerah');



		Route::prefix('kawasan-perbatasan-negara'.Hp::DSS_TOKEN())->group(function(){
		Route::get('/','FRONT\Rakortek@kawasan_perbatasan')->name('front.r.perba.index');
			
		});


		Route::prefix('api/'.Hp::DSS_TOKEN())->group(function(){
				Route::post('/iku/bidang/{kode_daerah?}','FRONT\Rakortek@data_iku_ids')->name('front.r.iku.daerah');

				Route::post('/iku/bidang/{kode_daerah?}/{kode_ind?}','FRONT\Rakortek@iku_catatan')->name('front.r.iku.catatan');
				Route::post('/iku/bidang-pendukung/{kode_daerah?}/{kode_ind?}','FRONT\Rakortek@data_iku_pendukung')->name('front.r.iku.pendukung');

			
		});

			





	});




});
