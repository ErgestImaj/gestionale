<?php
namespace App\Traits;


use App\Models\Locations\Countries;
use App\Models\Locations\Provinces;
use App\Models\Locations\Regions;
use App\Models\Locations\Towns;

trait HasLocation{

    /**
     * @return mixed
     */
    public function town(){
        return $this->belongsTo(Towns::class,'legal_town');
    }
    /**
     * @return mixed
     */
    public function operationalTown(){
        return $this->belongsTo(Towns::class,'operational_town');
    }
    /**
     * @return mixed
     */
    public function region(){
        return $this->belongsTo(Regions::class,'legal_region');
    }
    /**
     * @return mixed
     */
    public function operationalRegion(){
        return $this->belongsTo(Regions::class,'operational_region');
    }

    /**
     * @return mixed
     */
    public function province(){
        return $this->belongsTo(Provinces::class,'legal_prov');
    }
    /**
     * @return mixed
     */
    public function operationalProvince(){
        return $this->belongsTo(Provinces::class,'operational_prov');
    }

    /**
     * @return mixed
     */
    public function country(){
        return $this->belongsTo(Countries::class,'legal_country');
    }
    /**
     * @return mixed
     */
    public function operationalCountry(){
        return $this->belongsTo(Countries::class,'operational_country');
    }
}
