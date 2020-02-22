<?php

namespace App\Policies;

use App\Models\Structure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StructurePolicy
{
    use HandlesAuthorization;
	/**
	 * Determine if the given user can create structures.
	 *
	 * @param  \App\User  $user
	 * @return bool
	 */
	public function create(User $user)
	{
		if (!in_array(request('type'),[Structure::TYPE_AFFILIATE,Structure::TYPE_MASTER,Structure::TYPE_PARTNER])) return false;
		if (request('type') == Structure::TYPE_PARTNER) return false;
	  if ((request('type')) == Structure::TYPE_MASTER && $user->hasRole(User::MASTER) ) return false;
	  return true;
	}
	/**
	 * @param $user
	 * @param $ability
	 * @return bool
	 */
	public function before($user, $ability){
		if ($user->isSuperAdmin() || $user->hasRole(User::ADMIN)){
			return true;
		}
	}
}
