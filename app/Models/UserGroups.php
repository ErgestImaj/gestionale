<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    //
    /**
     * In this model will be specified the rules for users
     * The name comes from DB which is already with data
     * We are adopting it with laravel
     * Bad coding conventions, i know, it comes from DB
     */
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'user_groups';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(){
        return $this->belongsToMany(User::class,'user_user_groups','user_id','group_id');
    }


}
