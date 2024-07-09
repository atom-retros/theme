<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\WebsiteTeam;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(): View
    {
        $teams = WebsiteTeam::with('users')
            ->get();

        return view('teams', compact('teams'));
    }
}
