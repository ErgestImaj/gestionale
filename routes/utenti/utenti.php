<?php
//Superadmin and admin routes

use App\Http\Controllers\Utenti;

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'amministrazione','as'=>'utenti.',
	'namespace'=>'Utenti'
],function() {

	Route::get('/utenti/esaminatore/create', 'Utenti@CreateEsaminatore')->name('esaminatore.create');
	Route::get('/utenti/docente/create', 'Utenti@CreateDocente')->name('docente.create');
	Route::get('/utenti/supervisore/create', 'Utenti@CreateSupervisore')->name('supervisore.create');
	Route::get('/utenti/formatori/create', 'Utenti@CreateFormatori')->name('fomatori.create');

	
	Route::get('/utenti/esaminatore', 'Utenti@ViewEsaminatore')->name('esaminatore.view');
	Route::get('/utenti/docente', 'Utenti@ViewDocente')->name('docente.view');
	Route::get('/utenti/supervisore', 'Utenti@ViewSupervisore')->name('supervisore.view');
	Route::get('/utenti/formatori', 'Utenti@ViewFormatori')->name('fomatori.view');

});
