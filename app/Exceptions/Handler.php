<?php

namespace App\Exceptions;

use App\Exceptions\WeatherServiceException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Validation\ValidationException;

public function render($request, Throwable $e)
{
    // Validation errors
    if ($e instanceof ValidationException) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }

    // Weather service errors (your custom domain error)
    if ($e instanceof WeatherServiceException) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'error_code' => 'WEATHER_SERVICE_ERROR',
        ], 400);
    }

    // HTTP client errors (OpenWeather, etc.)
    if ($e instanceof RequestException) {
        return response()->json([
            'success' => false,
            'message' => 'External API request failed',
            'error_code' => 'EXTERNAL_API_ERROR',
        ], 502);
    }

    // Default fallback
    return response()->json([
        'success' => false,
        'message' => 'Server error',
    ], 500);
}
?>