<?php

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {

	    /*
		 * Partner Routes
		 */

	Route::get('/struture', 'StructureController@partnerIndex')->name('struture.partner');
	Route::get('/struture/{structure}/sconto/', 'StructureController@sconto')->name('struture.sconto');
	Route::get('/struture/{structure}/show/', 'StructureController@show')->name('struture.show');
	Route::get('/struture/{structure}/view/', 'StructureController@details')->name('struture.details');
	Route::view('/struture/{structure}/edit/', 'struture.edit')->name('struture.edit');
	Route::delete('/structure/{structure}','StructureController@destroy')->name('struture.destroy');
	Route::patch('/structure/{structure}/status','StructureController@updateStatus')->name('struture.status');


		Route::group( ['prefix' => 'api'], function ()
		{
			Route::get('/struture/{type}', 'StructureController@getStructure')->name('struture.all');
			Route::get('/struture/{structure}/edit/', 'StructureController@edit');
			Route::post('/{structure}/sconto/store','DiscountController@store')->name('struture.sconto.store');
			Route::get('/{structure}/sconto/', 'DiscountController@index')->name('struture.sconto.index');
			Route::delete('/sconto/{discount}/', 'DiscountController@destroy')->name('struture.sconto.destroy');
			Route::post('/structure/{structure}/update', 'StructureController@update')->name('struture.update');
			Route::patch('/{structure}/hirearcy/','StructureController@updateHierarchy')->name('struture.hierarchy');
			Route::get('/{structure}/coursetransactions','CourseTransactionController@index');
			Route::post('/{structure}/transaction/store','CourseTransactionController@store');
			Route::delete('/transaction/{transaction}/destroy','CourseTransactionController@destroy');
		});
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

		Route::group( ['prefix' => 'api'], function ()
		{
			Route::get('/struture/{type}/parent', 'StructureController@getStructureParent')->name('struture.parent');
		});
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
	  Route::get('/struture/affiliati', 'StructureController@affiliatiIndex')->name('struture.affiliati');


			Route::group( ['prefix' => 'api'], function ()
			{
				Route::get('/active-structures', 'StructureController@listActiveStructures');
				Route::post('/structure/{type}/store', 'StructureController@store')->name('struture.store');
			});
});

Route::group([
	'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner|master|affiliati'],
	'prefix'=>'amministrazione','as'=>'structure.',
	'namespace'=>'Structures'
],function() {

	/*
	* Users
	*/
	Route::group( ['prefix' => 'api'], function ()
	{
		Route::get('/structure/get-examiners/{type}', 'StructureController@getExaminers');
		Route::get('/structure/get-invigilators/{type}', 'StructureController@getInvigilators');
		Route::get('/get-structure-available-course/{type}','StructureController@getAvailableCourses');

	});

});


Route::group([
    'middleware' => ['auth','check_user_role:superadmin|amministrazione|partner|master|affiliati' ],
    'prefix'=>'amministrazione','as'=>'general.',
],function() {
    /*
     * Location
     */
		Route::group( ['prefix' => 'api'], function ()
		{
			Route::get('/locations', 'LocationController@getLocations');
			Route::get('/educations', 'EducationsController@getEducations');
			Route::get('/document-types', 'DocumentTypesController@getDocumentTypes');
			Route::get('/user-types', 'EducationsController@userTypeLabels');
		});

		/*
		 * Storehouse
		 */
	  Route::get('/storehouse','StorehouseController@index')->name('storehouse.index');
	  Route::get('/storehouse/personale','StorehouseController@personal')->name('storehouse.personal');
	  Route::get('/storehouse-partner','StorehouseController@indexPartner')->name('storehouse.partner');
	  Route::get('/storehouse-master','StorehouseController@indexMaster')->name('storehouse.master');
	  Route::get('/storehouse-affiliate','StorehouseController@indexAffiliate')->name('storehouse.affiliate');



});
