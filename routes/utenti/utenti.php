<?php

use App\Http\Controllers\Utenti;

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'utenti','as'=>'utenti.',
	'namespace'=>'Utenti'
],function() {

	Route::get('/esaminatore/create', 'UtentiController@createEsaminatore')->name('esaminatore.create');
	Route::get('/docente/create', 'UtentiController@createDocente')->name('docente.create');
	Route::get('/supervisore/create', 'UtentiController@createSupervisore')->name('supervisore.create');
	Route::get('/formatori/create', 'UtentiController@createFormatori')->name('fomatori.create');
	Route::get('/studenti/create', 'UtentiController@createStudenti')->name('studenti.create');
	Route::get('/tutor/create', 'UtentiController@createTutor')->name('tutor.create');
	Route::get('/inspector/create', 'UtentiController@createInspector')->name('inspector.create');

	Route::get('/esaminatore', 'UtentiController@viewEsaminatore')->name('esaminatore.view');
	Route::get('/docente', 'UtentiController@viewDocente')->name('docente.view');
	Route::get('/supervisore', 'UtentiController@viewSupervisore')->name('supervisore.view');
	Route::get('/formatori', 'UtentiController@viewFormatori')->name('fomatori.view');
	Route::get('/studenti', 'UtentiController@viewStudenti')->name('studenti.view');
	Route::get('/tutor', 'UtentiController@viewTutori')->name('tutor.view');
	Route::get('/inspector', 'UtentiController@viewInspectori')->name('inspector.view');

	Route::get('/api/get-user/{type}', 'UtentiController@getUserType')->name('utenti.type');
});
