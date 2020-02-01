<?php
namespace App\Traits;


trait HashIdAttribute{

    public function getHashidAttribute()
    {
        return $this->hashid();
    }

}
