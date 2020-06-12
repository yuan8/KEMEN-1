<?php

Route::prefix('bot/simspam')->group(function(){
	Route::get('','CROW\SIMSPAMCTRL@login');
	Route::get('/rekap','CROW\SIMSPAMCTRL@scrap_jaringan_perpipaan');
	Route::get('/rekap-kota','CROW\SIMSPAMCTRL@rekapKota');
	Route::post('/detail-kota/{id?}','CROW\SIMSPAMCTRL@detailKota')->name('bot.simspam.detail.kota');
	Route::post('/download','CROW\SIMSPAMCTRL@download')->name('bot.simspam.download');
});

Route::prefix('bot/rpjmn')->group(function(){
	Route::get('','SISTEM\RPJMN@index');
	Route::get('/build','SISTEM\RPJMN@build');
});



Route::prefix('bot/sipd')->group(function(){
	Route::prefix('data-rkpd')->group(function(){
		// Route::get('/{tahun}/{kodepemda}','CROW\SIPDCTRL@getJson');
			Route::get('show/{tahun}','SISTEM\BOTSIPD@indexing');
			Route::get('store/{tahun}/{kodepemda}','SISTEM\BOTSIPD@getDataJson')->name('bot.sipd.rkpd.store');
	});


	Route::get('rakortek','CROW\RAKORTEK@viewRakotek');
	Route::get('get-data/{tahun}','BOT\SIPDStatusRkpd@getData');
	Route::get('rakortek-only-data/{tahun}/{kodepemda}','BOT\SIPDStatusRkpd@getRakorteX');
	Route::get('get-rakortek/{tahun}/{kodepemda}','CROW\RAKORTEK@getdata')->name('bot.rakortek');
});

Route::prefix('bot')->group(function(){
	Route::prefix('sipd')->group(function(){
		Route::get('data/{tahun}/{kodepemda}','SISTEM\BOTSIPD@getDataJson');
		Route::get('make-data/{tahun}/{kodepemda}','SISTEM\BOTSIPD@makeData');
		Route::get('store-data/{tahun}/{kodepemda}','SISTEM\BOTSIPD@storingFile');
		Route::get('change-data','SISTEM\BOTSIPD@change');
	});

	Route::get('simspam-perpipaan','CROW\SIMSPAMCTRL@storeKodeDaerah');
	Route::get('simspam-login','CROW\SIMSPAMCTRL@login_form');
	Route::get('data-rpjmd/{tahun}/{kodepemda}','CROW\SIPDCTRL@getData')->name('get_sipd');
});
