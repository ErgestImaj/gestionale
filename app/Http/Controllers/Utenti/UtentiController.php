<?php

namespace App\Http\Controllers\Utenti;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtentiController extends Controller
{
	public function createStudenti() {

		return view('utenti.create',[
			'type'=> User::$roles[User::STUDENTI]
		]);
	}

   public function  createEsaminatore() {
		return view('utenti.create',[
			'type'=> User::$roles[User::ESAMINATORE]
		]);
	}

	public function  createDocente() {
		return view('utenti.create',[
			'type'=> User::$roles[User::DOCENTE]
		]);
	}

	public function  createSupervisore() {
		return view('utenti.create',[
			'type'=> User::$roles[User::SUPERVISORE]
		]);
	}

	public function  createFormatori() {
		return view('utenti.create',[
			'type'=> User::$roles[User::FORMATORE]
		]);
	}

	public function  createTutor() {
		return view('utenti.create',[
			'type'=> User::$roles[User::TUTOR]
		]);
	}
	public function  createInspector() {
		return view('utenti.create',[
			'type'=> User::$roles[User::TUTOR]
		]);
	}
	public function viewEsaminatore() {
		return view('utenti.index',[
			'type'=> User::$roles[User::ESAMINATORE]
		]);
	}

	public function viewDocente() {
		return view('utenti.index',[
			'type'=> User::$roles[User::DOCENTE]
		]);
	}

	public function viewSupervisore() {
		return view('utenti.index',[
			'type'=> User::$roles[User::SUPERVISORE]
		]);
	}

	public function viewFormatori() {
		return view('utenti.index',[
			'type'=> User::$roles[User::FORMATORE]
		]);
	}

	public function viewStudenti() {
		return view('utenti.index',[
			'type'=> User::$roles[User::STUDENTI]
		]);
	}

	public function viewTutori() {
		return view('utenti.index',[
			'type'=> User::$roles[User::FORMATORE]
		]);
	}


	public function viewInspectori() {
		return view('utenti.index',[
			'type'=> User::$roles[User::INVIGILATOR]
		]);
	}

	public function getUserType($type){
		if ( empty( $type ) ) return [];
		$role = '';
		switch ($type){
			case User::$roles[User::STUDENTI]:
				$role = User::STUDENTI;
				break;
			case User::$roles[User::DOCENTE]:
				$role = User::DOCENTE;
				break;
			case User::$roles[User::FORMATORE]:
				$role = User::FORMATORE;
				break;
			case User::$roles[User::SUPERVISORE]:
				$role = User::SUPERVISORE;
				break;
			case User::$roles[User::ESAMINATORE]:
				$role = User::ESAMINATORE;
				break;
			case User::$roles[User::INVIGILATOR]:
				$role = User::INVIGILATOR;
				break;
		}
		if (empty($role)) return [];

		if(auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)){
			$users =  User::whereHas('roles',function ($query) use ($role){
				$query->where('name',$role);
			})->with(['userInfo'=>function($query){
				$query->select(['user_id','gender','fiscal_code']);
			}])->get(['id','username','firstname','lastname','email','state']);
			return $users;
		}
		elseif (auth()->user()->hasRole(User::PARTNER)){

		}
	}
}
