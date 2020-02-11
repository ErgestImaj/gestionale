<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
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

    public function structure(){
        return $this->belongsTo(Structure::class);
    }

}
