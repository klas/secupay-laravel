<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ApiKeyAuth
{
    public function handle(Request $request, Closure $next, ?string $requireMasterKey = null): JsonResponse
    {
        $token = $request->header('Authorization');
        $validator = Validator::make(['token' => $token], ['token' => ['required', 'string']]);

        if ($validator->fails()) {
            return response()->json(['error' => 'API key required'], 401);
        }

        $token = $validator->validated()['token'];

        $token = str_replace('Bearer ', '', $token);

        $apiKey = ApiKey::with('zeitraum', 'vertrag')->where('apikey', '=', $token)->first();

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
