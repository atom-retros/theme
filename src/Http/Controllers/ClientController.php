<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(Request $request): View
    {
        $request->user()->update([
            'auth_ticket' => str()->uuid(),
        ]);

        return view('client');
    }
}
