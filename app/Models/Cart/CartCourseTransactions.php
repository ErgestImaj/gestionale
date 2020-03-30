<?php

namespace App\Models\Cart;

use App\Models\Course;
use App\Models\User;
use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CartCourseTransactions extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,HasUserRelationships;

	protected $table = 'cart_course_transactions';
	protected $guarded = [];

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const TYPE_SUBSCRIPTION                 = 0;
	const TYPE_COURSE_PURCHASE              = 1;
	const TYPE_PROMO_PACK_PURCHASE          = 2;
	const TYPE_ADMIN_ADDED                  = 3;
	const TYPE_COURSE_DISTRIBUTE            = 4;
	const TYPE_COURSE_REFUND                = 5;
	const TYPE_COURSE_REQUEST               = 6;

	protected $casts = [
		'created' => 'datetime',
		'updated' => 'datetime',
	];

	protected $appends = ['hashid'];

	public function scopeType($query,$type){
		return $query->where('type',$type);
	}
	public function owner(){
		return $this->belongsTo(User::class,'user_id');
	}

	public function course(){
		return $this->belongsTo(Course::class,'course_id','id');
	}

	public function parent(){
		return $this->hasOne(CartCourseTransactions::class,'parent_transaction_id','id');
	}

	public function order(){
		return $this->belongsTo(CartOrders::class,'order_id','id');
	}
}
