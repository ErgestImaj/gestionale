<?php

namespace App\Models\Cart;

use App\Models\Structure;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseRequest extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships;

	protected $table = 'courses_courses_requests';
	protected $guarded = [];

	const STATUS_OPEN = 0;
	const STATUS_PENDING = 1;
	const STATUS_CLOSED = 2;
	const STATUS_BLOCKED = 3;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	protected $casts = [
		'updated' => 'datetime',
		'date' => 'datetime',
		'created' => 'datetime',

	];
	protected $appends = ['hashid'];

	public function structure(){
		return $this->belongsTo(Structure::class,'structure_id','id');
	}
	public function parentStructure(){
		return $this->belongsTo(Structure::class,'parent_structure_id','id');
	}
	public function items(){
		return $this->hasMany(CourseRequestItems::class,'courses_request_id','id');
	}
}
