<?php

namespace App\Models\Cart;

use App\Models\Structure;
use App\Traits\DatabaseDateFomat;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseRequest extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,DatabaseDateFomat;

	protected $table = 'courses_courses_requests';
	protected $guarded = [];

	const STATUS_OPEN = 0;
	const STATUS_PENDING = 1;
	const STATUS_CLOSED = 2;
	const STATUS_BLOCKED = 3;
  const MODEL ='course-request';
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	protected $casts = [
		'updated' => 'datetime',
		'date' => 'datetime',
		'created' => 'datetime',

	];
	protected $appends = ['hashid','status_name'];

	public function getStatusNameAttribute()
	{
		return static::statusName($this->status);
	}

	public static function statusName($status)
	{
		$statusNames = static::statusNames();
		if (isset($statusNames[$status])) return $statusNames[$status];

		return '';
	}

	public static function statusNames()
	{
		return array(
			self::STATUS_OPEN =>'Aperto',
			self::STATUS_PENDING =>'In attesa',
			self::STATUS_CLOSED => 'Completato',
			self::STATUS_BLOCKED => 'Bloccata',
		);
	}
	public function getDateAttribute($value){
		return $this->databaseDateFormat($value);
	}
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
