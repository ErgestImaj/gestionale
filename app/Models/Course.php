<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Course extends Model
{
    use HasHashid,HashidRouting;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $table = 'courses_courses';
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


//    protected $casts = [
//        'email_verified_at'  => 'datetime',
//        'activation'         => 'datetime',
//        'locked'             => 'datetime',
//        'deleted_at'         => 'datetime',
//        'last_login'         => 'datetime',
//        'created'            => 'datetime',
//        'state'              => 'boolean'
//
//    ];

    public function category(){
      return  $this->belongsTo(Category::class,'category_id');
    }
}
