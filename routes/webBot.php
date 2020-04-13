<?php

Route::prefix('bot/simspam')->group(function(){
	Route::get('','CROW\SIMSPAMCTRL@login');

	Route::get('/rekap','CROW\SIMSPAMCTRL@scrap_jaringan_perpipaan');
	Route::get('/rekap-kota','CROW\SIMSPAMCTRL@rekapKota');
	Route::post('/detail-kota/{id?}','CROW\SIMSPAMCTRL@detailKota')->name('bot.simspam.detail.kota');


	Route::post('/download','CROW\SIMSPAMCTRL@download')->name('bot.simspam.download');
});


Route::prefix('bot/sipd')->group(function(){
	Route::get('get-data/{tahun}','BOT\SIPDStatusRkpd@getData');

});
