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
		protected $appends = [
			'hashid'
		];

		public function getHashidAttribute()
		{
			return $this->hashid();
		}
    public function course(){
        return $this->hasMany(Course::class,'expiry');
    }
}
