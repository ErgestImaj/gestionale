<?php

namespace App\Http\Controllers\Utenti;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtentiController extends Controller
{
	public function createStudenti() {
		return view('utenti.create',[
			'type'=> User::STUDENTI
		]);
	}

   public function  createEsaminatore() {
		return view('utenti.create',[
			'type'=> User::ESAMINATORE
		]);
	}

	public function  createDocente() {
		return view('utenti.create',[
			'type'=> User::DOCENTE
		]);
	}

	public function  createSupervisore() {
		return view('utenti.create',[
			'type'=> User::SUPERVISORE
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
			'type'=> 'ispettore'
		]);
	}
	public function viewEsaminatore() {
		return view('utenti.index',[
			'type'=> User::ESAMINATORE
		]);
	}

	public function viewDocente() {
		return view('utenti.index',[
			'type'=> User::DOCENTE
		]);
	}

	public function viewSupervisore() {
		return view('utenti.index',[
			'type'=> User::SUPERVISORE
		]);
	}

	public function viewFormatori() {
		return view('utenti.index',[
			'type'=> 'formatori'
		]);
	}

	public function viewStudenti() {
		return view('utenti.index',[
			'type'=> User::STUDENTI
		]);
	}

	public function viewTutori() {
		return view('utenti.index',[
			'type'=> 'tutor'
		]);
	}


	public function viewInspectori() {
		return view('utenti.index',[
			'type'=> 'ispettore'
		]);
	}

	public function getUserType($type){
		if ( empty( $type ) ) return [];
		$role = '';
		switch ($type){
			case User::STUDENTI:
				$role = User::STUDENTI;
				break;
			case User::DOCENTE:
				$role = User::DOCENTE;
				break;
			case 'formatori':
				$role = User::FORMATORE;
				break;
			case User::SUPERVISORE:
				$role = User::SUPERVISORE;
				break;
			case User::ESAMINATORE:
				$role = User::ESAMINATORE;
				break;
			case 'ispettore':
				$role = User::INVIGILATOR;
				break;
		}
		if (empty($role)) return [];

		if(auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)){
			$users =  User::whereHas('roles',function ($query) use ($role){
				$query->where('name',$role);
			})->with(['userInfo'=>function($query){
				$query->select(['user_id','gender','fiscal_code']);
			}])->get(['id','username','firstname','lastname','email']);
			return $users;
		}
		elseif (auth()->user()->hasRole(User::PARTNER)){

		}
	}
}
