<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class UserStatus extends Model
{
	use HashidRouting,HasHashid,HashIdAttribute,HasUserRelationships;
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const GENDER_M = 'M';
	const GENDER_F = 'F';

	const ADMIN_PENDING = 0;
	const PENDING = 1;
	const PAYMENT_OK = 2;
	const NOT_APPROVED = 3;

	protected $table = 'users_user_statuses';

	public $appends = [
		'status_name','hashid'
	];

	public static function statusName($status)
	{
		$statusNames = static::statusNames();
		if(isset($statusNames[$status])) return $statusNames[$status];

		return '';
	}

	public static function statusNames()
	{

		return array(
			self::ADMIN_PENDING   => 'In attesa di approvazione',
			self::PENDING   => 'In attesa di pagamento',
			self::PAYMENT_OK   =>'Accreditato',
			self::NOT_APPROVED   => 'Non approvato',
		);
	}
  public function scopeStatus($query,$status){
		$query->where('status',$status);
	}
	public function getStatusNameAttribute()
	{
		return static::statusName($this->status);
	}

	public function owner()
	{
		return $this->belongsTo(User::class,'user_id','id');
	}

	public static function getStatuses()
	{
		return array(
			self::ADMIN_PENDING,
			self::PENDING,
			self::PAYMENT_OK,
			self::NOT_APPROVED
		);
	}

}
