<?php

namespace Atom\Theme\Http\Controllers\Api;

use Atom\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Atom\Theme\Http\Resources\UserResource;

class OnlineUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $online = User::where('online', '1')
            ->latest('id')
            ->paginate(20);

        return UserResource::collection($online)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
