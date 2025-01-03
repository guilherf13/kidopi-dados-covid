<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CovidDataTest extends TestCase
{
    /**
     * Testa se a rota /api/v1/covid-data retorna sucesso para um país válido
     */
    public function test_filter_data_country_returns_success_for_valid_country(): void
    {
        $response = $this->get('/api/v1/covid-data?country=Brazil');

        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data', 
            'status', 
            'mensage',
            'status_code'
        ]);
    }
}
