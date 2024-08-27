<?php

namespace Atom\Theme\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Atom\Core\Models\WebsiteHelpCenterTicket;
use Atom\Theme\Http\Requests\TicketReplyStoreRequest;

class TicketReplyController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function __invoke(TicketReplyStoreRequest $request, WebsiteHelpCenterTicket $ticket): RedirectResponse
    {
        abort_if($ticket->user_id !== $request->user()->id, 403);
        
        $ticket->replies()
            ->create($request->validated());

        return redirect()
            ->route('help-center.tickets.show', $ticket);
    }
}
