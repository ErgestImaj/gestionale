<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Course extends Model
{
    use HasHashid,HashidRouting;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

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
}
