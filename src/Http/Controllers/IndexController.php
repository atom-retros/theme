<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\WebsiteArticle;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(): View
    {
        $articles = WebsiteArticle::latest('id')
            ->with('user')
            ->limit(4)
            ->get();

        return view('index', compact('articles'));
    }
}
