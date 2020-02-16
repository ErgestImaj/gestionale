<?php

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {

	    /*
		 * Partner Routes
		 */

	Route::get('/api/struture/{type}', 'StructureController@getStructure')->name('struture.all');
	Route::get('/struture', 'StructureController@partnerIndex')->name('struture.partner');

});

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner' ],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {
        /*
        * Master Routes
        */
	Route::get('/struture/master', 'StructureController@masterIndex')->name('struture.master');
});

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner|master' ],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {
    /*
     * Affiliati Routes
     */
    Route::view('/struture/{type}/create', 'struture.create')->name('struture.create');
    Route::post('/api/structure/store', 'StructureController@store')->name('struture.store');
	Route::get('/struture/affiliati', 'StructureController@affiliatiIndex')->name('struture.affiliati');

});

Route::group([
    'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner|master' ],
    'prefix'=>'amministrazione','as'=>'location',
],function() {
    /*
     * Location
     */

    Route::get('/api/locations', 'LocationController@getLocations');
});
