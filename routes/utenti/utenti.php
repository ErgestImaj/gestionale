<?php

use App\Http\Controllers\Utenti;

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'utenti','as'=>'utenti.',
	'namespace'=>'Utenti'
],function() {

	Route::get('/{type}/create', 'UtentiController@createUtente')->name('utenti.create');

	// Admin
	Route::get('/admins','UtentiController@viewAdmins')->name('admins.index');
	Route::get('/segreteria','UtentiController@viewSegreteria')->name('segreteria.index');
	Route::get('/admins/index','AdminController@index');
	Route::post('/admins/store','AdminController@store')->name('admins.store');
	Route::patch('/admin/{user}','AdminController@update')->name('admins.update');
	Route::delete('/admin/delete/{user?}','AdminController@destroy')->name('admins.destroy');
	Route::get('/esaminatore', 'UtentiController@viewEsaminatore')->name('esaminatore.view');
	Route::get('/docente', 'UtentiController@viewDocente')->name('docente.view');
	Route::get('/supervisore', 'UtentiController@viewSupervisore')->name('supervisore.view');
	Route::get('/formatori', 'UtentiController@viewFormatori')->name('fomatori.view');
	Route::get('/studenti', 'UtentiController@viewStudenti')->name('studenti.view');
	Route::get('/tutor', 'UtentiController@viewTutori')->name('tutor.view');
	Route::get('/inspector', 'UtentiController@viewInspectori')->name('inspector.view');

	Route::get('/api/get-user/{type}', 'UtentiController@getUserType')->name('utenti.type');
});
