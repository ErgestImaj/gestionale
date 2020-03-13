<?php

use App\Http\Controllers\Utenti;

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'amministrazione','as'=>'utenti.',
	'namespace'=>'Utenti'
],function() {

	Route::get('/utenti/esaminatore/create', 'UtentiController@createEsaminatore')->name('esaminatore.create');
	Route::get('/utenti/docente/create', 'UtentiController@createDocente')->name('docente.create');
	Route::get('/utenti/supervisore/create', 'UtentiController@createSupervisore')->name('supervisore.create');
	Route::get('/utenti/formatori/create', 'UtentiController@createFormatori')->name('fomatori.create');
	Route::get('/utenti/studenti/create', 'UtentiController@createStudenti')->name('studenti.create');
	Route::get('/utenti/tutor/create', 'UtentiController@createTutor')->name('tutor.create');
	Route::get('/utenti/inspector/create', 'UtentiController@createInspector')->name('inspector.create');

	Route::get('/utenti/esaminatore', 'UtentiController@viewEsaminatore')->name('esaminatore.view');
	Route::get('/utenti/docente', 'UtentiController@viewDocente')->name('docente.view');
	Route::get('/utenti/supervisore', 'UtentiController@viewSupervisore')->name('supervisore.view');
	Route::get('/utenti/formatori', 'UtentiController@viewFormatori')->name('fomatori.view');
	Route::get('/utenti/studenti', 'UtentiController@viewStudenti')->name('studenti.view');
	Route::get('/utenti/tutor', 'UtentiController@viewTutori')->name('tutor.view');
	Route::get('/utenti/inspector', 'UtentiController@viewInspectori')->name('inspector.view');
});
