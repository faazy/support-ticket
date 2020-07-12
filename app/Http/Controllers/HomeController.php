<?php

namespace App\Http\Controllers;

use App\Entities\Tickets\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard (Summery of tickets).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page_title = "Dashboard";
        $breadcrumb = [['name' => 'Dashboard', 'url' => null]];

        $pending_count = Ticket::status(Ticket::STATUS_PENDING)->count();
        $closed_count = Ticket::status(Ticket::STATUS_CLOSED)->count();

        $widgets = [
            [
                'title' => 'Opened Ticket',
                'count' => $pending_count,
                'bg' => 'danger',
                'url' => route('tickets.index')
            ],
            [
                'title' => 'Closed Tickets',
                'count' => $closed_count,
                'bg' => 'success',
                'url' => route('tickets.index')
            ],
            [
                'title' => 'Total Tickets',
                'count' => ($closed_count + $pending_count),
                'bg' => 'info',
                'url' => route('tickets.index')
            ],
        ];

        return view('home', compact('page_title', 'breadcrumb', 'widgets'));
    }
}
