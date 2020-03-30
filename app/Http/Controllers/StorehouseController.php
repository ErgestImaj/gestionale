<?php

namespace App\Http\Controllers;

use App\Models\Cart\CartCourseTransactions;
use App\Models\Course;
use Illuminate\Http\Request;

class StorehouseController extends Controller
{
    public function index(){
    	$courses  = Course::active()->get();
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
