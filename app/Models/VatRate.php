<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class VatRate extends Model
{
    //
    use HashidRouting,HasHashid;
    public $timestamps = false;
    protected $fillable =['name','value'];

    public function courses(){
        return $this->hasMany(Course::class,'vat_rate');
    }

}
