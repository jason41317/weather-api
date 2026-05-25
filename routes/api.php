<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;


Route::group(['prefix' => 'v1'], function() {
  Route::get('/weather/{city}', [WeatherController::class, 'show']);
  Route::get('/weather/{city}/cached', [WeatherController::class, 'cached']);
});


