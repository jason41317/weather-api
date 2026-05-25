<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_weather_endpoint_returns_successful_response(): void
    {
        Http::fake([
            '*' => Http::response([
                'name' => 'Manila',
                'main' => [
                    'temp' => 30
                ],
                'weather' => [
                    [
                        'description' => 'clear sky'
                    ]
                ]
            ]),
        ]);

        $response = $this->getJson('/api/v1/weather/manila');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'city',
                    'temperature',
                    'description',
                    'timestamp',
                    'source',
                ]
            ]);
    }
}
