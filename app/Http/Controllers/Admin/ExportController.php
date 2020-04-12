<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exams\LrnExamSession;
use App\Models\Structure;
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
					$redirect = route('general.storehouse.structures.export',[$request->input('type'),$request->input('from_date')??'',$request->input('to_date')??'',$request->input('structure')??'']);
					break;
			}

    	return response([
    		'redirect'=>$redirect
			]);
		}
}
