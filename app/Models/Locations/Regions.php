<?php

namespace App\Models\Locations;


use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{

    public $timestamps = false;
    protected $table = 'location_regions';

    public function provinces(){
        return $this->hasMany(Provinces::class);
    }


}
