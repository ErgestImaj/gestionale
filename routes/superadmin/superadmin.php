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

        Route::get('/dashboard', 'DashboardController@index')->name('home');

        Route::view('/admins','superadmin.employee.admin.index')->name('admins.index');
        Route::get('/admins/index','AdminController@index');
        Route::view('admins/create','superadmin.employee.admin.create')->name('admins.create');
        Route::post('/admins/store','AdminController@store')->name('admins.store');
        Route::get('/admin/{user}','AdminController@edit')->name('admins.edit');
        Route::patch('/admin/{user}','AdminController@update')->name('admins.update');
        Route::delete('/admin/delete/{user?}','AdminController@destroy')->name(' ');
        Route::patch('/admin/status/{user}','AdminController@updateStatus')->name('admins.status');

});

Route::group([
    'middleware' => ['auth','check_user_role:superadmin|admin' ],
    'prefix'=>'amministrazione','as'=>'admin.',
    'namespace'=>'Admin'
],function() {

    Route::post('/send-invitation-link/{user}','EmailsController@sendInvitationLink')->name('invitation');

});
