<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoPack;
use Illuminate\Http\Request;

class PromoPackController extends Controller
{
    public function index(){

    	return PromoPack::with(['courses'=>function($query){
    		$query->select(['id','name']);
			}])->get();

		}
}
