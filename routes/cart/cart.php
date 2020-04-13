<?php
//Cart and order routes
Route::group([
	'middleware' => ['auth','check_user_role:superadmin' ],
	'prefix'=>'cart','as'=>'cart.',
	'namespace'=>'Cart'
],function() {


		Route::view('/orders','orders.index')->name('orders.list');
		Route::view('/fast-track','orders.fast-track')->name('fasttrack.list');
		Route::view('/courses-requests','orders.structure-orders')->name('structure.orders.list');
		Route::view('/electronic-invoice','orders.electronic-invoice')->name('electronic.invoice.list');
		Route::get('/generate-electronic-invoice/fast-track/{fastTrack}','FastTrackController@generateInvoice');
		Route::get('/generate-electronic-invoice/order/{order}','OrdersController@generateInvoice');

		Route::group( ['prefix' => 'api'], function ()
		{
			Route::get('/orders','OrdersController@index');
			Route::get('/orders/export/{from_date?}/{to_date?}/{structure?}', 'OrdersController@export')->name('orders.export');

			Route::get('/courses-requests/export/{from_date?}/{to_date?}/{structure?}', 'CourseRequestController@export')->name('course.requests.export');
			Route::get('/courses-requests','CourseRequestController@index');
			Route::patch('/courses-requests/{courseRequest}/block','CourseRequestController@blockCoursesRequest');
			Route::patch('/courses-requests/{courseRequest}/unblock','CourseRequestController@unBlockCoursesRequest');
			Route::patch('/courses-requests/{courseRequest}/confirm','CourseRequestController@confirmCoursesRequest');

			Route::get('/fast-track/export/{from_date?}/{to_date?}/{structure?}', 'FastTrackController@export')->name('fasttrack.export');
			Route::get('/fast-track','FastTrackController@index');
			Route::post('/fast-track/{fastTrack}/upload','FastTrackController@uploadInvoice');
			Route::get('/fast-track/{fastTrack}/download','FastTrackController@downloadInvoice');
			Route::get('/fast-track/{fastTrack}/send','FastTrackController@sendInvoice');
			Route::patch('/fast-track/{fastTrack}/confirm','FastTrackController@manualOrderConfirm');

			Route::post('/orders/{order}/upload','OrdersController@uploadInvoice');
			Route::get('/orders/{order}/download','OrdersController@downloadInvoice');
			Route::patch('/orders/{order}/confirm','OrdersController@manualOrderConfirm');

			Route::get('/electronic-invoice','ElectronicInvoiceController@index');
			Route::delete('/electronic-invoice/{invoice}','ElectronicInvoiceController@destroy');

		});




});
