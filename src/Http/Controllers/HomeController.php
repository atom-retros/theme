<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Atom\Core\Models\WebsiteArticle;

class HomeController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(Request $request): View
    {
        $articles = WebsiteArticle::latest('id')
            ->limit(5)
            ->get();

        $article = WebsiteArticle::latest('id')
            ->first();

        return view('home', compact('articles', 'article'));
    }
}
