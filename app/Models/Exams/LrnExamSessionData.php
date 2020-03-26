<?php

namespace App\Models\Exams;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class LrnExamSessionData extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,SoftDeletes;

	protected $table = 'utilities_lrn_exam_session_data';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	protected $casts = [
		'deleted_at' => 'datetime',
		'created' => 'datetime',
		'updated' => 'datetime',
	];

	protected $appends = ['hashid'];

}
