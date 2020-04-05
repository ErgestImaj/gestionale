<?php

namespace App\Models;


use App\Models\Cart\CourseTransactions;
use App\Models\Cart\OrderItems;
use App\Models\Cart\CourseRequestItems;
use App\Models\Exams\LrnExamSession;
use App\Models\Exams\MediaformExamSession;
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

		public function lrnExams(){
    	return $this->hasMany(LrnExamSession::class,'course_id');
		}
		public function mfExams(){
    	return $this->hasMany(MediaformExamSession::class,'course_id');
		}

		public function cartCourseTransactions(){
			return $this->hasMany(CourseTransactions::class,'course_id','id');
		}
		public function requestItems(){
    	return $this->hasMany(CourseRequestItems::class,'item_id','id');
		}
		public function settings(){
    	return $this->hasOne(CourseSettings::class,'course_id');
		}
		public function ordersItems(){
    	return $this->hasMany(OrderItems::class,'item_id','id');
		}
}
