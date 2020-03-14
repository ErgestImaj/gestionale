<?php

namespace App\Http\Controllers\Utenti;

use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtentiController extends Controller
{
	public function createUtente($type){

		$role = UserHelper::getUserRoleLabel($type);
		return view('utenti.create',[
			'type'=> $role
		]);
	}

	public function viewAdmins() {
		return view('utenti.index',[
			'type'=> User::$roles[User::ADMIN]
		]);
	}

	public function viewSegreteria() {
		return view('utenti.index',[
			'type'=> User::$roles[User::SEGRETERIA]
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
			'type'=> User::$roles[User::TUTOR]
		]);
	}


	public function viewInspectori() {
		return view('utenti.index',[
			'type'=> User::$roles[User::INVIGILATOR]
		]);
	}

	public function getUserType($type){
		if ( empty( $type ) ) return [];

		$role = UserHelper::getUserRole($type);

		if (empty($role)) return [];

		if(auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)){
			$users =  User::whereHas('roles',function ($query) use ($role){
				$query->where('name',$role);
			})->with(['userInfo'=>function($query){
				$query->select(['user_id','gender','fiscal_code']);
			},'user'=>function($query){
				$query->select(['id','firstname','lastname']);
			}])->get(['id','username','firstname','lastname','email','state','created_by']);
			return $users;
		}
		elseif (auth()->user()->hasRole(User::PARTNER)){

		}
	}
}
