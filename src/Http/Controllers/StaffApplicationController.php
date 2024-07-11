<?php

namespace Atom\Theme\Http\Controllers;

use Atom\Core\Models\WebsiteOpenPosition;
use Atom\Theme\Http\Requests\StaffApplicationStoreRequest;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class StaffApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $positions = WebsiteOpenPosition::with('permission')
            ->where('apply_from', '<=', now())
            ->where('apply_to', '>', now())
            ->get();

        return view('staff-applications.index', compact('positions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(WebsiteOpenPosition $staffApplication): View
    {
        $position = $staffApplication->load('permission');

        return view('staff-applications.show', compact('position'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffApplicationStoreRequest $request)
    {
        $position = WebsiteOpenPosition::findOrFail($request->get('position_id'));

        $request->user()
            ->staffApplications()
            ->create($request->validated());

        return redirect()
            ->route('community.staff-applications.show', $position)
            ->with('success', 'Your application has been submitted successfully.');
    }
}
