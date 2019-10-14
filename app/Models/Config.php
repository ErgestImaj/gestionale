<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $table = 'config';
    protected $_config = array();
    public $timestamps = false;

    protected $fillable = ['name','config_values'];

    protected $casts = [
        'config_values'=>'json'
    ];

}
