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
	Route::get('/utenti/studenti/create', 'Utenti@CreateStudenti')->name('studenti.create');
	Route::get('/utenti/tutor/create', 'Utenti@CreateTutor')->name('tutor.create');
	Route::get('/utenti/inspector/create', 'Utenti@CreateInspector')->name('inspector.create');
	
	Route::get('/utenti/esaminatore', 'Utenti@ViewEsaminatore')->name('esaminatore.view');
	Route::get('/utenti/docente', 'Utenti@ViewDocente')->name('docente.view');
	Route::get('/utenti/supervisore', 'Utenti@ViewSupervisore')->name('supervisore.view');
	Route::get('/utenti/formatori', 'Utenti@ViewFormatori')->name('fomatori.view');
	Route::get('/utenti/studenti', 'Utenti@ViewStudenti')->name('studenti.view');
	Route::get('/utenti/tutor', 'Utenti@ViewTutori')->name('tutor.view');
	Route::get('/utenti/inspector', 'Utenti@ViewInspectori')->name('inspector.view');
});
