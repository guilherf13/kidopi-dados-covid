<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function sendError(array $data = [], int $code = 400, ): JsonResponse
    {
        return response()->json(['data' => $data], $code);
        
    }

    public function sendSucess(array $data = [], int $code = 200, ): JsonResponse
    {
        return response()->json(['data' => $data], $code);
    }
}
