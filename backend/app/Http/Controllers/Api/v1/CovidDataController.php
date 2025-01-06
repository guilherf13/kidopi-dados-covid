<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterDataCountryRequest;
use App\Services\CovidDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function acessData(): JsonResponse
    {
        $acess = $this->covidDataService->acessData();
        return $this->sendSucess($acess);
    }

    public function covidCountry(Request $request): JsonResponse
    {
        $queryParams = $request->input('country');
        $data = $this->covidDataService->covidCountry($queryParams);
        return $this->sendSucess($data);
    }
}
