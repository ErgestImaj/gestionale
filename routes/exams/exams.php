<?php
//Exams routes

Route::group([
	'middleware' => ['auth','check_user_role:superadmin' ],
	'prefix'=>'exams','as'=>'exams.',
	'namespace'=>'Exams'
],function() {

    Route::resource('api/lrn-exams','LrnExamsController');
    Route::resource('mf-exams','MediaformExamsController');

		Route::view('/lrn-exams', 'exams.index')->name('lrn.index');
});
