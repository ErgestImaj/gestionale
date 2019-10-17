<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Category extends Model
{

    use HashidRouting,HasHashid,SoftDeletes;

    protected $fillable = ['user_id','name','updated_by'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }
    public function getUpdatedByUser(){
       return User::find($this->updated_by)->lastname;
    }


}
