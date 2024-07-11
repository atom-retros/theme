<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(): View
    {
        $credits = User::with(['currencies' => fn ($query) => $query->where('type', 0)])
            ->whereHas('currencies', fn ($query) => $query->where('type', 0))
            ->join('users_currency', 'users.id', '=', 'users_currency.user_id')
            ->where('users_currency.type', 0)
            ->orderBy('users_currency.amount', 'desc')
            ->select('users.*')
            ->limit(10)
            ->get();

        $duckets = User::with(['currencies' => fn ($query) => $query->where('type', 5)])
            ->whereHas('currencies', fn ($query) => $query->where('type', 5))
            ->join('users_currency', 'users.id', '=', 'users_currency.user_id')
            ->where('users_currency.type', 5)
            ->orderBy('users_currency.amount', 'desc')
            ->select('users.*')
            ->limit(10)
            ->get();

        $diamonds = User::with(['currencies' => fn ($query) => $query->where('type', 101)])
            ->whereHas('currencies', fn ($query) => $query->where('type', 101))
            ->join('users_currency', 'users.id', '=', 'users_currency.user_id')
            ->where('users_currency.type', 101)
            ->orderBy('users_currency.amount', 'desc')
            ->select('users.*')
            ->limit(10)
            ->get();

        $onlineTimes = User::with('settings')
            ->join('users_settings', 'users.id', '=', 'users_settings.user_id')
            ->orderBy('users_settings.online_time', 'desc')
            ->select('users.*')
            ->limit(10)
            ->get();

        $respects = User::with('settings')
            ->join('users_settings', 'users.id', '=', 'users_settings.user_id')
            ->orderBy('users_settings.respects_received', 'desc')
            ->select('users.*')
            ->limit(10)
            ->get();

        $achievements = User::with('settings')
            ->join('users_settings', 'users.id', '=', 'users_settings.user_id')
            ->orderBy('users_settings.achievement_score', 'desc')
            ->select('users.*')
            ->limit(10)
            ->get();

        return view('leaderboards', compact('credits', 'duckets', 'diamonds', 'onlineTimes', 'respects', 'achievements'));
    }
}
