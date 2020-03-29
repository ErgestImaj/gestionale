<?php


namespace App\Helpers;


class FileExtensionsHelper {
    public static function allowedExtensions(){
        return [
            'jpg',
            'jpeg',
            'png',
            'pdf',
            'mp4',
            'mpeg',
            'x-flv',
            'avi',
            'mp3',
            'zip'
        ];
    }
    public static function allowedExtensionsForBox(){
        return [
            'xlsx',
            'xls',
            'doc',
            'docx',
            'txt',
            'pptx',
            'csv'
        ];
    }

}
