<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart\CourseRequest;
use App\Models\Cart\FastTrack;
use App\Models\Cart\Orders;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Exams\LrnExamSession;
use App\Models\Structure;
use App\Models\Tracking;
use App\Models\User;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index(Request $request){
      $redirect = url('/');
      switch ($request->input('model')){
				case Structure::MODEL:
					$redirect = route('structure.export',[$request->input('type'),$request->input('from_date')??'',$request->input('to_date')??'']);
					break;
				case LrnExamSession::MODEL:
					$redirect = route('exams.lrn.export',[$request->input('type'),$request->input('from_date')??'',$request->input('to_date')??'']);
					break;
				case User::MODEL:
					$redirect = route('utenti.export',[$request->input('type'),$request->input('from_date')??'',$request->input('to_date')??'']);
					break;
				case 'storehouse':
					$redirect = route('general.storehouse.structures.export',[$request->input('type'),$request->input('structure')??'']);
					break;
				case Tracking::MODEL:
					$redirect = route('tracking.export',[$request->input('from_date')??0,$request->input('to_date') ?? 0,$request->input('structure')??0]);
					break;
				case FastTrack::MODEL:
					$redirect = route('cart.fasttrack.export',[$request->input('from_date')??0,$request->input('to_date') ?? 0,$request->input('structure')??0]);
					break;
				case CourseRequest::MODEL:
					$redirect = route('cart.course.requests.export',[$request->input('from_date')??0,$request->input('to_date') ?? 0,$request->input('structure')??0]);
					break;
				case Orders::MODEL:
					$redirect = route('cart.orders.export',[$request->input('from_date')??0,$request->input('to_date') ?? 0,$request->input('structure')??0]);
					break;
				case Certificate::MODEL:
					$redirect = route('admin.certificates.export',[$request->input('from_date')??0,$request->input('to_date') ?? 0,$request->input('course')??0]);
					break;
				case Course::MODEL:
					$redirect = route('admin.courses.export',[$request->input('course')??0,$request->input('category') ?? '']);
					break;
			}

    	return response([
    		'redirect'=>$redirect
			]);
		}
}
