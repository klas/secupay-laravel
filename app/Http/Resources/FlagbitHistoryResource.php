<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FlagbitHistoryResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'trans_id' => $this->additional['trans_id'] ?? null,
            'flagbit_history' => FlagbitResource::collection($this->collection),
            'total_records' => $this->collection->count(),
        ];
    }

    public function with(Request $request): array
    {
        return [
            'status' => 'success',
            'timestamp' => now()->toISOString(),
        ];
    }
}
