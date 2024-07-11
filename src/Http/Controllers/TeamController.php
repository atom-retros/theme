<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Atom\Core\Models\WebsiteTeam;
use Illuminate\Routing\Controller;
use Atom\Core\Models\WebsiteSetting;

class TeamController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(Request $request): View
    {
        $settings = WebsiteSetting::whereIn('key', ['min_rank_to_see_hidden_staff'])
            ->pluck('value', 'key');

        $teams = WebsiteTeam::with('users')
            ->when($request->user()->rank < $settings->get('min_rank_to_see_hidden_staff', 6), fn ($query) => $query->where('hidden_rank', false))
            ->get();

        return view('teams', compact('teams'));
    }
}
