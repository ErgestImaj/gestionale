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



        Route::view('/admins','superadmin.employee.admin.index')->name('admins.index');
        Route::get('/admins/index','AdminController@index');
        Route::view('admins/create','superadmin.employee.admin.create')->name('admins.create');
        Route::post('/admins/store','AdminController@store')->name('admins.store');
        Route::patch('/admin/{user}','AdminController@update')->name('admins.update');
        Route::delete('/admin/delete/{user?}','AdminController@destroy')->name('admins.destroy');

});

//Superadmin and admin routes

Route::group([
    'middleware' => ['auth','check_user_role:superadmin|admin' ],
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



});
