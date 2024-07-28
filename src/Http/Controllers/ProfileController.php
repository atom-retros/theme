<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\View\View;
use Atom\Core\Models\User;
use Illuminate\Routing\Controller;
use Atom\Core\Models\WebsiteArticle;

class ProfileController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(User $user): View
    {
        $user->load('friends');

        $articles = WebsiteArticle::latest('id')
            ->limit(5)
            ->get();

        return view('profile', compact('user', 'articles'));
    }
}
