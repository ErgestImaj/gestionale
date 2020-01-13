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


        // Admin
        Route::view('/admins','superadmin.employee.admin.index')->name('admins.index');
        Route::get('/admins/index','AdminController@index');
        Route::view('admins/create','superadmin.employee.admin.create')->name('admins.create');
        Route::post('/admins/store','AdminController@store')->name('admins.store');
        Route::patch('/admin/{user}','AdminController@update')->name('admins.update');
        Route::delete('/admin/delete/{user?}','AdminController@destroy')->name('admins.destroy');

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



});

//Superadmin and admin routes

Route::group([
    'middleware' => ['auth','check_user_role:superadmin|amministrazione' ],
    'prefix'=>'amministrazione','as'=>'admin.',
    'namespace'=>'Admin'
],function() {

    Route::get('/dashboard', 'DashboardController@index')->name('home');

    Route::post('/send-invitation-link/{user}','EmailsController@sendInvitationLink')->name('invitation');
    Route::post('/send-email-to-single-user/{user}','EmailsController@sendEmailToUser')->name('emailtosingleuser');
    Route::get('/login-as-user/{user}','LoginController@loginAsUser')->name('loginasuser');
    Route::get('/re-login-as-admin','LoginController@reLoginAsAdmin')->name('relogin');


    Route::get('/admin/{user}','AdminController@edit')->name('admins.edit');
    Route::patch('/admin/status/{user}','AdminController@updateStatus')->name('users.status');
    //Segreteria
    Route::view('/segreteria','superadmin.employee.segreteria.index')->name('segreteria.index');
    Route::get('/segreteria/index','AdminController@segreteria');
    Route::view('segretaria/create','superadmin.employee.segreteria.create')->name('segreteria.create');
    Route::post('/segretaria/store','AdminController@storeSegreteria')->name('segreteria.store');


    /*
     * Course and categorie routes
     */

    Route::get('/categories','CategoryController@index')->name('categories');
    Route::post('/categories','CategoryController@store')->name('category.new');
    Route::get('/category/{category}','CategoryController@edit')->name('category.edit');
    Route::patch('/categories/{category}','CategoryController@update')->name('category.update');
    Route::delete('/categories/{category}','CategoryController@destroy')->name('category.destroy');

    Route::get('/courses-list','CourseController@filter')->name('courses.list');
    Route::resource('/courses','CourseController');
    Route::patch('/course/status/{course}','CourseController@updateStatus')->name('course.status');

    /*
     * Mass emails
     */
    Route::get( '/messaggi', 'EmailsController@massEmail' )->name( 'massemail' );
    Route::get( '/api/messaggi', 'EmailsController@massEmailApi' )->name( 'apimassemail' );
    Route::post( '/messaggi', 'EmailsController@sendMassEmail' )->name( 'sendmassemail' );
    Route::delete( '/messaggi/{log}/elimina', 'EmailsController@deleteMassEmail' )->name( 'deletemassemail' );

});
