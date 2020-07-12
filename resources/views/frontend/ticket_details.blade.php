<div class="row px-3">
    <div class="col-12 px-4">
        <div class="card">
            <div class="card-body">
                <div class="ticket_replies">
                    <div class="ticket-detail-box">
                        <div class="outer-white">
                            <h4 class="ticket-number text-primary">Ticket#:
                                <span class="count">
                                    {{$ticket->ticket_ref}} | Date: {{$ticket->created_at->format('d/m/Y')}}
                                </span>
                            </h4>
                            <div>
                                @if ($ticket->status == \App\Entities\Tickets\Ticket::STATUS_PENDING)
                                    <label class="badge badge-danger badge2x">
                                        <i class="fas fa-hourglass"></i> Pending
                                    </label>
                                @else
                                    <label class="badge badge-success badge2x">
                                        <i class="fas fa-check-circle"></i> Closed
                                    </label>
                                @endif

                            </div>
                            <h5 class="title text-secondary">
                                <i class="fas fa-envelope"></i> {{$ticket->email}}
                            </h5>
                            <h5 class="title text-secondary">
                                <i class="fas fa-phone"></i> {{$ticket->phone_no}}
                            </h5>
                            <div class="date-time text-secondary">
                                <span class="name">
                                    <i class="fas fa-user-alt"></i>
                                    Submitted By: {{$ticket->customer_name}}
                                </span>
                            </div>
                            <div class="details text-dark">
                                <blockquote class="blockquote">
                                    {!! $ticket->problem_description !!}
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- The time line -->
        <div class="timeline">
        @php($replies = $ticket->replies->groupBy('date'))

        @foreach($replies as $date => $reply)

            <!-- timeline time label -->
                <div class="time-label">
                    <span class="bg-red">{{\Carbon\Carbon::parse($date)->format('d M, Y')}}</span>
                </div>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <!-- timeline item -->
                @foreach($reply as $item)
                    <div>
                        <i class="fas fa-comments bg-gradient-blue"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{$item->created_at->diffForHumans()}}</span>
                            <h3 class="timeline-header">
                                <a href="#">{{$item->agent->name}}</a> replied on this Ticket</h3>
                            <div class="timeline-body">
                                {!! $item->reply_text !!}
                            </div>
                        </div>
                    </div>
            @endforeach
        @endforeach
        <!-- END timeline item -->
            <div>
                <i class="fas fa-clock bg-gray"></i>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
