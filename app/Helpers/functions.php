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

/**
 * Get slug
 */
if(!function_exists('getSlug')){
    function getSlug($value=''){
        return str::slug($value);
    }
}

/**
 * Set text limit
 */
if(!function_exists('setTextlimit')){
    function setTextlimit($text=''){
        return str::limit($text,130);
    }
}



/**
 * Print and test data in anywhere 
 */
if (!function_exists('pr')) {
    function pr($array = []) {
        echo '<pre>'; print_r($array); echo '</pre>';
    }
}

/**
 * Get thumbnail url
 */
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
 * Get package Name
 */

if(!function_exists('getPackageDetails')){
    function getPackageDetails($packageId=''){
        return Packages::find($packageId);
    }
}


/**
 * Get addon details
 */
 if(!function_exists('getAddonDetails')){
    function getAddonDetails($addonId=''){
        return Addons::find($addonId);
    }
}


/**
 * Get property details.
 */
 if(!function_exists('getPropertyDetails')){
    function getPropertyDetails($propertyId=''){
        return Properties::find($propertyId);
    }
}
