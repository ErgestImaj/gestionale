<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class CourseModule extends Model
{
    use HasUserRelationships,HasHashid,HashidRouting, HashIdAttribute, SoftDeletes;


    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $table = 'courses_course_modules';
    protected $guarded = [];


    protected $appends = [
        'hashid'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($module){
            $module->created_by = auth()->id();
            $module->updated_by = auth()->id();
        });
    }

    public function scopeSearch($query,$value){
        if(empty($value)) return $query;

        return $query->where('module_name', 'LIKE', '%'.$value.'%');
    }

    public function contents(){
        return $this->hasMany(ModuleContent::class, 'module_id');
    }
}
