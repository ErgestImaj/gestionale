<?php

namespace App\Models;

use App\Traits\HasContentPath;
use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class ModuleContent extends Model
{
    use HasUserRelationships,HasStatus,HasHashid,HashidRouting,SoftDeletes,HasContentPath;

    const CONTENT_PATH = 'contentfiles';

    const  IS_ACTIVE = 1;
    const  NOT_ACTIVE = 0;

    protected $guarded = [];
    protected $table = 'module_contents';

    protected $dates = ['locked'];

    protected $appends = ['content_path'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function($module){
            $module->created_by = auth()->id();
            $module->updated_by = auth()->id();
        });
    }
    public function module(){
        return $this->belongsTo(CourseModule::class,'module_id');
    }
}
