<?php

namespace App\Http\Controllers\Structures;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseTransactionRequest;
use App\Models\Cart\CourseTransactions;
use App\Models\Structure;
use Illuminate\Http\Request;

class CourseTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Structure $structure)
		{
			return CourseTransactions::whereHas('owner',function ($query) use ($structure){
				 $query->where('user_id', $structure->user_id);
			})->type(CourseTransactions::TYPE_ADMIN_ADDED)->with([
				'course'=>function($query){
				$query->select(['id','name']);
				},
				'user'=>function($query){
					$query->select(['id','firstname','lastname']);
				},
			])->latest()->get();
		}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Structure $structure,CourseTransactionRequest $request)
    {

			try {
				$transaction = new CourseTransactions;
				$transaction->user_id = $structure->user_id;
				$transaction->fill($request->fillFormFileds());
				$transaction->save();
				return response([
					'status' => 'success',
					'msg' => trans('messages.success'),
				]);
			}catch (\Exception $exception){
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseTransactions $transaction)
    {
			try {
				$transaction->delete();
				return response([
					'status' => 'success',
					'msg' => trans('messages.delete_msg', ['record' => 'record'])
				]);
			} catch (\Exception $exception) {
				return response([
					'status' => 'error',
					'msg' => trans('messages.error')
				]);
			}

    }
}
