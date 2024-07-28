<?php

namespace Atom\Theme\Http\Controllers\Api;

use Atom\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Atom\Theme\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user): JsonResponse
    {
        return UserResource::make($user)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
