<?php

namespace App\Models;

use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Document extends Model
{
    use HasUserRelationships, HasHashid, HashidRouting, SoftDeletes;

    protected $guarded = [];

    public function categories(){
        return $this->belongsToMany(DocumentCategories::class,'document_category','document_id','category_id');
    }
}
