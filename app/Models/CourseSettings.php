<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseSettings extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,SoftDeletes;

	protected $table = 'course_settings';
	protected $guarded = [];
	protected $appends = ['hashid'];

}
