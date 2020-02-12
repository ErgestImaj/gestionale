<?php
//Superadmin and admin routes

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'amministrazione','as'=>'utenti.',
	'namespace'=>'Utenti'
],function() {

	Route::view('/utenti/create', 'utenti.create')->name('struture.create');

});
