<?php
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Profile'], function() {

        Route::get('/profile', 'ProfileController@index');
        Route::patch('/update/{user}', 'ProfileController@update')->name('update');

    });
});
