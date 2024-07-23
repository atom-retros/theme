<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\User;
use Atom\Core\Models\WebsiteArticle;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(User $user): View
    {
        $articles = WebsiteArticle::latest('id')
            ->limit(5)
            ->get();

        $user->load('friends');

        return view('profile', compact('articles', 'user'));
    }
}
