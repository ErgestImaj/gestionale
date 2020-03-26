<?php
//Superadmin and admin routes

Route::group([
	'middleware' => ['auth','check_user_role:superadmin' ],
	'prefix'=>'exams','as'=>'exams.',
	'namespace'=>'Exams'
],function() {

    Route::resource('lrn-exams','LrnExamsController');

});
