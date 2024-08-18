<?php

namespace Atom\Theme\Http\Controllers\Api;

use Atom\Core\Models\CatalogItem;
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
        $items = CatalogItem::with('itemBase', 'itemBase.items.user', 'itemBase.furnitureData')
            ->whereHas('itemBase.items')
            ->whereHas('itemBase.furnitureData')
            ->whereHas('itemBase.items.user', fn ($query) => $query->where('rank', '<', 4))
            ->where('cost_credits', '>', 0)
            ->where('club_only', '1')
            ->orderBy('cost_credits', 'DESC')
            ->get()
            ->unique('item_ids');

        return FurnitureResource::collection($items)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
