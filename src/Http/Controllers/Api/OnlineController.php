<?php

namespace Atom\Theme\Http\Controllers\Api;

use Atom\Core\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class OnlineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $online = User::where('online', true)
            ->count();

        return response()->json(compact('online'))
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
