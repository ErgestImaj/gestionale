<?php

namespace App\Models\Cart;

use App\Models\User;
use App\Traits\DatabaseDateFomat;
use App\Traits\HasContentPath;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use App\Traits\OrderTypeNameAttribute;
use App\Traits\PaymentNameAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Orders extends Model
{
	use HashIdAttribute, HasHashid, HashidRouting, HasContentPath,
		HasUserRelationships, SoftDeletes, PaymentNameAttribute, DatabaseDateFomat,
		OrderTypeNameAttribute;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const MODEL = 'orders';
	const CONTENT_PATH = 'utilities';
	const TYPE_SUBSCRIPTION = 0;
	const TYPE_USER_VALIDATION = 1;
	const TYPE_PURCHASE = 2;
	const TYPE_CERTIFICATE_DUPLICATE_REQUEST = 3;
	const TYPE_CREDIT_PACK_PURCHASE = 4;
	const TYPE_FAST_TRACK = 5;
	const STATUS_OPEN = 0;
	const STATUS_PENDING = 1;
	const STATUS_COMPLETE = 2;
	const STATUS_ERROR = 3;
	const PAYPAL = 0;
	const BANK_TRANSFER = 1;
	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;
	protected $table = 'cart_orders';
	protected $guarded = [];
	protected $casts = [
		'locked' => 'datetime',
		'deleted_at' => 'datetime',
		'created' => 'datetime',
		'order_date' => 'datetime',
		'state' => 'boolean',

	];

	protected $appends = ['hashid', 'type_name', 'payment_name', 'status_name', 'content_path'];

	public function cartCourseTransaction()
	{
		return $this->hasMany(CourseTransactions::class, 'order_id', 'id');
	}

	public function orderItems()
	{
		return $this->hasMany(OrderItems::class, 'order_id', 'id');
	}

	public function structure()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function paypalTransactions()
	{
		return $this->hasOne(PaypalTransactions::class, 'order_id', 'id');
	}

	public function invoice()
	{
		return $this->hasOne(Invoices::class, 'order_id', 'id');
	}


	public function getStatusNameAttribute()
	{
		return static::statusName($this->status);
	}

	public static function statusName($status)
	{
		$statusNames = static::statusNames();
		if (isset($statusNames[$status])) return $statusNames[$status];

		return '';
	}

	public static function statusNames()
	{
		return array(
			self::STATUS_OPEN => 'Aperto',
			self::STATUS_PENDING => 'In attesa',
			self::STATUS_COMPLETE => 'Completato',
			self::STATUS_ERROR => 'Non completato',
		);
	}

	public function getOrderDateAttribute($value)
	{
		return $this->databaseDateFormat($value);
	}
}
