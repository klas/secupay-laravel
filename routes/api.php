<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\FlagbitController;
use App\Http\Middleware\ApiKeyAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
	Route::get('/time', [ApiController::class, 'getServerTime']);

	Route::middleware([ApiKeyAuth::class])->group(function () {
		Route::get('/flagbits/active', [FlagbitController::class, 'getActiveFlagbits']);
		Route::get('/flagbits/history', [FlagbitController::class, 'getFlagbitHistory']);
	});

	Route::middleware([ApiKeyAuth::class . ':master'])->group(function () {
		Route::post('/flagbits/set', [FlagbitController::class, 'setFlagbit']);
		Route::delete('/flagbits/remove', [FlagbitController::class, 'removeFlagbit']);
	});
});

// Add documentation route
Route::get('/', function () {
    return response()->json([
        'name' => 'Secupay API',
        'version' => '1.0',
        'documentation' => '/api/documentation',
    ]);
});

