<?php

namespace App\Http\Controllers\Structures;

use App\Http\Controllers\Controller;
use App\Http\Requests\StructureRequest;
use Illuminate\Http\Request;
use App\Models\Structure;


class StructureController extends Controller
{

	public function partnerIndex() {
		return view('struture.index',[
			'type'=> Structure::TYPE_PARTNER
		]);
	}

	public function masterIndex() {
		return view('struture.index',[
			'type'=> Structure::TYPE_MASTER
		]);
	}

	public function affiliatiIndex() {
		return view('struture.index',[
			'type'=> Structure::TYPE_AFFILIATE
		]);
	}

	// TODO: get by type
	public function getStructure(Request $request){

	    if (empty($request->type)) return null;
		return Structure::where('type',$request->type)->with('province')->latest()->get();
	}

	public function store (StructureRequest $request){
	    dd($request->all());
    }
}
