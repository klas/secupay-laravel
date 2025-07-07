<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FlagbitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FlagbitController extends Controller
{
    private FlagbitService $flagbitService;

    public function __construct(FlagbitService $flagbitService)
    {
        $this->flagbitService = $flagbitService;
    }

    public function getActiveFlagbits(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'trans_id' => 'required|integer|min:1'
            ]);

            $apiKey = $request->input('api_key');
            $transId = $request->input('trans_id');

            $flagbits = $this->flagbitService->getActiveFlagbits($transId, $apiKey);

            return response()->json([
                'trans_id' => $transId,
                'active_flagbits' => $flagbits
            ]);

        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function setFlagbit(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'trans_id' => 'required|integer|min:1',
                'flagbit_id' => 'required|integer|min:1|max:15'
            ]);

            $apiKey = $request->input('api_key');
            $transId = $request->input('trans_id');
            $flagbitId = $request->input('flagbit_id');

            $this->flagbitService->setFlagbit($transId, $flagbitId, $apiKey);

            return response()->json([
                'message' => 'Flagbit set successfully',
                'trans_id' => $transId,
                'flagbit_id' => $flagbitId
            ]);

        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function removeFlagbit(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'trans_id' => 'required|integer|min:1',
                'flagbit_id' => 'required|integer|min:1|max:15'
            ]);

            $apiKey = $request->input('api_key');
            $transId = $request->input('trans_id');
            $flagbitId = $request->input('flagbit_id');

            $this->flagbitService->removeFlagbit($transId, $flagbitId, $apiKey);

            return response()->json([
                'message' => 'Flagbit removed successfully',
                'trans_id' => $transId,
                'flagbit_id' => $flagbitId
            ]);

        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getFlagbitHistory(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'trans_id' => 'required|integer|min:1'
            ]);

            $apiKey = $request->input('api_key');
            $transId = $request->input('trans_id');

            $history = $this->flagbitService->getFlagbitHistory($transId, $apiKey);

            return response()->json([
                'trans_id' => $transId,
                'flagbit_history' => $history
            ]);

        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
