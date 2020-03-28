<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use App\Models\Exams\MediaformExamSession;
use Illuminate\Http\Request;

class MediaformExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
			/**
			 * Type values:
			 * CERTIFICATO = 2;
			 * ATTESTATO = 3;
			 */
    	if(empty($type))return[];

			$mfexams = MediaformExamSession::where('type',$type)->with([
				'owner'=>function($query){
					$query->select(['id','firstname']);
				},
				'course'=>function($query){
					$query->select(['id','name']);
				},
				'examiner'=>function($query){
					$query->select(['id','firstname','lastname']);
				},
				'former'=>function($query){
					$query->select(['id','firstname','lastname']);
				},
				'supervisor'=>function($query){
					$query->select(['id','firstname','lastname']);
				},
				'participants'=>function($query){
					$query->select();
				},
			])->get(['id','user_id','course_id','former_id','supervisor_id','examiner_id','date','start_hour','start_minute','state','location']);
			return $mfexams;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
