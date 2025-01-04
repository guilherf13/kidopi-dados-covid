<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterDataCountryRequest;
use App\Services\CovidDataService;
use Illuminate\Http\JsonResponse;

class CovidDataController extends Controller
{
    public function __construct(private CovidDataService $covidDataService)
    {
    }
    
    public function filterDataCountry(FilterDataCountryRequest $request): JsonResponse
    {
        $data = $this->covidDataService->filterDataCountry($request);

        if($data['status'] === 'error'){
            return $this->sendError($data);
        }

        return $this->sendSucess($data);
    }
}
