<?php
use Illuminate\Support\str;
use App\Models\Packages;
use App\Models\Addons;
use App\Models\Properties;
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

/**
 * Find Package Name
 * 
 * @since 1.0.0
 * 
 * @return packageName
 */

if(!function_exists('getPackageName')){
    function getPackageName($packageId){
        return Packages::find($packageId)->title;
    }
}


/**
 * Find Addon Name
 * 
 * @since 1.0.0
 * 
 * @return AddonName
 */

 if(!function_exists('getAddonName')){
    function getAddonName($addonId){
        return Addons::find($addonId)->title;
    }
}


/**
 * Find Property Name
 * 
 * @since 1.0.0
 * 
 * @return propertyName
 */

 if(!function_exists('getPropertyName')){
    function getPropertyName($propertyId){
        return Properties::find($propertyId)->title;
    }
}
