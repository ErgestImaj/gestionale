<?php

namespace App\Models\Cart;

use App\Models\User;
use App\Traits\HashIdAttribute;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class FastTrack extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting;

	protected $table = 'fast_track';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const STATE_PAYED = 2;
	const STATE_PENDING = 1;
	const STATE_READY = 0;

	const PAYPAL = 0;
	const BANK_TRANSFER = 1;

	protected $casts = [
		'created' => 'datetime',
		'updated' => 'datetime',
		'order_date' => 'datetime',
		'exam_sessions' => 'array',
	];

	protected $appends = ['hashid'];

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}
}