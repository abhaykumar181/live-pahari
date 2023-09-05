<?php

use Illuminate\Support\Facades\Route;

// Admin Routes
Route::group(['as'=>'admin.'], function(){
    //Web Routes for Admin login
    Route::group(['controller'=>App\Http\Controllers\Backend\AdminloginController::class],function(){
        Route::get('/admin-login','login')->name('login');
        Route::post('/admin-login','checklogin')->name('checklogin');
    });

    Route::middleware(['auth'])->group(function(){
        // Web Routes for Dashboard
        Route::group(['prefix'=>'admin' ,'controller'=>App\Http\Controllers\Backend\DashboardController::class],function(){
            Route::get('/dashboard','dashboard')->name('dashboard');
            Route::get('/admin-logout','logout')->name('logout');

            // Web Routes for Locations
            Route::group(['as'=>'locations.','prefix'=>'locations', 'controller'=>App\Http\Controllers\Backend\LocationController::class],function(){
                Route::get('/','index')->name('index');
                Route::get('/edit/{locationId}','edit')->name('edit');
                Route::post('/','store')->name('store');
            });

            // Web Routes for Testimonials
            Route::group(['as'=>'testimonials.','prefix'=>'testimonials','controller'=>App\Http\Controllers\Backend\TestimonialController::class], function(){
                Route::get('/','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/create','store')->name('store');
                Route::get('/edit/{testimonialId}','edit')->name('edit');
                Route::get('/delete/{testimonialId}','delete')->name('delete');
            });

            // Web Routes for Addons
            Route::group(['as'=>'addons.','prefix'=>'addons','controller'=>App\Http\Controllers\Backend\AddonsController::class], function(){
                Route::get('/','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/create','store')->name('store');
                Route::get('/edit/{addonId}','edit')->name('edit');
                Route::get('/delete/{addonId}','delete')->name('delete');
            });

            // Web Routes for Properties
            Route::group(['as'=>'properties.','prefix'=>'properties','controller'=>App\Http\Controllers\Backend\PropertiesController::class], function(){
                Route::get('/','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/create','store')->name('store');
                Route::get('/edit/{propertyId}','edit')->name('edit');
                Route::get('/delete/{propertyId}','delete')->name('delete');
            });

            // Web Routes for Packages
            Route::group(['as'=>'packages.', 'prefix'=>'packages', 'controller'=>App\Http\Controllers\Backend\PackageController::class], function(){
                Route::get('/','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/create','store')->name('store');
                Route::get('/edit/{packageId}','edit')->name('edit');
                Route::get('/delete/{packageId}','delete')->name('delete');
                Route::get('/itineraries/{packageId}','itineraries')->name('itineraries');
                Route::post('/get-accordion','gerItineraries')->name('accordion');
                Route::post('/store-itineraries','storeItineraries')->name('storeitineraries');
                Route::get('/gallery/{packageId}','gallery')->name('gallery');
                Route::post('/store-galleryimages','storeGalleryImages')->name('storegalleryImages');
                Route::get('/delete-thumbnail/{thumbnailId}','deleteThumbnail')->name('deleteThumbnail');
            });

            // Web Routes for Pages
            Route::group(['as'=>'pages.', 'prefix'=>'pages','controller'=>App\Http\Controllers\Backend\PageController::class], function(){
                Route::get('/','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/create','store')->name('store');
                Route::get('/edit/{pageId}','edit')->name('edit');
                Route::get('/delete/{pageId}','delete')->name('delete');
            });

            //Web Routes for Settings
            Route::group(['as'=>'settings.', 'prefix'=>'settings', 'controller'=>App\Http\Controllers\Backend\SettingsController::class], function(){
                Route::get('/','index')->name('index');
                Route::post('/create','store')->name('store');
            });          
        });
    });    
});

// Web Routes for email.
Route::group(['as'=>'bookings.', 'prefix' => 'bookings', 'controller' => App\Http\Controllers\BookingController::class], function(){
    Route::get('/confirmation/{id}', 'viewDetails')->name('viewDetails');
    Route::post('/property-action', 'propertyActions')->name('propertyActions');
}); 
