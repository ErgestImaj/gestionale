<?php

namespace App\Models;

use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Discount extends Model
{
	  use HasHashid,HashidRouting,HasUserRelationships,SoftDeletes;

    protected $guarded = [];

    protected $table = 'discounts';

    public function structure(){
    	return $this->belongsTo(Structure::class);
    }
}
