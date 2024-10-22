<?php

namespace App\Models\Exams;

use App\Models\Course;
use App\Models\User;
use App\Traits\DatabaseDateFomat;
use App\Traits\HashIdAttribute;
use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class LrnExamSession extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,SoftDeletes,DatabaseDateFomat,HasStatus;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
  const MODEL ='lrnexamsession';
	CONST ATTENDANCE_SHEET = 'attendance_sheet';
	CONST ASSESSMENT_SESSION_COVER_SHEET = 'assessment_session_cover_sheet';
	CONST MARK_SHEET = 'mark_sheet';
	CONST LRN_CERTIFICATE_TMPL = 'lrn_certificate';

	CONST SAME_LOCATION = 0;
	CONST OTHER_LOCATION = 1;

	CONST VOUCHER_DISABLED = true;

	const FAST_TRACK = 0;
	const FAST_TRACK_WAIT = 1;
	const FAST_TRACK_OK = 2;
	const FAST_TRACK_SELECTED = 3;

	const CM_NO = 0;
	const CM_YES = 1;
	const CM_USED = 2;

	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;

	const TYPE_LRN = 0;
	const TYPE_DILE = 1;

	protected $table = 'utilities_lrn_exam_sessions';
	protected $guarded = [];
	protected $casts = [
		'deleted_at' => 'datetime',
		'date' => 'datetime',
		'end_date' => 'datetime',
		'created' => 'datetime',
		'updated' => 'datetime',
		'date_of_issue' => 'datetime',
		'credentials' => 'array',
		'results' => 'array',
	];

	protected $appends = ['hashid'];

	public function getDateAttribute($value){
		return $this->databaseDateFormat($value);
	}
	/**
	 * Relationships
	 */

	public function owner(){
		return $this->belongsTo(User::class,'user_id','id');
	}
	public function course(){
		return $this->belongsTo(Course::class,'course_id','id');
	}
	public function examiner(){
		return $this->belongsTo(User::class,'examiner_id','id');
	}
	public function invigilator(){
		return $this->belongsTo(User::class,'invigilator_id','id');
	}
	public function investigator(){
		return $this->belongsTo(User::class,'invigilator_id','id');
	}
	public function lrnExamSessionCms(){
		return $this->hasOne(LrnExamSessionCms::class,'exam_session_id','id');
	}
	public function lrnExamSessionData(){
		return $this->hasOne(LrnExamSessionData::class,'lrn_exam_session_id','id');
	}
	public function participants(){
		return $this->belongsToMany(User::class,'utilities_lrn_exam_session_partecipants','lrn_exam_session_id','user_id')->withPivot('cm','voucher_id');
	}
	public function scopeType($query,$type){
		$query->where('type',$type);
	}
}
