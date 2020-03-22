<?php

namespace App\Models;

use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Category extends Model
{

    use HashidRouting,HasHashid,SoftDeletes, HasUserRelationships;

    protected $fillable = ['created_by','name','updated_by'];
		protected $appends = [
			'hashid'
		];

		public function getHashidAttribute()
		{
			return $this->hashid();
		}

		public function courses(){
        return $this->hasMany(Course::class);
    }


}
