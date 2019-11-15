<?php

namespace App\Traits;

use App\Models\User;

trait HasUserRelationships{

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function updatedByUser(){
        return $this->belongsTo(User::class,'updated_by');
    }
    public function lockedByUser(){
        return $this->belongsTo(User::class,'locked_by');
    }

}
