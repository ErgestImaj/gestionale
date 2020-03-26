<?php

namespace App\Models\Cart;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CartInvoices extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,SoftDeletes;

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
}
