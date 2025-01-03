<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CovidDataController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function (){
    Route::get('/covid-data', [CovidDataController::class, 'filterDataCountry']);
});

Route::fallback(function(){
    return response()
        ->json(['message' => 'Page Not Found!'], 404);
});
