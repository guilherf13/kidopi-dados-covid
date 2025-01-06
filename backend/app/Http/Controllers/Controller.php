<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

//Padrão de resposta para os endpoints, estruturando respostas de sucesso e erro com dados em formato JSON.
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
