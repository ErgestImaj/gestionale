<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;
    /**
     * Determine if the given user can edit the user.
     *
     * @param  \App\Model\User  $user
     * @return bool
     */
    public function edit(User $auth, User $user){

        if ($user->id === $auth->id) return true;
        if ($user->hasRole(User::ADMIN)) return false;
        if ($auth->hasRole(User::ADMIN) && !$user->hasRole(User::ADMIN)) return true;
        return false;
    }
    /**
     * Determine if the given user can be updated by the user.
     *
     * @param  \App\Model\User  $user
     * @return bool
     */
    public function update(User $auth ,User $user)
    {

      if($user->id === $auth->id){
          return true;
      }elseif ($user->hasRole(User::ADMIN)){
          return false;
      }elseif ($auth->hasRole(User::ADMIN) && !$user->hasRole(User::ADMIN)){
          return true;
      };
      return false;


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
