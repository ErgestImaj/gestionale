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
	Route::get('/struture/{structure}/sconto/', 'StructureController@sconto')->name('struture.sconto');
	Route::get('/struture/{structure}/show/', 'StructureController@show')->name('struture.show');
	Route::get('/struture/{structure}/view/', 'StructureController@details')->name('struture.details');
	Route::post('/api/{structure}/sconto/store','DiscountController@store')->name('struture.sconto.store');
	Route::get('/api/{structure}/sconto/', 'DiscountController@index')->name('struture.sconto.index');
	Route::delete('/api/sconto/{discount}/', 'DiscountController@destroy')->name('struture.sconto.destroy');
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
	Route::get('/api/struture/{type}/parent', 'StructureController@getStructureParent')->name('struture.parent');
});

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner|master','can:create,App\Models\Structure'],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {
    /*
     * Affiliati Routes
     */
    Route::view('/struture/{type}/create', 'struture.create')->name('struture.create');
    Route::post('/api/structure/{type}/store', 'StructureController@store')->name('struture.store');
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
