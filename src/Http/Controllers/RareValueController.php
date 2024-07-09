<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\WebsiteRareValueCategory;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class RareValueController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(): View
    {
        $categories = WebsiteRareValueCategory::orderBy('priority')
            ->with('rareValues.item')
            ->get();

        return view('rare-values', compact('categories'));
    }
}
