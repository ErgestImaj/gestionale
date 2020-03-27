<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\FastTrack;
use Illuminate\Http\Request;

class FastTrackController extends Controller
{
    public function index(){
         return FastTrack::with('user')->get();
		}
}
