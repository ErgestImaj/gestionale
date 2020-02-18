<?php

namespace App\Http\Controllers\Utenti;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Utenti extends Controller
{
    public function CreateEsaminatore() {
		return view('utenti.create',[
			'type'=> 'esaminatore'
		]);
	}

	public function CreateDocente() {
		return view('utenti.create',[
			'type'=> 'docente'
		]);
	}
	
	public function CreateSupervisore() {
		return view('utenti.create',[
			'type'=> 'supervisore'
		]);
	}

	public function CreateFormatori() {
		return view('utenti.create',[
			'type'=> 'formatori'
		]);
	}
	
	public function CreateStudenti() {
		return view('utenti.create',[
			'type'=> 'studenti'
		]);
	}

	public function CreateTutor() {
		return view('utenti.create',[
			'type'=> 'tutor'
		]);
	}
	public function CreateInspector() {
		return view('utenti.create',[
			'type'=> 'inspector'
		]);
	}
	public function ViewEsaminatore() {
		return view('utenti.index',[
			'type'=> 'esaminatore'
		]);
	}

	public function ViewDocente() {
		return view('utenti.index',[
			'type'=> 'docente'
		]);
	}
	
	public function ViewSupervisore() {
		return view('utenti.index',[
			'type'=> 'supervisore'
		]);
	}

	public function ViewFormatori() {
		return view('utenti.index',[
			'type'=> 'formatori'
		]);
	}
	
	public function ViewStudenti() {
		return view('utenti.index',[
			'type'=> 'studenti'
		]);
	}

	public function ViewTutori() {
		return view('utenti.index',[
			'type'=> 'tutor'
		]);
	}

	
	public function ViewInspectori() {
		return view('utenti.index',[
			'type'=> 'inspector'
		]);
	}
}
