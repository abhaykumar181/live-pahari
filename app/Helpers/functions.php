<?php
use Illuminate\Support\str;
/**
 * Define Custom Functions
 * 
 */


/**
 * Get current controller name
 */
if (!function_exists('getControllerName')) {
    function getControllerName() {
        $controller_path = Route::getCurrentRoute()->getActionName();
        list($controller, $action) = explode('@', $controller_path);
        return preg_replace('/.*\\\/', '', $controller);
    }
}

if(!function_exists('getSlug')){
    function getSlug($value){
        return str::slug($value);
    }
}



/**
 * Get current controller name
 */
if (!function_exists('pr')) {
    function pr($array = []) {
        echo '<pre>'; print_r($array); echo '</pre>';
    }
}