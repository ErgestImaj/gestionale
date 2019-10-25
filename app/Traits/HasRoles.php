<?php
namespace App\Traits;

use App\Models\UserGroups;
use Illuminate\Support\Arr;

trait HasRoles{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany(UserGroups::class,'user_user_groups','user_id','group_id');
    }

    /**
     *
     * @param string|array $roles
     */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');
    }
    /**
     * Check multiple roles
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {

        return null !== $this->roles()->whereIn('name', Arr::flatten($roles))->first();
    }
    /**
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {

        return null !== $this->roles()->where('name', strtolower($role))->first();
    }

    /**
     * @return first user role
     */
    public function getUserRole(){
        return $this->roles()->firstOrFail()->name;
    }

}
