<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CoursesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Expiry;
use App\Models\VatRate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
	public function export()
	{
		return Excel::download(new CoursesExport(request()->course, request()->category), 'courses.xlsx');
	}
	public function filter()
	{
		return view('course.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index()
	{
		$this->authorize('index', Course::class);

	   return Course::with([
														'user'=>function($query){
															$query->select(['id','firstname','lastname']);
														},
														'updatedByUser'=>function($query){
															$query->select(['id','firstname','lastname']);
														},
														'category'=>function($query){
															$query->select(['id','name']);
														},
														])->get(['id','code','name','price','state','created_by','updated_by','category_id']);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create', Course::class);

		$categories = Category::all();
		$expirations = Expiry::all();
		$vatrates = VatRate::all();
		return view('course.create', [
			'categories' => $categories,
			'expirations' => $expirations,
			'vatrates' => $vatrates
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CourseRequest $request)
	{
		$this->authorize('create', Course::class);
    DB::beginTransaction();
		try {
			$course = new Course();
			$course->fill($request->fillFormData());
			$course->save();
			$course->settings()->create($request->fillCourseSettingsData());
			DB::commit();
			return response([
				'status' => 'success',
				'msg' => trans('messages.success'),
				'redirect'=>route('admin.courses.list')
			]);
		} catch (\Exception $exception) {
			DB::rollback();
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
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Course $course)
	{
		$categories = Category::all();
		$expirations = Expiry::all();
		$vatrates = VatRate::all();
		return view('course.edit', [
			'categories' => $categories,
			'course' => $course,
			'settings'=>[
				'student_nr'=>$course->settings->student_nr??null,
				'pause'=>$course->settings->pause??null,
				'pause_time'=>$course->settings->pause_time??null,
				'pause_frequency'=>$course->settings->pause_frequency??null,
				'total_hours'=>$course->settings->total_hours??null,
			],
			'expirations' => $expirations,
			'vatrates' => $vatrates,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(CourseRequest $request, Course $course)
	{
		$this->authorize('update', $course);
		try {
			$course->fill($request->fillFormData());
			$course->update();
			if ($course->settings()->exists()){
				$settings = $course->settings()->first();
				$settings->update($request->fillCourseSettingsData());
			}else{
				$course->settings()->create($request->fillCourseSettingsData());
			}

			return response([
				'status' => 'success',
				'msg' => trans('messages.success')
			]);
		} catch (\Exception $exception) {
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}

	}

	public function updateStatus(Course $course)
	{

		if (!auth()->user()->can('update', $course)) {
			return response([
				'status' => 'unauthorized',
				'msg' => trans('messages.unauthorized')
			]);

		}
		$course->isActive() ? $course->disable() : $course->enable();

		return response([
			'status' => 'success',
			'msg' => trans('messages.change_status')
		]);


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Course $course)
	{
		foreach ($course->modules as $module) {
			$module->contents()->delete();
		}

		$course->modules()->delete();
		$course->delete();
		return response([
			'status' => 'success',
			'msg' => trans('messages.delete_msg', ['record' => trans('form.course')])
		]);
	}
}
