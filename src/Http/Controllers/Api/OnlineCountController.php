<?php

namespace Atom\Theme\Http\Controllers\Api;

use Atom\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class OnlineCountController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $online = User::where('online', '1')
            ->count();

        return response()->json(compact('online'))
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
