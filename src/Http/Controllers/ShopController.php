<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(): View
    {
        return view('shop');
    }
}
