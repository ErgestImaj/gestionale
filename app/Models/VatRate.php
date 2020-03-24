<?php

namespace App\Models;

use App\Traits\HashIdAttribute;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class VatRate extends Model
{
    //
    use HashidRouting,HasHashid,HashIdAttribute;
    public $timestamps = false;
    protected $fillable =['name','value'];

		protected $appends = [
			'hashid'
		];

    public function courses(){
        return $this->hasMany(Course::class,'vat_rate');
    }

}
