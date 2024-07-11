<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(User $user): View
    {
        $user->load('friends', 'guildMembers.guild');

        return view('profile', compact('user'));
    }
}
