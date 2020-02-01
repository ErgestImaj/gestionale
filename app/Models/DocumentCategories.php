<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class DocumentCategories extends Model
{
      use HasUserRelationships, HasHashid, HashidRouting, HashIdAttribute, SoftDeletes;

        protected $guarded = [];
        protected $appends = [
            'hashid'
        ];
        public function documents(){

            return $this->belongsToMany(Document::class,'document_category','document_id','category_id');

        }
}
