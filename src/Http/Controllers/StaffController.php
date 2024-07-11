<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\View\View;
use Atom\Core\Models\Permission;
use Atom\Core\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StaffController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(Request $request): View
    {
        $settings = WebsiteSetting::whereIn('key', ['staff_min_rank', 'min_rank_to_see_hidden_staff'])
            ->pluck('value', 'key');

        $permissions = Permission::with('users')
            ->where('level', '>=', $settings->get('staff_min_rank', 4))
            ->when($request->user()->rank < $settings->get('min_rank_to_see_hidden_staff', 6), fn ($query) => $query->where('hidden_rank', false)->whereRelation('users', 'hidden_staff', false))
            ->get();

        return view('staff', compact('permissions'));
    }
}
