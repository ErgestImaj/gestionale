<?php

namespace App\Models;

use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Workshop extends Model
{
    use HashidRouting,HasHashid,HasUserRelationships,SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'partecipants'=>'array',
			  'types'=>'array'
    ];
}
