<?php


namespace App\Helpers;


use Maengkom\Box\BoxAppUser;

class UploadToBox {


    public static function exportFile($file){
        $url = '';
        $api = new BoxAppUser( config( 'boxapi' ) );

        $name = $file->getClientOriginalName();
        $name = microtime() . '_' . $name;

       $uploadedFile = $api->uploadFile( $file, 0, $name, false );

       $fileID = $uploadedFile['entries'][0]['id'];

       $sharedLink = $api->createShareLink( $fileID, 'open' );

       if (isset($sharedLink['shared_link']['url'] )){
           $linkData   = explode( '/', $sharedLink['shared_link']['url'] )[4];
           $url = 'https://app.box.com/embed_widget/s/' . $linkData;
       }
       return $url;

   }
}
