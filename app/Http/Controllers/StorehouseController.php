<?php

namespace App\Http\Controllers;

use App\Models\Cart\CartCourseTransactions;
use App\Models\Course;
use App\Models\User;
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
		public function personal(){
    	/*
    	 * structure_course_transactions = auth()->user()->cartCourseTransactions;
    	 */

			$user = User::find(37);
			$transactions  = $user->cartCourseTransactions;
			foreach ($transactions as $transaction):
				$transaction->available_qty = $transaction->sum('qty');
				$transaction->purchased_qty = $transaction->type(CartCourseTransactions::TYPE_COURSE_PURCHASE)->where('order_id','<>',0)->sum('qty');
				$transaction->refunded_qty = $transaction->type(CartCourseTransactions::TYPE_COURSE_REFUND)->sum('qty');
				$transaction->assigned_qty = abs($transaction->type(CartCourseTransactions::TYPE_COURSE_REQUEST)->sum('qty'));
				$transaction->distributed_qty = abs($transaction->type(CartCourseTransactions::TYPE_COURSE_DISTRIBUTE)->sum('qty')) - abs($transaction->type(CartCourseTransactions::TYPE_COURSE_PURCHASE)->where('order_id',0)->sum('qty'));
				$transaction->admin_qty = $transaction->type(CartCourseTransactions::TYPE_ADMIN_ADDED)->sum('qty');
			endforeach;
			return view('struture.storehouse.personal',compact('transactions'));
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
