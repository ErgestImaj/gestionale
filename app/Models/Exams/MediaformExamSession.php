<?php

namespace App\Models\Exams;

use App\Models\Course;
use App\Models\User;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class MediaformExamSession extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,SoftDeletes;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	CONST SAME_LOCATION = 0;
	CONST OTHER_LOCATION = 1;

	CONST POST_LAUREA_CSV_SENT = 1;

	CONST STATUS_OPEN = 1;
	CONST STATUS_CLOSED = 2;
	CONST STATUS_ENROLLED = 3;

	CONST ATTENDANCE_SHEET = 'attendance_sheet';

	CONST VOUCHER_DISABLED = false;

	CONST IS_NOT_REPEATING = 0;
	CONST IS_REPEATING = 1;

	const CM_NO = 0;
	const CM_YES = 1;
	const CM_USED = 2;

	protected $table = 'utilities_exam_sessions';
	protected $guarded = [];
	protected $casts = [
		'deleted_at' => 'datetime',
		'date' => 'datetime',
		'created' => 'datetime',
		'updated' => 'datetime',
	];

	protected $appends = ['hashid'];

	/**
	 * Relationships
	 */

	public function course(){
		return $this->belongsTo(Course::class,'course_id','id');
	}
	public function examiner(){
		return $this->belongsTo(User::class,'examiner_id','id');
	}
	public function former(){
		return $this->belongsTo(User::class,'former_id','id');
	}
	public function supervisor(){
		return $this->belongsTo(User::class,'supervisor_id','id');
	}
	public function mfExamSessionCms(){
		return $this->hasOne(MediaformExamSessionCms::class,'exam_session_id','id');
	}

	public function mfExamSessionData(){
		return $this->hasOne(MediaformExamSessionData::class,'exam_session_id','id');
	}

	public function mfExamSessionParticipantsGrades(){
		return $this->hasOne(MediaformExamSessionPartecipantsGrades::class,'exam_session_id','id');
	}

	public function participants(){
		return $this->belongsToMany(User::class,'utilities_exam_session_partecipants','user_id','exam_session_id')->withPivot();
	}
}
