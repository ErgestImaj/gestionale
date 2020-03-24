<?php

namespace App\Models;


use App\Traits\HashIdAttribute;
use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Course extends Model
{
    use HasHashid,HashidRouting,HasStatus,HasUserRelationships,HashIdAttribute,SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    const  IS_ACTIVE = 1;
    const  NOT_ACTIVE = 0;

    protected $table = 'courses_courses';
    protected $guarded = [];

    protected $appends = [
        'hashid'
    ];

    public function scopeActive($query){
        $query->where('state',self::IS_ACTIVE);
    }

    public function category(){
      return  $this->belongsTo(Category::class,'category_id','id');
    }

    public function vatRate(){
        return $this->belongsTo(VatRate::class,'vat_rate','id');
    }

    public function expiration(){
        return $this->belongsTo(Expiry::class,'expiry','id');
    }

    public function modules(){
        return $this->hasMany(CourseModule::class);
    }

    public function tutor(){
				return $this->belongsToMany(User::class,'course_user','course_id','user_id');
		}
}
