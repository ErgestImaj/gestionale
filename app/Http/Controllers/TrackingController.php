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
				])->latest()->get(['id','user_id','lrn_exam_session_id','code','estimate_date','status','state','nr_certificates','send_date','expiry_date']);

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
					'redirect'=> route('tracking.list')
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tracking  $tracking
     * @return \Illuminate\Http\Response
     */
    public function edit(Tracking $tracking)
    {
    	   $tracking->structur =  $tracking->structure->firstname;
        return $tracking;
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Models\Tracking  $tracking
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Tracking $tracking,$status)
    {
        if (empty($status) || !in_array($status,[2,3,4])) 	return response( [
					'status' => 'error',
					'msg'    => trans( 'messages.error' )
				] );

        if ($status == 2){
					$tracking->update([
						'status'=>Tracking::STATUS_RECEIVED,
						'updated_by'=>auth()->id()
					]);
				}
        elseif($status == 3){
					$tracking->update([
						'status'=>Tracking::STATUS_NOT_RECEIVED,
						'updated_by'=>auth()->id()
					]);
				}
        elseif($status == 4){
					$tracking->update([
						'state'=>Tracking::NOT_ACTIVE,
						'updated_by'=>auth()->id()
					]);
				}
			return response( [
				'status' => 'success',
				'msg'    => trans( 'messages.success' ),
				'redirect'=> route('tracking.list')
			] );

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tracking  $tracking
     * @return \Illuminate\Http\Response
     */
    public function update(TrackingRequest $request, Tracking $tracking)
    {
			try {
				$tracking->fill($request->fillFormFields());
				$tracking->update();
				return response( [
					'status' => 'success',
					'msg'    => trans( 'messages.success' ),
					'redirect'=> route('tracking.list')
				] );

			}catch (\Exception $exception){
				logger('Cant update tracking: '.auth()->id().': '.$exception->getMessage());
				return response( [
					'status' => 'error',
					'msg'    => trans( 'messages.error' )
				] );
			}
    }


}
