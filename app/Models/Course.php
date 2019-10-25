<?php

namespace App\Models;


use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Course extends Model
{
    use HasHashid,HashidRouting,HasStatus,HasUserRelationships,SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    const  IS_ACTIVE = 1;
    const  NOT_ACTIVE = 0;

    protected $table = 'courses_courses';
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function category(){
      return  $this->belongsTo(Category::class,'category_id');
    }

    public function vatRate(){
        return $this->belongsTo(VatRate::class,'vat_rate');
    }

    public function expiration(){
        return $this->belongsTo(Expiry::class,'expiry','id');
    }


}
