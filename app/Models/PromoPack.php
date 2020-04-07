<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class PromoPack extends Model
{
	use HasUserRelationships, HasHashid, HashidRouting,
		SoftDeletes,HasStatus;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;

	protected $guarded = [];
	protected $casts = [
		'expiry_date'=>'datetime',
	];

	protected $table='courses_promo_packs';

  public function courses(){
  	return $this->belongsToMany(Course::class,'courses_promo_pack_courses','promo_pack_id','course_id')->withPivot('qty');
	}

}
