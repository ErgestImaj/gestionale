<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class StructureStatus extends Model
{
	use HasUserRelationships, HasHashid, HashidRouting, HashIdAttribute;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	protected $table = 'structures_structure_statuses';
	protected $guarded = [];
	protected $appends = [
		'hashid'
	];

	protected $dates = ['date', 'date_lrn', 'date_iiq', 'date_miur', 'date_dile'];

	/**
	 * @param $val
	 * @return string
	 * @throws \Exception
	 */
	public function getDateAttribute($val)
	{
		if (empty($val)) return $val;
		return (new Carbon($val))->format('Y-m-d');
	}

	/**
	 * @param $val
	 * @return string
	 * @throws \Exception
	 */
	public function getDateLrnAttribute($val)
	{
		if (empty($val)) return $val;
		return (new Carbon($val))->format('Y-m-d');
	}

	/**
	 * @param $val
	 * @return string
	 * @throws \Exception
	 */
	public function getDateIiqAttribute($val)
	{
		if (empty($val)) return $val;
		return (new Carbon($val))->format('Y-m-d');
	}

	/**
	 * @param $val
	 * @return string
	 * @throws \Exception
	 */
	public function getDateMiurAttribute($val)
	{
		if (empty($val)) return $val;
		return (new Carbon($val))->format('Y-m-d');
	}

	/**
	 * @param $val
	 * @return string
	 * @throws \Exception
	 */
	public function getDateDileAttribute($val)
	{
		if (empty($val)) return $val;
		return (new Carbon($val))->format('Y-m-d');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function structure()
	{
		return $this->belongsTo(Structure::class);
	}

}
