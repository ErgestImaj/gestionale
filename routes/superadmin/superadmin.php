<?php
/**
 * Here are listed or the routes for superadmin and admin
 *
 */

Route::group([
              'middleware' => ['auth','check_user_role:superadmin' ],
              'prefix'=>'amministrazione','as'=>'superadmin.',
              'namespace'=>'Admin'
             ],function() {

        //Settings

       Route::get('/settings/permission','SettingsController@permissionSettings')->name('permission');
       Route::patch('/settings/permission/{userGroups}','SettingsController@changeGroupStatus')->name('permission.update');
       Route::get('/settings/emails','SettingsController@emailSettings')->name('email');
       Route::patch('/settings/email/{key}','SettingsController@updateEmailSettings')->name('emails.update');
       Route::get('/settings/maintenance/','SettingsController@maintenance')->name('maintenance');
       Route::patch('/settings/maintenance/','SettingsController@setMaintenaceMode')->name('maintenance.update');
       Route::get('/settings/payment/','SettingsController@paymentSettings')->name('payment');
       Route::patch('/settings/payment/iban/{key}','SettingsController@updateIBANSettings')->name('iban.update');
       Route::patch('/settings/payment/paypal/{key}','SettingsController@updatePayPalSettings')->name('paypal.update');
       Route::patch('/settings/payment/stripe/{key}','SettingsController@updateStripeSettings')->name('stripe.update');
       Route::patch('/settings/payment/price/{key}','SettingsController@updatePriceSettings')->name('price.update');
       Route::patch('/settings/payment/bills/{key}','SettingsController@updateBillsSettings')->name('bills.update');
       Route::patch('/settings/payment/emailconfiguration','SettingsController@updateEmailSMTPSettings')->name('emailsmtp.update');
       Route::get('/settings/iva/','SettingsController@ivaSettings')->name('iva');
       Route::post('/settings/iva/','SettingsController@addIvaSettings')->name('iva.add');
       Route::patch('/settings/iva/{rate}','SettingsController@updateIvaSettings')->name('iva.update');
       Route::delete('/settings/iva/{rate}','SettingsController@destroyIvaSettings')->name('iva.destroy');
	     Route::get('/settings/scadenza-contrato/','SettingsController@scadenzaContrato')->name('scadenza_contrato');
	     Route::post('/settings/scadenza-contrato/','SettingsController@addScadenzaContrato')->name('scadenza_contrato.add');



});

//Superadmin and admin routes

Route::group([
    'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
    'prefix'=>'amministrazione','as'=>'admin.',
    'namespace'=>'Admin'
],function() {

	  Route::post('/export','ExportController@index');

    Route::get('/dashboard', 'DashboardController@index')->name('home');

    Route::post('/send-invitation-link/{user}','EmailsController@sendInvitationLink')->name('invitation');
    Route::post('/send-email-to-single-user/{user}','EmailsController@sendEmailToUser')->name('emailtosingleuser');
    Route::get('/login-as-user/{user}','LoginController@loginAsUser')->name('loginasuser');
    Route::get('/re-login-as-admin','LoginController@reLoginAsAdmin')->name('relogin');

    Route::patch('/admin/status/{user}','AdminController@updateStatus')->name('users.status');

    /*
     * Course,promo pack and categorie routes
     */

    Route::get('/categories','CategoryController@index')->name('categories');
    Route::get('/api/categories','CategoryController@getAll')->name('api.categories');
    Route::post('/api/categories/create','CategoryController@apiCreate')->name('api.category.create');
    Route::patch('/api/categories/update/{category}','CategoryController@apiUpdate')->name('api.category.update');
    Route::post('/categories','CategoryController@store')->name('category.new');
    Route::get('/category/{category}','CategoryController@edit')->name('category.edit');
    Route::patch('/categories/{category}','CategoryController@update')->name('category.update');
    Route::delete('/categories/{category}','CategoryController@destroy')->name('category.destroy');

    Route::get('/courses-list','CourseController@filter')->name('courses.list');
    Route::resource('/courses','CourseController');
    Route::patch('/course/status/{course}','CourseController@updateStatus')->name('course.status');

  	Route::view('/promo-pack', 'course.promo.create')->name('promo.pack');
	  Route::get('/api/promo-pack','PromoPackController@index')->name('promo.pack.list');

    /*
     * Area Download
     */
    Route::view('/download/create', 'download.create')->name('download.create');
    Route::view('/download/', 'download.index')->name('download.index');
    Route::view('/download/{document}', 'download.edit')->name('download.edit');
    Route::get('/area-download/', 'DocumentController@index')->name('download.datatable');
    Route::delete('/area-download/{document}','DocumentController@destroy')->name('download.destroy');
    Route::view('/area-download/categories', 'download.categories')->name('download.categories');
    Route::delete('/download/categories/{category}','DocumentCategoriesController@destroy')->name('download.category.destroy');



    /*
     * Mass emails
     */
    Route::view( '/messaggi', 'superadmin.messages.index' )->name( 'massemail' );
    Route::post( '/messaggi', 'EmailsController@sendMassEmail' )->name( 'sendmassemail' );
    Route::delete( '/messaggi/{log}/elimina', 'EmailsController@deleteMassEmail' )->name( 'deletemassemail' );

    /*
     * Workshop
     */
    Route::view( '/workshops', 'workshops.index' )->name( 'workshops.index' );

    Route::post('/workshop','WorkshopController@store');
    Route::get('/workshop/{workshop}','WorkshopController@show')->name('workshop.edit');
    Route::patch('/workshop/{workshop}/update','WorkshopController@update')->name('workshop.update');
    Route::delete( '/workshop/{workshop}/elimina', 'WorkshopController@destroy' )->name( 'workshop.destroy' );

    /*
     * Report formazione
     */
	  Route::get('/api/certificates','CertificateController@index')->name('certificates.index');
	  Route::view('certificates','certificate.index')->name('certificates.list');

		/*
		* Api
		*/
		Route::group( ['prefix' => 'api'], function ()
		{
			/*
		   * Area Download
		   */
			Route::get('/download/{document}','DocumentController@edit')->name('download.getdoc');
			Route::post('/download/{document}/update','DocumentController@update')->name('download.update');
			Route::post('/download/store','DocumentController@store')->name('download.store');
			Route::get('/download/category/index','DocumentCategoriesController@index')->name('download.categories.index');
			Route::get('/download/category/list','DocumentCategoriesController@listCategories')->name('download.categories.list');
			Route::post('/download/category/create','DocumentCategoriesController@store')->name('download.categories.create');
			Route::patch('/download/category/{category}','DocumentCategoriesController@update')->name('download.categories.update');
			/*
			 * Mass emails
			 */
			Route::get( '/getroles', 'EmailsController@getRoles' )->name( 'getRoles' );
			Route::get( '/getemails/{email}', 'EmailsController@getEmails' )->name( 'getEmails' );
			Route::get( '/messaggi', 'EmailsController@massEmailApi' )->name( 'apimassemail' );
			/*
			 * Workshop
			 */
			Route::get( '/getworkshops', 'WorkshopController@getWorkshops' )->name( 'workshop.data' );
			Route::get('/workshop/{workshop}/show','WorkshopController@edit')->name('workshop.edit-data');
		});

});
