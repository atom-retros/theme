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
        $queryParams = $request->query();

        $request->user()->auth_ticket = str()->uuid()->toString();
        $request->user()->save();

        return view('client', [
            'url' => sprintf('%s?%s', config('nitro.client_url'), http_build_query([
                ...$queryParams,
                'sso' => $request->user()->auth_ticket,
            ])),
        ]);
    }
}
