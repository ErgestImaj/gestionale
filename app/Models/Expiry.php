<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Expiry extends Model
{
    use HasHashid,HashidRouting;
    public $timestamps = false;
    protected $table ='expiries';

    public function course(){
        return $this->hasMany(Course::class,'expiry');
    }
}
