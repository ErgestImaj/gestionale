<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Http\Requests\LmsContentRequest;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\ModuleContent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ModuleContentController
 * @package App\Http\Controllers
 */
class ModuleContentController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$contents = ModuleContent::with(
			[
				'module' => function ($query) {
					$query->select(['id', 'module_name', 'course_id']);
				},
				'module.course' => function ($query) {
					$query->select(['id', 'code']);
				},
				'user' => function ($query) {
					$query->select(['id', 'firstname', 'lastname']);
				},
				'updatedByUser' => function ($query) {
					$query->select(['id', 'firstname', 'lastname']);
				},
			]
		)->get(['id', 'code', 'state', 'created_by', 'updated_by', 'module_id']);

		return $contents;

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('course.lmscontent.create');
	}

	public function filterCourses()
	{

		return Course::active()->get(['id', 'name']);
	}

	public function filterCoursesByCategory($type)
	{

		return Course::active()->whereHas('category', function ($query) use ($type) {
			$query->where('type', $type);
		})->get(['id', 'name']);
	}


	public function filterCourseModules(Course $course)
	{

		return CourseModule::where('course_id', $course->id)->get(['id', 'module_name']);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param LmsContentRequest $request
	 *
	 * @return void
	 */
	public function store(LmsContentRequest $request)
	{

		$file =[];

		switch ($request->input('content_type')) {
			case 'url':
			case 'video_url':
			case 'audio_url':
				$file['url'] = $request->input('file_path');
				$file['is_url'] = true;
				break;
			case 'file' :
			case 'video' :
			case 'audio' :
				if ($request->hasFile('lms_file')) {
					if ($request->file('lms_file')->isValid()) {
						$file = UploadHelper::uploadAndGetUrl($request->file('lms_file'),ModuleContent::CONTENT_PATH);
						if (empty($file['url'])) {
							return response([
								'status' => 'error',
								'msg' => trans('messages.error_file')
							]);
						}
					}
				}
				break;

		}


		try {
			$content = new ModuleContent();
			$content->file_path = $file['url'];
			$content->is_url = $file['is_url'];
			$content->fill($request->fillFormData());
			$content->save();
			return response([
				'status' => 'success',
				'msg' => trans('messages.success'),
			]);

		} catch (Exception $exception) {
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
	 * @param ModuleContent $lms_content
	 *
	 * @return Response
	 */
	public function show(ModuleContent $lms_content)
	{

		return view('course.lmscontent.show')->with([
			'content' => $lms_content
		]);
	}

	public function updateStatus(ModuleContent $content)
	{

		$content->isActive() ? $content->disable() : $content->enable();

		return response([
			'status' => 'success',
			'msg' => trans('messages.change_status')
		]);


	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param ModuleContent $lms_content
	 *
	 * @return Response
	 */
	public function edit(ModuleContent $lms_content)
	{
		return view('course.lmscontent.edit', compact('lms_content'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param ModuleContent $lms_content
	 *
	 * @return Response
	 */
	public function updateLms(LmsContentRequest $request, ModuleContent $lms_content)
	{

		$file = [
			'url'=>'',
			'is_url'=>''
		];

		switch ($request->input('content_type')) {
			case 'url':
			case 'video_url':
			case 'audio_url':
			$file['url'] = $request->input('file_path');
			$file['is_url'] = true;
				break;
			case 'file' :
			case 'video' :
			case 'audio' :
			if ($request->hasFile('lms_file')) {
				if ($request->file('lms_file')->isValid()) {
					$file = UploadHelper::uploadAndGetUrl($request->file('lms_file'),ModuleContent::CONTENT_PATH);
					if (empty($file['url'])) {
						return response([
							'status' => 'error',
							'msg' => trans('messages.error_file')
						]);
					}
				}
			}
				break;

		}
		try {
			$lms_content->file_path = (empty($file['url'])) ? $lms_content->file_path : $file['url'];
			$lms_content->is_url =(empty($file['url'])) ? 	$lms_content->is_url  : $file['is_url'];
			$lms_content->fill($request->fillFormData());
			$lms_content->save();
			return response([
				'status' => 'success',
				'msg' => trans('messages.success')
			]);

		} catch (Exception $exception) {
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
	 * @param ModuleContent $lms_content
	 *
	 * @return Response
	 */
	public function destroy(ModuleContent $lms_content)
	{
		$lms_content->delete();

		return response([
			'status' => 'success',
			'msg' => trans('messages.delete_msg', ['record' => trans('form.content')])
		]);
	}
}
