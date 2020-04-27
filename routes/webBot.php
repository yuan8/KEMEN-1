<?php

Route::prefix('bot/simspam')->group(function(){
	Route::get('','CROW\SIMSPAMCTRL@login');

	Route::get('/rekap','CROW\SIMSPAMCTRL@scrap_jaringan_perpipaan');
	Route::get('/rekap-kota','CROW\SIMSPAMCTRL@rekapKota');
	Route::post('/detail-kota/{id?}','CROW\SIMSPAMCTRL@detailKota')->name('bot.simspam.detail.kota');


	Route::post('/download','CROW\SIMSPAMCTRL@download')->name('bot.simspam.download');
});


Route::prefix('bot/sipd')->group(function(){
	Route::get('rakortek','CROW\RAKORTEK@viewRakotek');
	Route::get('get-data/{tahun}','BOT\SIPDStatusRkpd@getData');
	Route::get('rakortek-only-data/{tahun}/{kodepemda}','BOT\SIPDStatusRkpd@getRakorteX');
	Route::get('get-rakortek/{tahun}/{kodepemda}','CROW\RAKORTEK@getdata')->name('bot.rakortek');
});

Route::prefix('bot')->group(function(){;
	Route::get('simspam-perpipaan','CROW\SIMSPAMCTRL@storeKodeDaerah');
	Route::get('simspam-login','CROW\SIMSPAMCTRL@login_form');
	Route::get('data-rpjmd/{tahun}/{kodepemda}','CROW\SIPDCTRL@getData')->name('get_sipd');
});
