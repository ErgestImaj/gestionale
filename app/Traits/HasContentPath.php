<?php
namespace App\Traits;


use Illuminate\Support\Facades\Storage;

trait HasContentPath {

    /**
     * @return mixed
     */
    public function getContentPathAttribute(){
        return Storage::url(self::CONTENT_PATH.'/');
    }

}
