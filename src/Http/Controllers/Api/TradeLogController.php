<?php

namespace Atom\Theme\Http\Controllers\Api;

use Atom\Core\Models\RoomTradeLog;
use Atom\Theme\Http\Resources\TradeLogResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TradeLogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $roomTradeLogs = RoomTradeLog::with(['items', 'items.item', 'items.item.catalogItems' => fn (Builder $query) => $query->where('club_only', '1')])
            ->latest('id')
            ->paginate(20);

        return TradeLogResource::collection($roomTradeLogs)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
