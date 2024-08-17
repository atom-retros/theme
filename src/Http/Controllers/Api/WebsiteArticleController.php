<?php

namespace Atom\Theme\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Atom\Core\Models\WebsiteArticle;
use Atom\Theme\Http\Resources\WebsiteArticleResource;

class WebsiteArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $articles = WebsiteArticle::with('user')
            ->where('is_published', true)
            ->latest('id')
            ->paginate(20);

        return WebsiteArticleResource::collection($articles)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }

    /**
     * Show the specified resource in storage.
     */
    public function show(Request $request, WebsiteArticle $websiteArticle): JsonResponse
    {
        $websiteArticle->load('user');

        return WebsiteArticleResource::make($websiteArticle)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
