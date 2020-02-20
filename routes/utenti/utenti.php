<?php
//Superadmin and admin routes

use App\Http\Controllers\Utenti;

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'amministrazione','as'=>'utenti.',
	'namespace'=>'Utenti'
],function() {

	Route::get('/utenti/esaminatore/create', 'UtentiController@CreateEsaminatore')->name('esaminatore.create');
	Route::get('/utenti/docente/create', 'UtentiController@CreateDocente')->name('docente.create');
	Route::get('/utenti/supervisore/create', 'UtentiController@CreateSupervisore')->name('supervisore.create');
	Route::get('/utenti/formatori/create', 'UtentiController@CreateFormatori')->name('fomatori.create');
	Route::get('/utenti/studenti/create', 'UtentiController@CreateStudenti')->name('studenti.create');
	Route::get('/utenti/tutor/create', 'UtentiController@CreateTutor')->name('tutor.create');
	Route::get('/utenti/inspector/create', 'UtentiController@CreateInspector')->name('inspector.create');

	Route::get('/utenti/esaminatore', 'UtentiController@ViewEsaminatore')->name('esaminatore.view');
	Route::get('/utenti/docente', 'UtentiController@ViewDocente')->name('docente.view');
	Route::get('/utenti/supervisore', 'UtentiController@ViewSupervisore')->name('supervisore.view');
	Route::get('/utenti/formatori', 'UtentiController@ViewFormatori')->name('fomatori.view');
	Route::get('/utenti/studenti', 'UtentiController@ViewStudenti')->name('studenti.view');
	Route::get('/utenti/tutor', 'UtentiController@ViewTutori')->name('tutor.view');
	Route::get('/utenti/inspector', 'UtentiController@ViewInspectori')->name('inspector.view');
});
