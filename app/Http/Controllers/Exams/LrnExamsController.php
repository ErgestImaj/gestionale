<?php

namespace App\Http\Controllers\Exams;

use App\Events\ExamSectionCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamSectionRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Exams\LrnExamSession;
use App\Providers\NewExamSectionNotification;
use Illuminate\Http\Request;

class LrnExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type){
    	return view('exams.index',compact('type'));
		}
    public function filter()
    {
       $lrnexams =  LrnExamSession::latest()->with([
        	'owner'=>function($query){
        	 $query->select(['id','firstname']);
					},
					'course'=>function($query){
						$query->select(['id','name']);
					},
					'examiner'=>function($query){
						$query->select(['id','firstname','lastname']);
					},
					'invigilator'=>function($query){
						$query->select(['id','firstname','lastname']);
					},
					'participants'=>function($query){
						$query->select();
					},
				])->get(['id','user_id','course_id','invigilator_id','examiner_id','fast_track','date','start_hour','start_minute','state','location']);

       return $lrnexams;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        return view('exams.create',compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamSectionRequest $request)
    {

			try {
				$exam = new  LrnExamSession;
				$exam->fill($request->fillFormFields());
				$exam->save();
				event(new ExamSectionCreated($exam,auth()->user(),$exam->examiner,$exam->invigilator));
				return response([
					'status' => 'success',
					'msg' => trans('messages.success'),
					'redirect'=>route('exams.lrn.index',Category::LRN)
				]);
			} catch (\Exception $exception) {
				logger('Exam section error: '.$exception->getMessage());
				return response([
					'status' => 'error',
					'msg' => trans('messages.error')
				]);
			}
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
