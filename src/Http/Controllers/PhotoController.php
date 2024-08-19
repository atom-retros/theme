<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\View\View;
use Atom\Core\Models\CameraWeb;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Atom\Theme\Http\Requests\ReactionUpdateRequest;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $photos = CameraWeb::with('user', 'reactions')
            ->latest('id')
            ->where('approved', true)
            ->paginate(10);

        return view('photos', compact('photos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReactionUpdateRequest $request, CameraWeb $cameraWeb): RedirectResponse
    {
        $reaction = $cameraWeb->reactions()
            ->where('user_id', $request->user()->id)
            ->where('reaction', $request->get('reaction'));

        match ($reaction->exists()) {
            true => $reaction->delete(),
            false => $article->reactions()
                ->create([
                    'user_id' => $request->user()->id,
                    'reaction' => $request->get('reaction'),
                ]),
        };

        return redirect()
            ->back();
    }
}
