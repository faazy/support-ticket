@extends('layouts.app')

@section('content')
    {{--Breadcrumb--}}
    @include('partials.breadcrumb')

    {{--Page Style--}}
    <style type="text/css">
        .table .badge {
            font-size: 95%;
        }
    </style>

    {{--Page Content--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <form action="{{route('tickets.index')}}" method="get" id="searchForm">
                                <div class="input-group input-group-lg">
                                    <input class="form-control" id="q" name="q"
                                           placeholder="Searching ..." value="{{old('q', request()->q)}}"
                                           type="text">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary search">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </span>
                                    @if (request()->filled('q'))
                                        <span class="input-group-append ml-2">
                                            <a class="btn btn-danger rounded"
                                               href="{{route('tickets.index')}}"
                                               type="button"
                                            >
                                                <i class="fas fa-times"></i> Clear
                                            </a>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="status"></label>
                                    <select name="status" id="status" class="form-control"
                                            onchange="$('#searchForm').submit();">
                                        <option value="" {{request()->get('status')?:'selected'}}>All</option>
                                        <option value="0" {{request()->get('status') == "0" ?'selected':''}}>Pending
                                        </option>
                                        <option value="1" {{request()->get('status') == 1 ?'selected':''}}>Closed
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Ref #</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Opened Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets as $ticket)
                            <tr class="{{!$ticket->is_read ?'active':''}}">
                                <td>{{$ticket->ticket_ref}}</td>
                                <td>{{$ticket->customer_name}}</td>
                                <td>{{$ticket->email}}</td>
                                <td>{{$ticket->phone}}</td>
                                <td>{{$ticket->created_at}}</td>
                                <td>
                                    @if ($ticket->status == \App\Entities\Tickets\Ticket::STATUS_PENDING)
                                        <label class="badge badge-danger">Pending</label>
                                    @else
                                        <label class="badge badge-success">Closed</label>
                                    @endif
                                </td>
                                <td>
                                    <button title="View Details" class="btn btn-info detailed-view"
                                            data-ticket-id="{{$ticket->id}}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a title="Add reply to this ticket" class="btn btn-primary"
                                       href="{{route('tickets.edit', ['ticket' => $ticket->id])}}">
                                        <i class="fas fa-reply"></i>
                                    </a>
                                    <button title="Delete " class="btn btn-danger delete_confirmation"
                                            data-api-url="{{route('tickets.destroy', ['ticket' => $ticket->id])}}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            {!! $tickets->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('shared.ticket-modal-view')
    {{--End Page Content--}}
@endsection

@push('scripts')
    <script type="text/javascript">

        $('.detailed-view').click(function () {
            const id = $(this).data('ticket-id');

            if (id) {
                $.get(`/tickets/${id}`)
                    .done(data => {
                        const modal = $('#ticket-detailed-ui');

                        modal.find('.modal-body')
                            .empty()
                            .append(data.ticket);

                        modal.modal('show');
                    }).fail(error => {
                    const {message} = error.responseJSON;
                    Swal.fire(
                        'Oops...!',
                        message,
                        'error'
                    );

                });
            }
        });


    </script>
@endpush
