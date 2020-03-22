<?php

namespace App\Http\Controllers;

use App\Models\Educations;
use App\Models\UsersInfo;
use Illuminate\Support\Facades\Cache;

class EducationsController extends Controller
{
	  public function getEducations(){
			return Cache::rememberForever('educations',function (){
					return Educations::all();
			});
		}
		public function userTypeLabels(){
	  	return Cache::rememberForever('user_types',function (){
				return [
							['id'=>UsersInfo::TYPE_MF,'name'=>UsersInfo::$typeLabels[UsersInfo::TYPE_MF]],
							['id'=>UsersInfo::TYPE_LRN,'name'=>UsersInfo::$typeLabels[UsersInfo::TYPE_LRN]],
							['id'=>UsersInfo::TYPE_IIQ,'name'=>UsersInfo::$typeLabels[UsersInfo::TYPE_IIQ]],
							['id'=>UsersInfo::TYPE_MIUR,'name'=>UsersInfo::$typeLabels[UsersInfo::TYPE_MIUR]],
							['id'=>UsersInfo::TYPE_DILE,'name'=>UsersInfo::$typeLabels[UsersInfo::TYPE_DILE]],
				];
			});
		}
}
