<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    //
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'users_userinfo';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dirth_date'                  => 'datetime',
        'document_expire_date'        => 'datetime',
        'high_school_diploma_date'    => 'datetime',
        'university_degree_date'      => 'datetime',
        'locked'                      => 'datetime',
        'state'                       => 'boolean'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
