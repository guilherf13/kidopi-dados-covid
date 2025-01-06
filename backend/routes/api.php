<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CovidDataController;


Route::prefix('v1')->group(function (){
    Route::get('/covid-data', [CovidDataController::class, 'filterDataCountry']);
    Route::get('/acess-data', [CovidDataController::class, 'acessData']);
    Route::get('/covid-country', [CovidDataController::class, 'covidCountry']);
});

Route::fallback(function(){
    return response()
        ->json(['message' => 'Page Not Found!'], 404);
});
