<?php

namespace App\Models\Cart;

use App\Models\Course;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseRequestItems extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships;

	protected $table = 'courses_courses_request_items';
	protected $guarded = [];

	const TYPE_COURSE = 0;
	const TYPE_PROMO_PACK = 1;

	const STATUS_OPEN = 1;
	const STATUS_CLOSED = 0;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	protected $casts = [
		'updated' => 'datetime',
		'created' => 'datetime',

	];
	protected $appends = ['hashid'];

	public function scopeType($query){
		return $query->where('type',self::TYPE_COURSE);
	}
	public function course(){
		return $this->belongsTo(Course::class,'item_id','id');
	}

}
