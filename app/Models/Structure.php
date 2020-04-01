<?php

namespace App\Models;

use App\Models\Cart\CartOrders;
use App\Models\Cart\CourseRequest;
use App\Traits\HasContentPath;
use App\Traits\HashIdAttribute;
use App\Traits\HasLocation;
use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Structure extends Model
{
	use HasUserRelationships, HasHashid, HashidRouting,
	  	HasStatus, HashIdAttribute, HasLocation,HasContentPath, SoftDeletes;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;

	const TYPE_PARTNER = 1;
	const TYPE_MASTER = 2;
	const TYPE_AFFILIATE = 3;

	const CONTENT_PATH = 'structure';

	protected $table = 'structures_structures';

	protected $guarded = [];

	protected $appends = [
		'hashid','content_path'
	];

	public function isPartner()
	{
		return $this->type == self::TYPE_PARTNER;
	}

	public function isMaster()
	{
		return $this->type == self::TYPE_MASTER;
	}

	public function isAffiliate()
	{
		return $this->type == self::TYPE_AFFILIATE;
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner()
	{
		return $this->belongsTo(User::class,'user_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function status()
	{
		return $this->hasOne(StructureStatus::class, 'structure_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function discounts()
	{
		return $this->hasMany(Discount::class, 'structure_id')->orderByDesc('corsi');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function parent()
	{
		return $this->belongsTo(Structure::class, 'parent_structure_id', 'id');
	}
	public function courseRequests(){
		return $this->hasMany(CourseRequest::class,'structure_id','id');
	}

	/**
	 * Scopes
	 */
	public function scopeActive($query,$value = 1){

		return $query->where('state',$value);
	}
}
