<?php

namespace App\Models\Cart;

use App\Models\Config;
use App\Models\Exams\LrnExamSession;
use App\Models\User;
use App\Traits\DatabaseDateFomat;
use App\Traits\HashIdAttribute;
use App\Traits\PaymentNameAttribute;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class FastTrack extends Model
{
	use HashIdAttribute,HasHashid,HashidRouting,PaymentNameAttribute,DatabaseDateFomat;

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

	protected $appends = ['hashid','state_name','order_items','payment_name','general_price'];

	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}
	public function getGeneralPriceAttribute(){
		$config = Config::where('name', 'cart')->pluck('config_values')->first();
		return $config['fast_track_price'] ?? 0;
	}
  public function getOrderItemsAttribute(){

			if (empty($this->exam_sessions)) return[];
      return LrnExamSession::select(['id','course_id','date'])->whereIn('id',$this->exam_sessions)->with([
     	'course'=>function($query){
     	 $query->select('id','name');
			}
		 ])->withCount('participants')->get();

	}
	public function getStateNameAttribute(){
		return static::getStateName($this->state);
	}
	public static function getStateName($state){
		$states = static::getStateNames();
		if (isset($states[$state])) return $states[$state];
		return '';
	}
	public  static function getStateNames(){
		return [
			self::STATE_PAYED=>"Completato",
			self::STATE_PENDING=>"In attesa",
			self::STATE_READY=>"Aperto",
		];
	}
	public function getOrderDateAttribute($value){
		return $this->databaseDateFormat($value);
	}
}
