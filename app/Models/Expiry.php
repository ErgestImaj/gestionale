<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Expiry extends Model
{
    use HasHashid,HashidRouting,HashIdAttribute;
    public $timestamps = false;
    protected $table ='expiries';
		protected $appends = [
			'hashid'
		];

    public function course(){
        return $this->hasMany(Course::class,'expiry');
    }
}
