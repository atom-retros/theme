<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\WebsiteArticle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(Request $request): View
    {
        $article = WebsiteArticle::latest('id')
            ->first();

        return view('home', compact('article'));
    }
}
