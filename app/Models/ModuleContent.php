<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class ModuleContent extends Model
{
    use HasUserRelationships,HasStatus,HasHashid,HashidRouting,SoftDeletes;

    const CONTENT_PATH = 'contentfiles';

    const  IS_ACTIVE = 1;
    const  NOT_ACTIVE = 0;

    protected $guarded = [];
    protected $table = 'module_contents';

    protected $dates = ['locked'];


    protected $appends = ['content_path'];

    /**
     * @return mixed
     */
    public function getContentPathAttribute(){

        return Storage::url(self::CONTENT_PATH.'/');
    }

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
