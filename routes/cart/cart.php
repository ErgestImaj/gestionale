<?php
//Cart and order routes
Route::group([
	'middleware' => ['auth','check_user_role:superadmin' ],
	'prefix'=>'cart','as'=>'cart.',
	'namespace'=>'Cart'
],function() {


		Route::view('/orders','orders.index')->name('orders.list');

		Route::group( ['prefix' => 'api'], function ()
		{
			Route::get('/orders','OrdersController@index');
			Route::get('/courses-requests','CourseRequestController@index');
			Route::get('/fast-track','FastTrackController@index');
			Route::get('/electronic-invoice','ElectronicInvoiceController@index');

		});




});