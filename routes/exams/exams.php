<?php
//Exams routes

Route::group([
	'middleware' => ['auth','check_user_role:superadmin' ],
	'prefix'=>'exams','as'=>'exams.',
	'namespace'=>'Exams'
],function() {
	/*
	 * Export
	 */
	  Route::get('/exams-lrn/export/{type}/{from_date?}/{to_date?}', 'LrnExamsController@export')->name('lrn.export');

    Route::get('/api/mf-exams/{type}','MediaformExamsController@index');
		Route::view('/mf-exams/create', 'exams.createMediaForm')->name('mediaform.create');
		Route::view('/mf-exams', 'exams.indexMF')->name('mediaform.list');

		Route::get('/lrn-exams/{type}', 'LrnExamsController@index')->name('lrn.index');
		Route::get('/lrn-exams/{type}/create', 'LrnExamsController@create')->name('lrn.create');

	Route::group( ['prefix' => 'api'], function ()
	{
		Route::get('/lrn-exams','LrnExamsController@filter')->name('lrn.filter');
		Route::post('/lrn-exams/store','LrnExamsController@store')->name('lrn.store');

		Route::get('/getCourseModulesAndStudents','MediaformExamsController@getCourseModulesAndStudents');
	});
});
