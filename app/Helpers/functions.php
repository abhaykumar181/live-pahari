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

if(!function_exists('setTextlimit')){
    function setTextlimit($text){
        return str::limit($text,130);
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

if(!function_exists('render_thumbnail_url')){
    function render_thumbnail_url($object = []){

        if(empty($object))
            return false;

        if(isset($object['thumbnail'])){
            if(file_exists(public_path().'/storage/images/'.$object['thumbnail'])){
                $object['thumbnail'] = asset('/storage/images/'.$object['thumbnail']);
            }
        }

        if(isset($object['name'])){
            if(file_exists(public_path().'/storage/gallery/images/'.$object['name'])){
                $object['name'] = asset('/storage/gallery/images/'.$object['name']);
            }
        }

        return $object;
    }
}