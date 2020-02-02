<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Box Developer IDs
    |--------------------------------------------------------------------------
    |
    | Set these value based on this documentation
    | https://box-content.readme.io/docs/box-platform
    |
    */

    'au_client_id'     => env( 'BOX_CLIENT_ID' ),
    'au_client_secret' => env( 'BOX_CLIENT_SECRET' ),
    'su_client_id'     => env( 'BOX_CLIENT_ID' ),
    'su_client_secret' => env( 'BOX_CLIENT_SECRET' ),
    'redirect_uri'     => '',

    /*
    |--------------------------------------------------------------------------
    | Get Enterprise IDs
    |--------------------------------------------------------------------------
    |
    | Login into box.com and go to admin console menu on top left.
    | Click gear icon on top right, click Enterprise or Business Setting.
    | See the enterprise id on the screen
    |
    */

    'enterprise_id' => env( 'BOX_ENTERPRISE_ID' ),

    /*
    |--------------------------------------------------------------------------
    | Set Username or User Id
    |--------------------------------------------------------------------------
    |
    | Set user name to use as App User in Enterprise. Usually need single user.
    | Set user id if you know exactly the user id of Enterprise user
    | to use this API.
    |
    */

    'app_user_name' => env( 'BOX_USER_NAME' ),
    'app_user_id'   => env( 'BOX_USER_ID' ),

    /*
    |--------------------------------------------------------------------------
    | Expiration Time for Access Token
    |--------------------------------------------------------------------------
    |
    | Set expiration time in second after request token. Max 60 seconds.
    |
    */

    'expiration' => 60,

    /*
    |--------------------------------------------------------------------------
    | Expiration Time for Access Token
    |--------------------------------------------------------------------------
    |
    | use this in terminal openssl genrsa -aes256 -out private_key.pem 2048
    | follow documentation here
    | copy this file in root folder of Laravel 5 project
    |
    */

    'public_key_id'    => env( 'BOX_PUBLIC_KEY_ID' ),
    'private_key_file' => storage_path() . '/box_private_key.pem',
    'passphrase'       => env( 'BOX_PASSPHRASE' ),

];
