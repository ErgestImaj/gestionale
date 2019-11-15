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
/**
 * Set key=value to .env file
 * @param array $values
 * @return bool
 */
if (!function_exists('setEnvironmentValue')) {

    function setEnvironmentValue(array $values)
    {

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }

            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;

    }
}
if (!function_exists('convert_to_price')){
    function convert_to_price($number){

        return number_format($number, 2);

    }
}

if (!function_exists('price_formater')){
    function price_formater($price){

        return convert_to_price($price).' €';

    }
}

