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

		Route::group( ['prefix' => 'api'], function ()
		{
			Route::get('/orders','OrdersController@index');

			Route::get('/courses-requests','CourseRequestController@index');
			Route::patch('/courses-requests/{courseRequest}/block','CourseRequestController@blockCoursesRequest');
			Route::patch('/courses-requests/{courseRequest}/unblock','CourseRequestController@unBlockCoursesRequest');
			Route::patch('/courses-requests/{courseRequest}/confirm','CourseRequestController@confirmCoursesRequest');

			Route::get('/fast-track','FastTrackController@index');
			Route::post('/fast-track/{fastTrack}/upload','FastTrackController@uploadInvoice');
			Route::get('/fast-track/{fastTrack}/download','FastTrackController@downloadInvoice');
			Route::get('/fast-track/{fastTrack}/send','FastTrackController@sendInvoice');
			Route::patch('/fast-track/{fastTrack}/confirm','FastTrackController@manualOrderConfirm');

			Route::get('/electronic-invoice','ElectronicInvoiceController@index');
			Route::delete('/electronic-invoice/{invoice}','ElectronicInvoiceController@destroy');

		});




});
