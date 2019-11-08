<?php
//Superadmin and admin routes

Route::group([
    'middleware' => ['auth','check_user_role:superadmin|admin|docente' ],
],function() {

    /*
     * Course modules
     */

    Route::view('/course/{course}/module','superadmin.course.modules.index')->name('module.index');

    Route::post('/course/{course}/modules/filter','CourseModuleController@index')->name('module.all');

    Route::post('/course/{course}/module','CourseModuleController@store')->name('module.store');
    Route::get('/module/{courseModule}/edit','CourseModuleController@edit')->name('module.edit');
    Route::patch('/module/{courseModule}','CourseModuleController@update')->name('module.update');
    Route::delete('/module/{courseModule}','CourseModuleController@destroy')->name('module.destroy');

});
