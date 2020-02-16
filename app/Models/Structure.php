<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasLocation;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Structure extends Model
{
	use HasUserRelationships, HasHashid, HashidRouting, HashIdAttribute, HasLocation;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    const TYPE_PARTNER = 1;
    const TYPE_MASTER = 2;
    const TYPE_AFFILIATE = 3;

    protected $table = 'structures_structures';

    protected $guarded = [];

    protected $appends = [
        'hashid'
    ];

	public function status(){
	    return $this->hasOne(StructureStatus::class,'structure_id');
    }

}
