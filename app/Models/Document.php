<?php

namespace App\Models;

use App\Traits\HasContentPath;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Document extends Model
{
    use HasUserRelationships, HasHashid, HashidRouting,
        SoftDeletes,HasContentPath;

    const CONTENT_PATH = 'doc_files';

    protected $appends = ['content_path'];

    protected $guarded = [];
    protected $casts = [
        'share_with'=>'array',
    ];
    public function categories(){
        return $this->belongsToMany(DocumentCategories::class,'document_category','document_id','category_id');
    }

}
