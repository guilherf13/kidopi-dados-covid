<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterDataCountryRequest;
use App\Services\CovidDataService;
use Illuminate\Http\JsonResponse;

class CovidDataController extends Controller
{
    private CovidDataService $covidDataService;

    public function __construct(CovidDataService $covidDataService)
    {
        $this->covidDataService = $covidDataService;
    }
    
    public function filterDataCountry(FilterDataCountryRequest $request): JsonResponse
    {
        return response()->json($this->covidDataService->filterDataCountry($request));
    }
}
