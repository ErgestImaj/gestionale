<?php

namespace App\Models\Cart;

use App\Models\User;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CartOrders extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships,SoftDeletes;

	protected $table = 'cart_orders';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const TYPE_SUBSCRIPTION = 0;
	const TYPE_USER_VALIDATION = 1;
	const TYPE_PURCHASE = 2;
	const TYPE_CERTIFICATE_DUPLICATE_REQUEST = 3;
	const TYPE_CREDIT_PACK_PURCHASE = 4;

	const STATUS_OPEN = 0;
	const STATUS_PENDING = 1;
	const STATUS_COMPLETE = 2;
	const STATUS_ERROR = 3;

	const PAYPAL = 0;
	const BANK_TRANSFER = 1;

	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;

	protected $casts = [
		'locked' => 'datetime',
		'deleted_at' => 'datetime',
		'created' => 'datetime',
		'order_date' => 'datetime',
		'state' => 'boolean',

	];
	protected $appends = ['hashid','type_name'];

	public function cartCourseTransaction(){
		return $this->hasMany(CartCourseTransactions::class,'order_id','id');
	}
	public function orderItems(){
		return $this->hasMany(CartOrderItems::class,'order_id','id');
	}
	public function structure(){
		return $this->belongsTo(User::class,'user_id','id');
	}
	public function paypalTransactions(){
		return $this->hasOne(CartPaypalTransactions::class,'order_id','id');
	}
	public function invoice(){
		return $this->hasOne(CartInvoices::class,'order_id','id');
	}
	public static function typeNames()
	{
		return [
			self::TYPE_SUBSCRIPTION => 'Accreditamento struttura',
			self::TYPE_USER_VALIDATION=> 'Accreditamento utente',
			self::TYPE_PURCHASE=> 'Acquisto corsi',
			self::TYPE_CERTIFICATE_DUPLICATE_REQUEST=> 'Acquisto duplicato',
			self::TYPE_CREDIT_PACK_PURCHASE=> 'Acquisto Credit Pack',
		];
	}

	public static function typeName($type){
		$typeNames = static::typeNames();
		if (isset($typeNames[$type])) return $typeNames[$type];
		return '';
	}
	public function getTypeNameAttribute(){
		return static::typeName($this->type);
	}
}
