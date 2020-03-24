<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseModuleRequest;
use App\Models\Course;
use App\Models\CourseModule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Exception;

class CourseModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index( Course $course)
    {
        return $course->modules;
    }

	/**
	 * API get all modules
	 *
	 * @param Course $course
	 * @return Response
	 */
		public function getAll(Course $course)
		{
			$modules = $course->modules()->getResults();
			return $modules;
		}


    /**
     * Store a newly created resource in storage.
     *
     * @param CourseModuleRequest $request
     * @param Course $course
     * @return void
     */
    public function store(CourseModuleRequest $request,Course $course)
    {
			try {
				$module = new CourseModule();
				$module->fill($request->fillFormData());
				$module->course_id = $course->id;
				$module->save();
				return response( [
					'status' => 'success',
					'msg'    => trans('messages.success')
				] );
			} catch (\Exception $exception) {
				logger($exception->getMessage());
				return response([
					'status' => 'error',
					'msg' => trans('messages.error')
				]);
			}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseModule  $courseModule
     * @return Response
     */
    public function show(CourseModule $courseModule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseModule  $courseModule
     * @return Response
     */
    public function edit(CourseModule $courseModule)
    {
       return ['module'=>$courseModule];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseModule  $courseModule
     * @return Response
     */
    public function update(CourseModuleRequest $request, CourseModule $courseModule)
    {
			try {
				$courseModule->fill($request->fillFormData());
				$courseModule->update();
				return response( [
					'status' => 'success',
					'msg'    => trans('messages.success')
				] );
			} catch (\Exception $exception) {
				logger($exception->getMessage());
				return response([
					'status' => 'error',
					'msg' => trans('messages.error')
				]);
			}

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseModule  $courseModule
     * @return Response
     */
    public function destroy(CourseModule $courseModule)
    {
    	  $courseModule->contents()->delete();
        $courseModule->delete();
        return response( [
            'status' => 'success',
            'msg'    => trans('messages.delete_msg',['record'=>trans('form.module')])
        ] );
    }
}
