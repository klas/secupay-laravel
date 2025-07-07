<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetActiveFlagbitsRequest;
use App\Http\Requests\SetFlagbitRequest;
use App\Http\Requests\RemoveFlagbitRequest;
use App\Http\Requests\GetFlagbitHistoryRequest;
use App\Http\Resources\FlagbitCollectionResource;
use App\Http\Resources\FlagbitActionResource;
use App\Http\Resources\FlagbitHistoryResource;
use App\Services\FlagbitService;
use Illuminate\Http\JsonResponse;

class FlagbitController extends Controller
{
    private FlagbitService $flagbitService;

    public function __construct(FlagbitService $flagbitService)
    {
        $this->flagbitService = $flagbitService;
    }

    /**
     * Get active flagbits for a transaction
     */
    public function getActiveFlagbits(GetActiveFlagbitsRequest $request): JsonResponse
    {
        try {
            $data = $request->validatedData();

            $flagbits = $this->flagbitService->getActiveFlagbits(
                $data['trans_id'],
                $data['api_key']
            );

            return (new FlagbitCollectionResource($flagbits))
                ->additional(['trans_id' => $data['trans_id']])
                ->response();

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 404);
        }
    }

    /**
     * Set a flagbit for a transaction
     */
    public function setFlagbit(SetFlagbitRequest $request): JsonResponse
    {
        try {
            $data = $request->validatedData();

            $this->flagbitService->setFlagbit(
                $data['trans_id'],
                $data['flagbit_id'],
                $data['api_key']
            );

            $responseData = [
                'message' => 'Flagbit set successfully',
                'trans_id' => $data['trans_id'],
                'flagbit_id' => $data['flagbit_id'],
                'action' => 'set'
            ];

            return (new FlagbitActionResource($responseData))->response();

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    /**
     * Remove a flagbit from a transaction
     */
    public function removeFlagbit(RemoveFlagbitRequest $request): JsonResponse
    {
        try {
            $data = $request->validatedData();

            $this->flagbitService->removeFlagbit(
                $data['trans_id'],
                $data['flagbit_id'],
                $data['api_key']
            );

            $responseData = [
                'message' => 'Flagbit removed successfully',
                'trans_id' => $data['trans_id'],
                'flagbit_id' => $data['flagbit_id'],
                'action' => 'remove'
            ];

            return (new FlagbitActionResource($responseData))->response();

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    /**
     * Get flagbit history for a transaction
     */
    public function getFlagbitHistory(GetFlagbitHistoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validatedData();

            $history = $this->flagbitService->getFlagbitHistory(
                $data['trans_id'],
                $data['api_key']
            );

            return (new FlagbitHistoryResource($history))
                ->additional(['trans_id' => $data['trans_id']])
                ->response();

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 404);
        }
    }
}
