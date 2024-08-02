<?php

namespace Atom\Theme\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Atom\Core\Models\WebsiteHomeCategory;
use Atom\Theme\Http\Resources\WebsiteHomeCategoryResource;

class HomeCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $categories = WebsiteHomeCategory::with('children')
            ->where('permission_id', '>=', $request->user()->rank)
            ->whereNull('website_home_category_id')
            ->get();

        return WebsiteHomeCategoryResource::collection($categories)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
