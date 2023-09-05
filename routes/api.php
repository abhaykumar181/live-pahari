<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('packages', App\Http\Controllers\Api\PackageController::class);
Route::resource('locations', App\Http\Controllers\Api\LocationController::class);
Route::resource('addons', App\Http\Controllers\Api\AddonsController::class);
Route::resource('properties', App\Http\Controllers\Api\PropertiesController::class);
Route::resource('testimonials', App\Http\Controllers\Api\TestimonialController::class);
Route::resource('bookings', App\Http\Controllers\Api\BookingsController::class);
Route::post('/make-order', [App\Http\Controllers\Api\BookingsController::class,'makeOrder']);
Route::post('/update-order', [App\Http\Controllers\Api\BookingsController::class,'updateOrder']);
Route::post('/update-property-order', [App\Http\Controllers\Api\BookingsController::class,'updatePropertyOrder']);
