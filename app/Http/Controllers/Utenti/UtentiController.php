<?php

namespace App\Http\Controllers\Utenti;

use App\Helpers\Upload;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MediaformUsersRequest;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UtentiController extends Controller
{
	public function createUtente($type)
	{

		$role = UserHelper::getUserRoleLabel($type);
		return view('utenti.create', [
			'type' => $role
		]);
	}

	public function viewAdmins()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::ADMIN]
		]);
	}

	public function viewSegreteria()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::SEGRETERIA]
		]);
	}

	public function viewEsaminatore()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::ESAMINATORE]
		]);
	}

	public function viewDocente()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::DOCENTE]
		]);
	}

	public function viewSupervisore()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::SUPERVISORE]
		]);
	}

	public function viewFormatori()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::FORMATORE]
		]);
	}

	public function viewStudenti()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::STUDENTI]
		]);
	}

	public function viewTutori()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::TUTOR]
		]);
	}

	public function viewInspectori()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::ISPETTORI]
		]);
	}

	public function viewInvigilatori()
	{
		return view('utenti.index', [
			'type' => User::$roles[User::INVIGILATOR]
		]);
	}

	public function getUserType($type)
	{
		if (empty($type)) return [];

		$role = UserHelper::getUserRole($type);

		if (empty($role)) return [];

		if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)) {
			return User::whereHas('roles', function ($query) use ($role) {
				$query->where('name', $role);
			})->with(['userInfo' => function ($query) {
				$query->select(['user_id', 'gender', 'fiscal_code', 'lrn_user']);
			}, 'user' => function ($query) {
				$query->select(['id', 'firstname', 'lastname']);
			}])->get(['id', 'username', 'firstname', 'lastname', 'email', 'state', 'created_by']);

		} elseif (auth()->user()->hasRole(User::PARTNER)) {
			# to do
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param MediaformUsersRequest $request
	 * @return Response
	 */
	public function storeBasicUser(MediaformUsersRequest $request)
	{

     $type = $request->input('type');
		if (empty($type)){
			return response( [
				'status' => 'error',
				'msg'    => trans( 'messages.error' )
			] );
		}
		try {

			$avatar = '';
			if ($request->hasFile('image')) {
				if ($request->file('image')->isValid()) {
					$upload = new Upload();
					$avatar = $upload->upload($request->file('image'), 'public/avatars')->resize(100, 100)->getData();
					$avatar = $avatar['basename'];
				}
			}
			$user = User::forceCreate([
				'firstname' => $request->input('first_name'),
				'lastname' => $request->input('last_name'),
				'email' => $request->input('email'),
				'password' => Hash::make($request->input('password')),
				'avatar' => $avatar
			]);

			$user->roles()->sync(UserGroups::where('name',
				array_search( $type,User::$roles)
				)->firstOrFail()->id);

			if ( $type == User::$roles[User::TUTOR]) {
				$user->tutorCourses()->sync($request->input('corsi'));
			}

		}catch (\Exception $exception){
			logger('Cant create user with role  '.$type.': '.$exception->getMessage());
			return response( [
				'status' => 'error',
				'msg'    => trans( 'messages.error' )
			] );
		}
		return response( [
			'status' => 'success',
			'msg'    => trans( 'messages.success' )
		] );
	}
}
