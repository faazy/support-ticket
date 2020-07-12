<?php

namespace App\Http\Controllers;

use App\Entities\Tickets\Ticket;
use App\Entities\Tickets\TicketReply;
use App\Notifications\TicketOpened;
use App\Notifications\TicketReply as TicketReplyNotification;
use App\Repositories\TicketRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Throwable;

class TicketsController extends Controller
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    /**
     * TicketsController constructor.
     * @param TicketRepository $ticketRepository
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $page_title = "Tickets";
        $breadcrumb = [
            ['name' => 'dashboard', 'url' => route('home')],
            ['name' => 'tickets', 'url' => null]
        ];

        $tickets = $this->ticketRepository->paginatedCollection();

        return view('backend.tickets.index', compact('page_title', 'breadcrumb', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('frontend.create-ticket');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'email' => 'required|email',
            'phone_no' => 'required',
            'problem_description' => 'required',

        ]);

        try {
            $ticket = $this->ticketRepository->create(
                $request->only(['customer_name', 'email', 'phone_no', 'problem_description'])
            );
            $ticket->notify(new TicketOpened());

            return response()->json(['ticket' => $ticket, 'message' => 'Ticket details have been saved.', 'status' => 1]);
        } catch (Exception $exception) {
            dd($exception);
            return response()->json(['ticket' => null, 'message' => 'Something went wrong. Please try again.', 'status' => 0]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ticket $ticket
     * @return Application|Factory|View
     */
    public function edit(Ticket $ticket)
    {
        $page_title = "Tickets";
        $breadcrumb = [
            ['name' => 'dashboard', 'url' => route('home')],
            ['name' => 'tickets', 'url' => route('tickets.index')],
            ['name' => 'Add reply', 'url' => '']
        ];

        return view('backend.tickets.add-reply', compact('ticket', 'page_title', 'breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate(['reply_text' => 'required']);

        $reply = new TicketReply($request->only(['reply_text']));
        $reply = $ticket->replies()->save($reply);
        $ticket->notify(new TicketReplyNotification($reply));

        return back()->with('success', 'Reply has been successfully saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            Ticket::findOrFail($id)->delete();

            return response()->json(['status' => 1, 'message' => 'Ticket has been deleted!']);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 0, 'message' => 'Ticket not found'], 422);
        } catch (Exception $exception) {
            return response()->json(['status' => 0, 'message' => 'something went wrong!'], 500);
        }
    }

    /**
     * Guest Ticket search by reference #
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function search(Request $request)
    {
        try {
            $ticket = $this->ticketRepository->findByFiled($request->ticket_ref, 'ticket_ref', 'replies');
            $view = view('frontend.ticket_details', compact('ticket'))->render();

            return response()->json(['ticket' => $view, 'status' => (bool)$ticket]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => "Invalid Ticket Reference #", 'status' => 0], 422);
        } catch (\Exception $exception) {
            return response()->json(['message' => "Something went wrong.", 'status' => 0], 505);
        }
    }
}
