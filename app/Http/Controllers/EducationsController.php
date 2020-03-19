<?php

namespace App\Http\Controllers;

use App\Models\Educations;
use Illuminate\Support\Facades\Cache;

class EducationsController extends Controller
{
	  public function getEducations(){
			return Cache::rememberForever('educations',function (){
					return Educations::all();
				});
		}
}
