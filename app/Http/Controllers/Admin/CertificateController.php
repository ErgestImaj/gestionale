<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(){
     return Certificate::with([
     	'user'=>function($query){
     	 	$query->select(['id','firstname','lastname']);
			},
			 'examSession'=>function($query){
				 $query->select(['id','course_id','date','user_id']);
			 },
			 'examSession.course'=>function($query){
				 $query->select(['id','name']);
			 },
			 'examSession.owner'=>function($query){
				 $query->select(['id','firstname']);
			 }
		 ])->get(['type','user_id','exam_session_id','date_issue']);

		}
}
