<?php

namespace App\Models;

use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class MassMailHistory extends Model
{
    use Notifiable, HasHashid, HashidRouting, HasUserRelationships;

    protected $guarded = [];
		protected $casts = [
			'types'=>'array',
			'exclude'=>'array',
			'send_to'=>'array',
		];
}
