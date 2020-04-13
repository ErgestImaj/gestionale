<?php

use App\Http\Controllers\Utenti;

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'utenti','as'=>'utenti.',
	'namespace'=>'Utenti'
],function() {

	  /*
		 * Export
		 */
	Route::get('/utenti/export/{type}/{from_date?}/{to_date?}', 'UtentiController@export')->name('export');

	Route::get('/{type}/create', 'UtentiController@createUtente')->name('utenti.create');
	Route::get('/admins', 'UtentiController@viewAdmins')->name('admins.view');
	Route::get('/segreteria', 'UtentiController@viewSegreteria')->name('segreteria.view');
	Route::get('/esaminatore', 'UtentiController@viewEsaminatore')->name('esaminatore.view');
	Route::get('/docente', 'UtentiController@viewDocente')->name('docente.view');
	Route::get('/supervisore', 'UtentiController@viewSupervisore')->name('supervisore.view');
	Route::get('/formatori', 'UtentiController@viewFormatori')->name('fomatori.view');
	Route::get('/studenti', 'UtentiController@viewStudenti')->name('studenti.view');
	Route::get('/tutor', 'UtentiController@viewTutori')->name('tutor.view');
	Route::get('/inspector', 'UtentiController@viewInspectori')->name('inspector.view');
	Route::get('/invigilatori', 'UtentiController@viewInvigilatori')->name('invigilatori.view');
	Route::get('/area-lrn', 'UtentiController@viewAreaLrn')->name('lrn.view');
	Route::get('/area-dile', 'UtentiController@viewAreaDile')->name('dile.view');
	Route::post('/storebasicuser','UtentiController@storeBasicUser')->name('utenti.store');
	Route::get('/{user}/edit','UtentiController@edit')->name('edit');
	Route::delete('/delete/{user?}','UtentiController@destroy')->name('admins.destroy');
	Route::get('/{user}/show','UtentiController@show')->name('show');

		Route::group( ['prefix' => 'api'], function ()
		{
			Route::get('/{user}/edit','UtentiController@editUser')->name('edit-user');
			Route::get('/{user}/editadvanceduser','UtentiController@editAdancedUtenti')->name('edit-advanced-user');
			Route::post('/{user}/update','UtentiController@update')->name('update');
			Route::post('/{user}/updateadvanceduser','UtentiController@updateAdvancedUser')->name('update-advanced-user');
			Route::get('/get-user/{type}', 'UtentiController@getUserType')->name('utenti.type');
			Route::post('/store','UtentiController@store');
			Route::get('/ispettori','UtentiController@getInspettori');
		});
});
