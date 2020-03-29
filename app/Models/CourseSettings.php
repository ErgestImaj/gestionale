<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseSettings extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships;

	protected $table = 'course_settings';
	protected $guarded = [];
	protected $appends = ['hashid'];

	protected static function boot()
	{
		parent::boot();
		static::creating(function($module){
			$module->created_by = auth()->id();
		});
	}
}
