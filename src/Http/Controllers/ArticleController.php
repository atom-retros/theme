<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Atom\Core\Models\WebsiteArticle;
use Illuminate\Http\RedirectResponse;
use Atom\Theme\Http\Requests\ReactionUpdateRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $articles = WebsiteArticle::with('user')
            ->latest()
            ->get();

        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(WebsiteArticle $article): View
    {
        $article->load('user', 'comments.user', 'reactions.user');

        $articles = WebsiteArticle::with('user', 'comments.user', 'reactions.user')
            ->latest()
            ->limit(15)
            ->get();

        return view('articles.show', compact('article', 'articles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReactionUpdateRequest $request, WebsiteArticle $article): RedirectResponse
    {
        $reaction = $article->reactions()
            ->where('user_id', $request->user()->id)
            ->where('reaction', $request->get('reaction'));

        match ($reaction->exists()) {
            true => $reaction->delete(),
            false => $article->reactions()
                ->create([
                    'user_id' => $request->user()->id,
                    'reaction' => $request->get('reaction'),
                    'active' => true,
                ]),
        };

        return redirect()
            ->back();
    }
}
