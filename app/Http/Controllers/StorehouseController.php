<?php

namespace App\Http\Controllers;

use App\Models\Cart\CartCourseTransactions;
use App\Models\Course;
use Illuminate\Http\Request;

class StorehouseController extends Controller
{
    public function index(){
    	$courses  = Course::active()->get();
    	foreach ($courses as $course){
    		$course->aquisti = $course->ordersItems()->type()->sum('qty') ?? 0;
				$total = 0;
				foreach($course->ordersItems()->type()->get() as $order):

					$total += $order->qty*$order->price;

				endforeach;
    		$course->total = price_formater($total);
    		$course->admin = $course->cartCourseTransactions()->type(CartCourseTransactions::TYPE_ADMIN_ADDED)->sum('qty') ?? 0;
			}
    	return view('struture.storehouse.admin',compact('courses'));
		}
		public function indexPartner(){
    	return view('struture.storehouse.partner');
		}
		public function indexMaster(){
    	return view('struture.storehouse.master');
		}
		public function indexAffiliate(){
    	return view('struture.storehouse.affiliate');
		}
}
