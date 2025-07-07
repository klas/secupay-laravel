<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Constants\DataFlag;

class FlagbitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'flagbit_id' => $this->flagbit,
            'name' => DataFlag::getFlagName($this->flagbit),
            'description' => $this->whenLoaded('flagbitDefinition', $this->flagbitDefinition?->beschreibung),
            'set_at' => $this->timestamp,
            'valid_from' => $this->whenLoaded('zeitraum', $this->zeitraum?->von),
            'valid_to' => $this->whenLoaded('zeitraum', $this->zeitraum?->bis),
            'is_active' => $this->when(
                $this->relationLoaded('zeitraum'),
                fn() => $this->isActive()
            )
        ];
    }
}
