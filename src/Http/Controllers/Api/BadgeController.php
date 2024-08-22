<?php

namespace Atom\Theme\Http\Controllers\Api;

use Atom\Core\Models\Badge;
use Atom\Theme\Http\Resources\BadgeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $badges = Badge::latest('id')
            ->paginate(20);

        return BadgeResource::collection($badges)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }

    /**
     * Show the specified resource in storage.
     */
    public function show(Request $request, Badge $badge): JsonResponse
    {
        return BadgeResource::make($badge)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
