<?php

namespace App\Models\Cart;

use App\Models\User;
use App\Traits\HashIdAttribute;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class ElectronicInvoice extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting;

	protected $table = 'electronic_invoice';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const SUBSCRIPTION = 0;
	const USER_VALIDATION = 1;
	const PURCHASE = 2;
	const CERTIFICATE_DUPLICATE_REQUEST = 3;
	const CREDIT_PACK_PURCHASE = 4;
	const FAST_TRACK = 5;

	protected $casts = [
		'created' => 'datetime',
		'updated' => 'datetime',
	];

	protected $appends = ['hashid'];

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}
}
