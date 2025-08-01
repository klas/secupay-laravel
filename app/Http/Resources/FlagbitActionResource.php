<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlagbitActionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->resource['message'],
            'trans_id' => $this->resource['trans_id'],
            'flagbit_id' => $this->resource['flagbit_id'],
            'action' => $this->resource['action'] ?? 'processed',
            'timestamp' => now()->toISOString(),
        ];
    }

    public function with(Request $request): array
    {
        return [
            'status' => 'success',
        ];
    }
}
