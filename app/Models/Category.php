<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Category extends Model
{

    use HashidRouting,HasHashid,SoftDeletes, HasUserRelationships,HashIdAttribute;

		const MEDIAFORM = 0;
		const LRN = 1;
		const IIQ = 2;
		const DILE = 3;
		const MIUR = 4;

    protected $fillable = ['created_by','name','type','updated_by'];
		protected $appends = [
			'hashid'
		];

		public static function getTypes(){
			return [
				self::MEDIAFORM,
				self::LRN,
				self::IIQ,
				self::DILE,
				self::MIUR
			];
		}
		public function courses(){
        return $this->hasMany(Course::class);
    }
    public function scopeType($query,$type){
			return $query->where('type',$type);
		}


}
