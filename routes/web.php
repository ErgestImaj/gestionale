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

/**
 *  Superadmin and admin routes
 */

require_once __DIR__ .'/superadmin/superadmin.php';

/**
 * Partner, Master, Affiliati routes
 */

require_once __DIR__ .'/structures/structures.php';


/**
 * Utenti
 */

require_once __DIR__ .'/utenti/utenti.php';

/**
 * All other users routes
 */
require_once  __DIR__ . '/users/usergrups.php';


/**
 * Common routes
*/
require __DIR__ . '/profile/profile.php';

/**
 * Exams routes
*/
require __DIR__ . '/exams/exams.php';

/**
 * localization for VueJS
 */

Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');
