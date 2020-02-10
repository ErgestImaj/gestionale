<?php

namespace App\Http\Controllers\Structures;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Structure;


class StructureController extends Controller
{
	public function index() {
		return;
	}

	public function partnerIndex() {
		return view('struture.index',[
			'type'=> 'partner'
		]);
	}

	public function masterIndex() {
		return view('struture.index',[
			'type'=> 'master'
		]);
	}

	public function affiliatiIndex() {
		return view('struture.index',[
			'type'=> 'affiliati'
		]);
	}

	// TODO: get by type
	public function all(){
		$stru = Structure::all();
		return $stru;
	}
}
