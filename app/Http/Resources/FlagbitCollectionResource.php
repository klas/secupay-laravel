<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FlagbitCollectionResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'trans_id' => $this->additional['trans_id'] ?? null,
            'active_flagbits' => FlagbitResource::collection($this->collection),
            'count' => $this->collection->count(),
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
