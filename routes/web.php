<?php

use Illuminate\Support\Facades\Route;

// Admin Routes
Route::group(['as'=>'admin.'], function(){
    // Admin Login Route 
    Route::group(['controller'=>App\Http\Controllers\backend\AdminloginController::class],function(){
        Route::get('/admin-login','login')->name('login');
        Route::post('/admin-login','checklogin')->name('checklogin');
    });

    Route::middleware(['auth'])->group(function(){
        // Admin Dashboard Routes
        Route::group(['prefix'=>'admin' ,'controller'=>App\Http\Controllers\backend\DashboardController::class],function(){
            Route::get('/dashboard','dashboard')->name('dashboard');
            Route::get('/admin-logout','logout')->name('logout');
        });

    });

    
});