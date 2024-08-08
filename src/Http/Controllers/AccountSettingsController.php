<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\View\View;
use Atom\Core\Models\User;
use Illuminate\Routing\Controller;
use Atom\Theme\Http\Requests\AccountStoreRequest;
use Illuminate\Container\Attributes\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('account-settings');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountStoreRequest $request): RedirectResponse
    {
        $user = User::find($request->user()->id);
        $user->update($request->validated());

        return redirect()->back();
    }
}
