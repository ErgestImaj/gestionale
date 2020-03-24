<?php

namespace App\Http\Controllers;

use App\Helpers\Upload;
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
		$content = new ModuleContent();
		$file    = null;
		if ( $request->hasFile( 'lms_file' ) ) {
			if ( $request->file( 'lms_file' )->isValid() ) {
				$upload = new Upload();
				$file   = $upload->upload( $request->file( 'lms_file' ), 'public/' . ModuleContent::CONTENT_PATH )->getData();
				$file   = $file['basename'];
			}
		}

		$content->file_path = $file != null ? $file : $request->file_path;
		$content->fill( $request->fillFormData() );
		$content->save();

		return response( [
			'status' => 'success',
			'msg'    => trans( 'messages.success' )
		] );

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
	public function update( Request $request, ModuleContent $lms_content ) {
		//
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
