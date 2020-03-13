<?php

namespace App\Http\Controllers\Utenti;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtentiController extends Controller
{
	public function createStudenti() {
		return view('utenti.create',[
			'type'=> 'studenti'
		]);
	}
   public function  createEsaminatore() {
		return view('utenti.create',[
			'type'=> 'esaminatore'
		]);
	}

	public function  createDocente() {
		return view('utenti.create',[
			'type'=> 'docente'
		]);
	}

	public function  createSupervisore() {
		return view('utenti.create',[
			'type'=> 'supervisore'
		]);
	}

	public function  createFormatori() {
		return view('utenti.create',[
			'type'=> 'formatori'
		]);
	}

	public function  createTutor() {
		return view('utenti.create',[
			'type'=> 'tutor'
		]);
	}
	public function  createInspector() {
		return view('utenti.create',[
			'type'=> 'inspector'
		]);
	}
	public function viewEsaminatore() {
		return view('utenti.index',[
			'type'=> 'esaminatore'
		]);
	}

	public function viewDocente() {
		return view('utenti.index',[
			'type'=> 'docente'
		]);
	}

	public function viewSupervisore() {
		return view('utenti.index',[
			'type'=> 'supervisore'
		]);
	}

	public function viewFormatori() {
		return view('utenti.index',[
			'type'=> 'formatori'
		]);
	}

	public function viewStudenti() {
		return view('utenti.index',[
			'type'=> 'studenti'
		]);
	}

	public function viewTutori() {
		return view('utenti.index',[
			'type'=> 'tutor'
		]);
	}


	public function viewInspectori() {
		return view('utenti.index',[
			'type'=> 'inspector'
		]);
	}
}
