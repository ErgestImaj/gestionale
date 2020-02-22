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
		$contents = ModuleContent::latest()->get();


		$datatable = DataTables::of( $contents )
		                       ->addIndexColumn()
		                       ->addColumn( 'code', function ( $row ) {
			                       return $row->code;
		                       } )
		                       ->addColumn( 'module', function ( $row ) {
			                       return optional( $row->module )->module_name;
		                       } )
		                       ->addColumn( 'course', function ( $row ) {
			                       return optional( $row->module )->course->code;
		                       } )
		                       ->addColumn( 'status', function ( $row ) {
			                       return $row->isActive() ? '<span class="badge badge-success">' . trans( 'form.active' ) . '</span>'
				                       : '<span class="badge badge-secondary">' . trans( 'form.disabled' ) . '</span>';
		                       } )
		                       ->addColumn( 'created_by', function ( $row ) {
			                       return $row->user->displayName();
		                       } )
		                       ->addColumn( 'updated_by', function ( $row ) {
			                       return optional( $row->updatedByUser )->displayName();
		                       } )
		                       ->addColumn( 'actions', function ( $row ) {
			                       $html = ' <a class=" action btn block-btn btn-dark mb-1" data-tooltip="' . trans( 'form.edit' ) . '" href="' . route( 'lms-content.edit', [ 'lms_content' => $row->hashid() ] ) . '">
                               <i class="fas fa-pencil-alt"></i>
                          </a>';
			                       $html .= '
                          <div class="btn-group mb-1">
                            <button type="button" class="btn block-btn dropdown-toggle" data-toggle="dropdown"><span class="caret ml-0"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">

                                    <li>
                                      <a class="d-block update-btn btn-link page-link" href="#" data-action="' . route( 'lmscontent.status', [ 'content' => $row->hashid() ] ) . '">';
			                       if ( $row->isActive() ):
				                       $html .= '  <i class="fas fa-times"></i>' . trans( 'messages.disable' );
			                       else:
				                       $html .= '  <i class="fas fa-ticket-alt"></i>' . trans( 'messages.active' );
			                       endif;
			                       $html .= ' </a>
                                    </li>
                                    <li>
                                        <a class="d-block btn-link page-link" href="' . route( 'lms-content.show', [ 'lms_content' => $row->hashid() ] ) . '">
                                           <i class="fas fa-eye"></i>' . trans( 'form.view' ) . '
                                        </a>
                                    </li>
                                     <li>
                                        <a class="d-block delete-btn btn-link page-link" data-content="' . trans( 'messages.delete_confirm', [ 'record' => trans( 'form.content' ) ] ) . '" data-action="' . route( 'lms-content.destroy', [ 'lms_content' => $row->hashid() ] ) . '" href="#">
                                           <i class="fas fa-trash-alt"></i>' . trans( 'form.delete' ) . '
                                        </a>
                                    </li>
                            </ul>
                        </div>';

			                       return $html;
		                       } )
		                       ->rawColumns( [ 'actions', 'status' ] )
		                       ->make( true );

		return $datatable;
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

		$courses = Course::active()->get( [ 'id', 'name' ] );

		return $courses;
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
		dd( $lms_content );
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
