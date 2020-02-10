<?php
/**
 *ketu do vendosesh routes per strukturat master dhe afiliati
 */
//Superadmin and admin routes

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {

	/*
		 * partner ketu
		 */
	Route::view('/struture/create', 'struture.create')->name('struture.create');
	Route::get('/api/struture/all', 'StructureController@all')->name('struture.all');
	Route::get('/struture', 'StructureController@partnerIndex')->name('struture.partner');

});

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner' ],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {

	//cdo gje per masterin ketu
	Route::get('/struture/master', 'StructureController@masterIndex')->name('struture.master');
});

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner|master' ],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {

	//cdo gje peraffiliati ketu
	Route::get('/struture/affiliati', 'StructureController@affiliatiIndex')->name('struture.affiliati');
});
