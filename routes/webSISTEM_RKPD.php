<?php


Route::prefix('sso')->group(function(){
	Route::get('/', 'SISTEM_SSO\SSO@index');
	Route::post('/', 'SISTEM_SSO\SSO@index');
});

Route::prefix('sistem-rkpd')->group(function(){
	Route::get('/','SISTEM_RKPD\RKPD\RKPD@index');
});