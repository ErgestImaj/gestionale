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

	const SUBSCRIPTION = 0;
	const USER_VALIDATION = 1;
	const PURCHASE = 2;
	const CERTIFICATE_DUPLICATE_REQUEST = 3;
	const CREDIT_PACK_PURCHASE = 4;
	const FAST_TRACK = 5;

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
		$max_nr = static::whereYear('created',Carbon::now()->year)->max('invoice_number');
		return $max_nr ? ($max_nr + 1).'_G' : '1_G';
	}
}
