<?php

namespace App\Models;

use App\Notifications\InvitationEmailNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class User extends Authenticatable
{
    use Notifiable, HasHashid, HashidRouting,SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    const  IS_ACTIVE = 1;
    const  NOT_ACTIVE = 0;

    #user roles
    const SUPERADMIN = 'superadmin';
    const ADMIN = 'admin';
    const SEGRETERIA = 'segreteria';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug','username','firstname','lastname', 'email', 'password',
        'state','activation','created_by','updated_by','locked',
        'avatar'
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
        'deleted_at'         => 'datetime',
        'last_login'         => 'datetime',
        'created'            => 'datetime',
        'state'              => 'boolean'

    ];
    protected $appends = ['avatar_url'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne(UsersInfo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany(UserGroups::class,'user_user_groups','user_id','group_id');
    }

    public function userRole(){
        return $this->roles()->firstOrFail()->name;
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

    /**
     * Check if user is superadmin
     * @return bool
     */
    public function isSuperAdmin(){
        return $this->hasRole(self::SUPERADMIN);
    }

    /**
     * Display admin name: firstname lastname.
     *
     * @var string
     */
    public function getFullNameAttribute()
    {
        return $this->firstname.' '.$this->lastname;
    }

    /**
     * @return avatar url
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar)
            return Storage::url('avatars/'.$this->avatar);
        return Storage::url('user-avatar.png');
    }

    /**
     * get user status
     * @return bool
     */
    public function isActive(){
        return $this->state == 1;
    }
    /**
     * @return int
     */
    public function disableUser(){
        $this->locked = Carbon::now()->toDateTimeString();
        $this->locked_by = Auth::id();
        $this->state = self::NOT_ACTIVE;
    }

    /**
     * @return int
     */
    public function activeUser(){
        return $this->state = self::IS_ACTIVE;
    }
    /**
     * Get image thumb path.
     *
     * @var string
     */
    public function removeAvatar()
    {
        if (!empty($this->avatar) ) {
            Storage::delete('public/avatars/'.$this->avatar);
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new InvitationEmailNotification($token));
    }


    public function categories(){
        return $this->hasMany(Category::class);
    }

}
