<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    Route::get('countries', [CountryController::class, 'index']);
    Route::get('countries/all', [CountryController::class, 'indexAll']);
    Route::post('countries/add', [CountryController::class, 'store']);
    Route::get('countries/txt', [CountryController::class, 'txt']);
    Route::get('cities', [CityController::class, 'index']);
    Route::post('cities/add', [CityController::class, 'store']);
    Route::get('locations', [LocationController::class, 'index']);
    Route::post('locations/add', [LocationController::class, 'store']);
});

