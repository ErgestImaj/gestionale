<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\Job;
use Illuminate\Support\Facades\Cache;

class DocumentTypesController extends Controller
{
	public function getDocumentTypes(){
		return [
			'document_types'=>Cache::rememberForever('document_types',function (){
				return DocumentType::all();
			}),
			'jobs'=>Cache::rememberForever('jobs',function (){
				return Job::all();
			})
		];
	}
}
