<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\User;
use Atom\Core\Models\UserCurrency;
use Atom\Core\Models\UserSetting;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(): View
    {
        $credits = User::orderBy('credits', 'desc')
            ->limit(10)
            ->get();

        $duckets = UserCurrency::with('user')
            ->whereType(0)
            ->orderBy('amount', 'desc')
            ->limit(10)
            ->get();

        $diamonds = UserCurrency::with('user')
            ->whereType(5)
            ->orderBy('amount', 'desc')
            ->limit(10)
            ->get();

        $onlineTimes = UserSetting::with('user')
            ->orderBy('online_time', 'desc')
            ->limit(10)
            ->get();

        $respects = UserSetting::with('user')
            ->orderBy('respects_received', 'desc')
            ->limit(10)
            ->get();

        $achievements = UserSetting::with('user')
            ->orderBy('achievement_score', 'desc')
            ->limit(10)
            ->get();

        return view('leaderboards', compact('credits', 'duckets', 'diamonds', 'onlineTimes', 'respects', 'achievements'));
    }
}
