<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\CameraWeb;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PhotoController extends Controller
{
    /**
     * Handle an incoming request.
     */
    public function __invoke(): View
    {
        $photos = CameraWeb::with('user')
            ->latest('id')
            ->where('approved', true)
            ->get();

        return view('photos', compact('photos'));
    }
}
