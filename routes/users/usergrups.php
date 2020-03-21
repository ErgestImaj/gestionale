<?php
//Superadmin and admin routes

Route::group([
    'middleware' => ['auth','check_user_role:superadmin|admin|docente' ],
],function() {

    /*
     * Course modules
     */

    Route::view('/course/{course}/module','course.modules.index')->name('module.index');

    Route::post('/course/{course}/modules/filter','CourseModuleController@index')->name('module.all');
    Route::get('/api/course/{course}/modules','CourseModuleController@getAll')->name('api.modules');

    Route::post('/course/{course}/module','CourseModuleController@store')->name('module.store');
    Route::get('/module/{courseModule}/edit','CourseModuleController@edit')->name('module.edit');
    Route::patch('/module/{courseModule}','CourseModuleController@update')->name('module.update');
    Route::delete('/module/{courseModule}','CourseModuleController@destroy')->name('module.destroy');

    Route::view('/lms-contents','course.lmscontent.index')->name('lms_content');
    Route::resource('/lms-content','ModuleContentController');
    Route::patch('/lms-content/status/{content}','ModuleContentController@updateStatus')->name('lmscontent.status');

    Route::get('/filter-courses','ModuleContentController@filterCourses');
    Route::get('/course/{course}/modules','ModuleContentController@filterCourseModules');

});
