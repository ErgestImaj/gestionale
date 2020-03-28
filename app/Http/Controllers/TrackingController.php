<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackingRequest;
use App\Models\Exams\LrnExamSession;
use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tracking::active()->with([
					'lrnexam'=>function($query){
						$query->select(['id','course_id','date']);
					},
					'lrnexam.course'=>function($query){
						$query->select(['id','name']);
					},
					'structure'=>function($query){
						$query->select(['id','firstname']);
					},
				])->get(['user_id','lrn_exam_session_id','code','estimate_date','status','state','nr_certificates','send_date','expiry_date']);

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

    public function getLrnExamSessions(){

    	return LrnExamSession::with([
				'owner'=>function($query){
					$query->select(['id','firstname']);
				},
				'course'=>function($query){
					$query->select(['id','name']);
				}
			])->get(['id','user_id','course_id','date']);

		}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrackingRequest $request)
    {
			try {
        $tracking = new Tracking;
				$tracking->created_by = auth()->id();
			  $tracking->fill($request->fillFormFields());
				$tracking->save();
				return response( [
					'status' => 'success',
					'msg'    => trans( 'messages.success' ),
					'redirect'=> route('tracking.index')
				] );

			}catch (\Exception $exception){
				logger('Cant create tracking: '.auth()->id().': '.$exception->getMessage());
				return response( [
					'status' => 'error',
					'msg'    => trans( 'messages.error' )
				] );
			}
		}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tracking  $tracking
     * @return \Illuminate\Http\Response
     */
    public function show(Tracking $tracking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tracking  $tracking
     * @return \Illuminate\Http\Response
     */
    public function edit(Tracking $tracking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tracking  $tracking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tracking $tracking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tracking  $tracking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracking $tracking)
    {
        //
    }
}
