<?php

/**
 * Format date
 */
if (!function_exists('format_date')){
    function format_date($date){
        if (!empty($date)){
            return \Carbon\Carbon::parse($date)->format('d M Y');
        }
        return 'non disponibile';
    }
}
/**
 * Format date using carbon
 * an alias for blade
 */

if (!function_exists('diffForHumans')){

    function diffForHumans($date){
        if (!empty($date)){
            return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
        }
        return 'non disponibile';
    }
}


