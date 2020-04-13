<?php

namespace App\Models;

use App\Models\Exams\MediaformExamSession;
use App\Traits\DatabaseDateFomat;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Certificate extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,DatabaseDateFomat;

	protected $table = 'utilities_certificates';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
  const MODEL='certificate';
	const ATTESTATO_TMPL = 'certificate_tmpl_attestato';
	const CERTIFICATE_TMPL = 'certificate_tmpl_certificate';

	const TYPE_ATTESTATO = 1;
	const TYPE_CERTIFICATE = 2;

	const STATUS_FREE_DOWNLOAD = 1;
	const STATUS_FREE_DOWNLOAD_EXPIRED = 2;

	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;

	protected $casts = [
		'date_issue' => 'datetime',
		'free_download_expiry' => 'datetime',
		'updated' => 'datetime',
		'created' => 'datetime',
		'data' => 'json',
		'params' => 'json',
		'state' => 'boolean',

	];
	protected $appends = ['hashid','type_name'];

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}
	public function examSession(){
		return $this->belongsTo(MediaformExamSession::class,'exam_session_id');
	}
	public function getTypeNameAttribute(){
		return static::typeName($this->type);
	}
	public static function typeNames()
	{
		return [
			self::TYPE_ATTESTATO => 'Attestato',
			self::TYPE_CERTIFICATE => 'Certificato',
		];
	}
	public static function typeName($type){
		$typeNames = static::typeNames();
		if (isset($typeNames[$type])) return $typeNames[$type];
		return '';
	}
	public function getDateIssueAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getFreeDownloadExpiryAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
}
