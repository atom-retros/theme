<?php

namespace Atom\Theme\Http\Controllers\Api;

use Illuminate\Http\Request;
use Atom\Core\Models\ItemBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Atom\Theme\Http\Resources\FurnitureResource;

class FurnitureController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $items = ItemBase::with('items.user', 'catalogItems', 'furnitureData')
            ->whereHas('items')
            ->whereHas('catalogItems', fn ($query) => $query->where('cost_credits', '>', 0)->orderBy('cost_credits', 'ASC'))
            ->whereHas('items.user', fn ($query) => $query->where('rank', '<', 4))
            ->where('allow_trade', '1')
            ->whereIn('interaction_type', ['default', 'dice', 'clothing'])
            ->paginate(20);

        return FurnitureResource::collection($items)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
