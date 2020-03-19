<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Support\Facades\Cache;

class DocumentTypesController extends Controller
{
	public function getDocumentTypes(){
		return Cache::rememberForever('document_types',function (){
			return DocumentType::all();
		});
	}
}
