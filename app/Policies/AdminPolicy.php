<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can be updated by the user.
     *
     * @param  \App\Model\User  $user
     * @return bool
     */
    public function update(User $auth ,User $user)
    {

      return $user->id === $auth->id;


    }

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability){
        if ($user->isSuperAdmin()){
            return true;
        }
    }



}
