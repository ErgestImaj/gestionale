<?php

namespace App\Models\Cart;

use App\Models\User;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class PaypalTransactions extends Model
{
	use HashIdAttribute, HasHashid, HashidRouting, HasUserRelationships, SoftDeletes;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;
	protected $table = 'cart_paypal_transactions';
	protected $guarded = [];
	protected $casts = [
		'locked' => 'datetime',
		'deleted_at' => 'datetime',
		'created' => 'datetime',
		'order_date' => 'datetime',
		'state' => 'boolean',
		'details' => 'json',
		'params' => 'json',

	];
	protected $appends = ['hashid', 'user_full_name'];

	public function order()
	{
		return $this->belongsTo(Orders::class, 'order_id', 'id');
	}

	public function getUserFullNameAttribute()
	{
		if (isset($this->params['validate_user_id']) && is_array($this->params)) {
			$user = User::find($this->params['validate_user_id']);
			if ($user) {
				return $user->full_name;
			}
		}
		return '';
	}
}
