<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug','username','firstname','lastname', 'email', 'password',
        'state','activation','created_by','updated_by','locked',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at'  => 'datetime',
        'activation'         => 'datetime',
        'locked'             => 'datetime',
        'state'              => 'boolean'

    ];

    /**
     * Bootstrap any application services.
     */
    public static function boot()
    {
        parent::boot();

        // Create username and slug when creating list.
        static::creating(function ($item) {
            // Create new uid
            $uid = uniqid();
            while (User::where('username', '=', $uid)->count() > 0) {
                $uid = uniqid();
            }
            $item->username = $uid;
            $item->slug = strtolower($uid);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne(UsersInfo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userGroups(){
        return $this->belongsToMany(UserGroups::class,'user_user_groups','user_id','group_id');
    }

    /**
     *
     * @param string|array $roles
     */
    public function authorizeRoles($roles)
    {
        if(!$this->state){
            Auth::logout();
            abort(401, 'Your account is disabled.');
        }
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

        return null !== $this->userGroups()->whereIn('name', Arr::flatten($roles))->first();
    }
    /**
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {

        return null !== $this->userGroups()->where('name', strtolower($role))->first();
    }

    public function getUserRole(){
        return $this->userGroups()->firstOrFail()->name;
    }

}
