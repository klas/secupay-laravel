<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function getServerTime(): JsonResponse
    {
        return response()->json([
            'server_time' => now()->toISOString(),
            'timestamp' => now()->timestamp,
            'timezone' => config('app.timezone')
        ]);
    }
}
