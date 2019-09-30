<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');
/**
 *  Superadmin and admin routes
 */

require_once __DIR__ .'/superadmin/superadmin.php';

/**
 * Partner, Master, Affiliati routes
 */

require_once __DIR__ .'/agencies/agencies.php';

/**
 * All other users routes
 */
require_once  __DIR__ . '/users/usergrups.php';


