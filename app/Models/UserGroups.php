<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class UserGroups extends Model
{
    //
    use HasHashid,HashidRouting;
    /**
     * In this model will be specified the rules for users
     * The name comes from DB which is already with data
     * We are adopting it with laravel
     * Bad coding conventions, i know, it comes from DB
     */
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    const  IS_ACTIVE = 1;
    const  NOT_ACTIVE = 0;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'user_groups';


    protected $guarded =[];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class,'user_user_groups','user_id','group_id');
    }

    // additional helper relation for the count

    public function usersCount()
    {
        return $this->belongsToMany(User::class,'user_user_groups','group_id','user_id')
            ->selectRaw('count(user_id) as aggregate')
            ->groupBy('pivot_group_id');
    }

// accessor for easier fetching the count
    public function getUsersCountAttribute()
    {
        if ( ! array_key_exists('usersCount', $this->relations)) $this->load('usersCount');

        $related = $this->getRelation('usersCount')->first();

        return ($related) ? $related->aggregate : 0;
    }
    /**
     * get group status
     * @return bool
     */
    public function isActive(){
        return $this->state == 1;
    }

    /**
     * @return int
     */
    public function disableGroup(){
        $this->locked = Carbon::now()->toDateTimeString();
        $this->locked_by = Auth::id();
        $this->state = self::NOT_ACTIVE;
    }

    /**
     * @return int
     */
    public function activeGroup(){
        $this->locked = null;
        $this->state = self::IS_ACTIVE;
    }

    /**
     * Add the updated by
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function($group)
        {
            $group->updated_by = Auth::id();
        });
    }


}
