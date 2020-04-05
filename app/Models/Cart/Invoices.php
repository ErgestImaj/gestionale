<?php

namespace App\Models\Cart;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Invoices extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships;

	protected $table = 'cart_invoices';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;
	protected $casts = [
		'locked' => 'datetime',
		'deleted_at' => 'datetime',
		'created' => 'datetime',
		'state' => 'boolean',
		'params'=>'json',
		'data'=>'json',

	];
	protected $appends = ['hashid'];

	public function order(){
		return $this->belongsTo(Orders::class,'order_id','id');
	}
}
