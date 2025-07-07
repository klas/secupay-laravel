<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiKeyAuth
{
    public function handle(Request $request, Closure $next, ?string $requireMasterKey = null): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'API key required'], 401);
        }

        $token = str_replace('Bearer ', '', $token);

        $apiKey = ApiKey::with('zeitraum', 'vertrag')->where('apikey', $token)->first();

        if (!$apiKey || !$apiKey->isValid()) {
            return response()->json(['error' => 'Invalid or expired API key'], 401);
        }

        if ($requireMasterKey === 'master' && !$apiKey->ist_masterkey) {
            return response()->json(['error' => 'Master key required'], 403);
        }

        $request->merge(['api_key' => $apiKey]);

        return $next($request);
    }
}
