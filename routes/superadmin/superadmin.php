<?php
/**
 * Here are listed or the routes for superadmin and admin
 *
 */

Route::group([
              'middleware' => ['auth','check_user_role:Amministrazione' ],
              'prefix'=>'amministrazione','as'=>'superadmin.',
              'namespace'=>'Admin'
             ],function() {

        Route::get('/dashboard', 'DashboardController@index')->name('home');


});
