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
    Route::post('lms-content/{lms_content}/update','ModuleContentController@updateLms');
    Route::patch('/lms-content/status/{content}','ModuleContentController@updateStatus')->name('lmscontent.status');

    Route::get('/filter-courses','ModuleContentController@filterCourses');
    Route::get('/filter-courses-by-category/{type}','ModuleContentController@filterCoursesByCategory');
    Route::get('/course/{course}/modules','ModuleContentController@filterCourseModules');

    //Tracking Orders
  	Route::get('tracking/export/{from_date?}/{to_date?}/{structure?}', 'TrackingController@export')->name('tracking.export');
	  Route::get('/api/tracking','TrackingController@index');
	  Route::view('/tracking', 'tracking.index')->name('tracking.list');
	  Route::view('/tracking/create', 'tracking.create')->name('tracking.create');
	  Route::post('/tracking/store', 'TrackingController@store')->name('tracking.store');
	  Route::view('/tracking/{tracking}/edit', 'tracking.edit')->name('tracking.edit');
	  Route::get('/tracking/{tracking}', 'TrackingController@edit')->name('tracking.edittracking');
	  Route::post('/tracking/{tracking}/update', 'TrackingController@update')->name('tracking.update');
	  Route::patch('/tracking/{tracking}/{status}/received', 'TrackingController@updateStatus')->name('tracking.updatestatus');

});
