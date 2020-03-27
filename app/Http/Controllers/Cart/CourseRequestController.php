<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\CourseRequest;
use Illuminate\Http\Request;

class CourseRequestController extends Controller
{
    public function index(){

    	$courserequests = CourseRequest::with([
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
}
