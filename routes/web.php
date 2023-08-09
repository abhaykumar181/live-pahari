<?php

use Illuminate\Support\Facades\Route;

// Admin Routes
Route::group(['as'=>'admin.'], function(){
    // Admin Login Route 
    Route::group(['controller'=>App\Http\Controllers\Backend\AdminloginController::class],function(){
        Route::get('/admin-login','login')->name('login');
        Route::post('/admin-login','checklogin')->name('checklogin');
    });

    Route::middleware(['auth'])->group(function(){
        // Admin Dashboard Routes
        Route::group(['prefix'=>'admin' ,'controller'=>App\Http\Controllers\Backend\DashboardController::class],function(){
            Route::get('/dashboard','dashboard')->name('dashboard');
            Route::get('/admin-logout','logout')->name('logout');

            // Admin Locations Routes
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
                Route::post('/edit','store')->name('update');
                Route::get('/delete/{testimonialId}','delete')->name('delete');
            });

        });

    });

    
});