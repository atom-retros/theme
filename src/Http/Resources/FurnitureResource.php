<?php

namespace Atom\Theme\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class FurnitureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'key' => $this->item_name,
            'name' => $this->furnitureData?->name,
            'description' => $this->furnitureData?->description,
            'url' => Storage::disk('furniture_icons')->url(sprintf('%s_icon.png', str_replace('*', '_', $this->item_name))),
            'in_circulation' => $this->items->count(),
        ];
    }
}
