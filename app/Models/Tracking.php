<?php

namespace App\Models;

use App\Models\Exams\LrnExamSession;
use App\Traits\DatabaseDateFomat;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Tracking extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,DatabaseDateFomat;


	protected $table = 'utilities_trackings';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const STATUS_TO_SEND = 0;
	const STATUS_DELIVERING = 1;
	const STATUS_RECEIVD = 2;
	const STATUS_EXPIERD = 3;
	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;

	protected $casts = [
		'estimate_date' => 'datetime',
		'updated' => 'datetime',
		'created' => 'datetime',
		'send_date' => 'datetime',
		'expiry_date' => 'datetime',
		'state' => 'boolean',

	];
	protected $appends = ['hashid','status_name'];

	public function scopeActive($query){
		return $query->where('state',self::IS_ACTIVE);
	}
	public function lrnexam(){
		return $this->belongsTo(LrnExamSession::class,'lrn_exam_session_id','id');
	}
	public function structure(){
		return $this->belongsTo(User::class,'user_id','id');
	}
	public function getEstimateDateAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getSendDateAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getExpiryDateAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getStatusNameAttribute(){
		return static::statusName($this->status);
	}
	public static function statusNames(){
		return [
			self::STATUS_TO_SEND =>'Da spedire',
			self::STATUS_DELIVERING =>'In consegna',
			self::STATUS_RECEIVD =>'Ricevuto',
			self::STATUS_EXPIERD =>'Expired',
		];
	}
	public static function statusName($type){
		$statusNames = static::statusNames();
		if (isset($statusNames[$type])) return $statusNames[$type];
		return '';
	}
}
