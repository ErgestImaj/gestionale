<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\FastTrack;

class FastTrackController extends Controller
{
    public function index(){
         return FastTrack::with(['user'=>function($query){
         	 $query->select('id','firstname');
				 }])->latest()->get();
		}
}
