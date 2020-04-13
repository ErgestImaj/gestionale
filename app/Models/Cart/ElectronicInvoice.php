<?php

namespace App\Models\Cart;

use App\Models\User;
use App\Traits\DatabaseDateFomat;
use App\Traits\HasContentPath;
use App\Traits\HashIdAttribute;
use App\Traits\OrderTypeNameAttribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class ElectronicInvoice extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,OrderTypeNameAttribute,DatabaseDateFomat,HasContentPath;

	protected $table = 'electronic_invoice';
	protected $guarded = [];
  const CONTENT_PATH = 'electronic_invoice';
	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const TYPE_SUBSCRIPTION = 0;
	const TYPE_USER_VALIDATION = 1;
	const TYPE_PURCHASE = 2;
	const TYPE_CERTIFICATE_DUPLICATE_REQUEST = 3;
	const TYPE_CREDIT_PACK_PURCHASE = 4;
	const TYPE_FAST_TRACK = 5;

	const NORMAL_ORDER=1;
	const FAST_TRACK_ORDER=2;

	protected $casts = [
		'created' => 'datetime',
		'updated' => 'datetime',
	];

	protected $appends = ['hashid','type_name','content_path'];

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}
	public function getCreatedAttribute($date){
		return $this->databaseDateFormat($date);
	}
	public static function getMaxProgresNumber(){
		$max_nr = static::whereYear('created',Carbon::now()->year)->where('created_by',auth()->id())->max('invoice_number');
		return $max_nr ? ($max_nr + 1).'_G' : '1_G';
	}
}
