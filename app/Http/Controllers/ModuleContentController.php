<?php

namespace App\Http\Controllers;

use App\Helpers\FileExtensionsHelper;
use App\Helpers\Upload;
use App\Helpers\UploadHelper;
use App\Helpers\UploadToBox;
use App\Http\Requests\LmsContentRequest;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\ModuleContent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * Class ModuleContentController
 * @package App\Http\Controllers
 */
class ModuleContentController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$contents = ModuleContent::with(
																			[
																						'module'=>function($query){
																							$query->select(['id','module_name','course_id']);
																						},
																						'module.course'=>function($query){
																							$query->select(['id','code']);
																						},
																						'user'=>function($query){
																							$query->select(['id','firstname','lastname']);
																						},
																						'updatedByUser'=>function($query){
																							$query->select(['id','firstname','lastname']);
																						},
																				]
																		)->get(['id','code','state','created_by','updated_by','module_id']);

       return $contents;

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'course.lmscontent.create' );
	}

	public function filterCourses() {

		return Course::active()->get( [ 'id', 'name' ] );
	}
	public function filterCoursesByCategory($type) {

		return Course::active()->whereHas('category',function($query) use ($type){
			    $query->where('type',$type);
		     })->get( [ 'id', 'name' ] );
	}


	public function filterCourseModules( Course $course ) {

		return CourseModule::where( 'course_id', $course->id )->get( [ 'id', 'module_name' ] );

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param LmsContentRequest $request
	 *
	 * @return void
	 */
	public function store( LmsContentRequest $request ) {

		$url='';
		$is_url = false;

		switch ($request->input('content_type')) {
			case 'url':
			case 'video_url':
			case 'audio_url':
				$url = $request->input('file_path');
				$is_url = true;
				break;
			case 'file' :
			case 'video' :
			case 'audio' :
	 	   	$data = UploadHelper::uploadAndGetUrl($request);
			  $url = $data['url'];
			  $is_url = $data['is_url'];
			  break;

		}

		if (empty($url) && $request->input('content_type') !='text'){
			return response( [
				'status' => 'error',
				'msg'    => trans('messages.error_file')
			] );
		}
				try{
					$content = new ModuleContent();
					$content->file_path = $url;
					$content->is_url = $is_url;
					$content->fill( $request->fillFormData() );
					$content->save();
					return response( [
						'status' => 'success',
						'msg'    => trans('messages.success')
					] );

				}catch(\Exception $exception){
					logger($exception->getMessage());
					return response( [
						'status' => 'error',
						'msg'    => trans('messages.error')
					] );
				}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\ModuleContent $lms_content
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( ModuleContent $lms_content ) {

		return view( 'course.lmscontent.show' )->with( [
			'content' => $lms_content
		] );
	}

	public function updateStatus( ModuleContent $content ) {

		$content->isActive() ? $content->disable() : $content->enable();

		return response( [
			'status' => 'success',
			'msg'    => trans( 'messages.change_status' )
		] );


	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\ModuleContent $lms_content
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( ModuleContent $lms_content ) {
		return view('course.lmscontent.edit',compact('lms_content'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\ModuleContent $lms_content
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateLms( LmsContentRequest $request, ModuleContent $lms_content ) {
		dd($request->all());
		$file = null;
		if ($this->hasFile('lms_file')){
			if ($this->file('lms_file')->isValid()) {
				#file
				$file = $this->file('lms_file');
				#get file extension
				$extension =  $file->getClientOriginalExtension();
				#register file name
				$name = $file->getClientOriginalName();
				$name = microtime() . '_' . $name;
				#take care of save
				if (in_array($extension,FileExtensionsHelper::allowedExtensions())){
					$upload = new Upload();
					$file = $upload->upload($file, 'public/'.ModuleContent::CONTENT_PATH)->getData();
					$url = $file['basename'];
				}else if(in_array($extension,FileExtensionsHelper::allowedExtensionsForBox())){
					$url = UploadToBox::exportFile($file);
				}else{
					return response( [
						'status' => 'error',
						'msg'    => trans('messages.error_file')
					] );
				}


				$url;

				try{
					$document->save();
					$document->categories()->attach($request->input('category'));
					return response( [
						'status' => 'success',
						'msg'    => trans('messages.success')
					] );
				}catch(\Exception $exception){
					logger($exception->getMessage());
					return response( [
						'status' => 'error',
						'msg'    => trans('messages.error')
					] );
				}

			}
		}
		return response( [
			'status' => 'error',
			'msg'    => trans('messages.error_file')
		] );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\ModuleContent $lms_content
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( ModuleContent $lms_content ) {
		$lms_content->delete();

		return response( [
			'status' => 'success',
			'msg'    => trans( 'messages.delete_msg', [ 'record' => trans( 'form.content' ) ] )
		] );
	}
}
