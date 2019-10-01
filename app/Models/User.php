<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

}
