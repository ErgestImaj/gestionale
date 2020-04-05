<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\CourseTransactions;
use App\Models\Cart\CourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseRequestController extends Controller
{
    public function index(){

    	$courserequests = CourseRequest::latest()->with([
    																	'items'=>function($query){
    		                               $query->type()->get(['courses_request_id','courses_request_id','type','qty','price','status']);
																			},
				                               'items.course'=>function($query){
																				 $query->select(['id','name']);
																			 },
																				'structure'=>function($query){
																				 $query->select(['id','legal_name']);
																			 },
																			'parentStructure'=>function($query){
																				 $query->select(['id','legal_name']);
																			 },
			                              ])->get();
			return $courserequests;
		}
		public function confirmCoursesRequest(CourseRequest $courseRequest){
    	DB::beginTransaction();
			try {

				foreach ($courseRequest->items as $item):

					$parent_transaction = CourseTransactions::create(
						[
							'user_id'=>$courseRequest->parent_structure_id,
							'course_id'=>$item->item_id,
							'qty'=>$item->qty*-1,
							'order_id'=>0,
							'paypal_transaction_id'=>0,
							'parent_transaction_id'=>0,
							'type'=>CourseTransactions::TYPE_COURSE_REQUEST,
							'state'=>1,
							'created_by'=>auth()->id(),
							'updated_by'=>auth()->id(),
						]
					);
				 CourseTransactions::create(
						[
							'user_id'=>$courseRequest->structure_id,
							'course_id'=>$item->item_id,
							'qty'=>$item->qty,
							'order_id'=>0,
							'paypal_transaction_id'=>0,
							'parent_transaction_id'=>$parent_transaction->id,
							'type'=>CourseTransactions::TYPE_COURSE_REQUEST,
							'state'=>1,
							'created_by'=>auth()->id(),
							'updated_by'=>auth()->id(),
						]
					);
				endforeach;
				$courseRequest->update([
					'status'=>CourseRequest::STATUS_CLOSED
				]);
				DB::commit();
				return response([
					'status' => 'success',
					'msg' => trans('messages.success')
				]);
			} catch (\Exception $exception) {
				DB::rollBack();
				logger($exception->getMessage());
				return response([
					'status' => 'error',
					'msg' => trans('messages.error')
				]);
			}
		}
		public function blockCoursesRequest(CourseRequest $courseRequest){
			try {
				$courseRequest->update([
					'status'=>CourseRequest::STATUS_BLOCKED
				]);
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
		public function unBlockCoursesRequest(CourseRequest $courseRequest){
			try {
				$courseRequest->update([
					'status'=>CourseRequest::STATUS_PENDING
				]);
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
}
