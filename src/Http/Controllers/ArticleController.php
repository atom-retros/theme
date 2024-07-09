<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\WebsiteArticle;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $articles = WebsiteArticle::with('user')
            ->latest()
            ->get();

        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(WebsiteArticle $article): View
    {
        $article->load('user', 'comments.user', 'reactions.user');

        $articles = WebsiteArticle::with('user', 'comments.user', 'reactions.user')
            ->latest()
            ->limit(15)
            ->get();

        return view('articles.show', compact('article', 'articles'));
    }
}
