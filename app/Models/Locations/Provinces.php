<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HashidRouting;

class Provinces extends Model
{

	protected $table = 'location_provs';
	public $timestamps = false;

	public function regione()
	{
		return $this->belongsTo(Regions::class, 'regione_id');
	}
}
