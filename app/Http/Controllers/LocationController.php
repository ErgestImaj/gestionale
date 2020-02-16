<?php

namespace App\Http\Controllers;

use App\Models\Locations\Countries;
use App\Models\Locations\Provinces;
use App\Models\Locations\Regions;
use App\Models\Locations\Towns;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function getLocations(){

        $countries = Cache::remember('countries',Carbon::now()->addMinutes(60),function (){
            return Countries::all();
        });
        $regions = Cache::remember('regions',Carbon::now()->addMinutes(60),function (){
            return Regions::all();
        });
        $provinces = Cache::remember('provinces',Carbon::now()->addMinutes(60),function (){
            return Provinces::all();
        });
        $towns = Cache::remember('towns',Carbon::now()->addMinutes(60),function (){
            return Towns::all();
        });

        return [
            'countries'=>$countries,
            'regions'=>$regions,
            'provinces'=>$provinces,
            'towns'=>$towns
        ];
    }
}
