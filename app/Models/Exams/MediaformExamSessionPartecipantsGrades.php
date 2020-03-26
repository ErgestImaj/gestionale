<?php

namespace App\Models\Exams;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class MediaformExamSessionPartecipantsGrades extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,SoftDeletes;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	protected $table = 'utilities_exam_session_partecipants_grades';
	protected $guarded = [];
	protected $casts = [
		'deleted_at' => 'datetime',
		'created' => 'datetime',
		'updated' => 'datetime',
		'grades' => 'array',
	];

	protected $appends = ['hashid'];

	public function mediaformExam(){
		return $this->belongsTo(MediaformExamSession::class,'exam_session_id','id');
	}
}
