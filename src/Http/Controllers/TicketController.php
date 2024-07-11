<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\WebsiteHelpCenterCategory;
use Atom\Core\Models\WebsiteHelpCenterTicket;
use Atom\Theme\Http\Requests\TicketStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tickets = $request->user()
            ->tickets()
            ->with('category')
            ->latest()
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $categories = WebsiteHelpCenterCategory::all();

        $tickets = $request->user()
            ->tickets()
            ->with('category')
            ->latest()
            ->get();

        return view('tickets.create', compact('categories', 'tickets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketStoreRequest $request): RedirectResponse
    {
        $ticket = $request->user()
            ->tickets()
            ->create($request->validated());

        return redirect()
            ->route('help-center.tickets.show', $ticket);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, WebsiteHelpCenterTicket $ticket): View
    {
        $tickets = $request->user()
            ->tickets()
            ->with('category')
            ->latest()
            ->get();

        return view('tickets.show', compact('ticket', 'tickets'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, WebsiteHelpCenterTicket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()
            ->route('help-center.tickets.index');
    }
}
