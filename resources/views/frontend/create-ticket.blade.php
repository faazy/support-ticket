@extends('layouts.app')

@push('stylesheets')
    <style type="text/css">
        body {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
        }
    </style>
    <!-- Summernote Editor CSS-->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
    @include('partials.top-navbar')

    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="container mt-5 pt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="text-center text-muted mb-4">
                                    <h1 class="mb-3 text-18">Create Ticket</h1>
                                </div>
                                <form method="post" action="{{route('tickets.store')}}" id="openTicketForm"
                                      class="needs-validation" novalidate>
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="customer_name">Name</label>
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-user"></i></span>
                                                </div>
                                                <input class="form-control" id="customer_name" name="customer_name"
                                                       placeholder="Please enter your name" required=""
                                                       type="text" autofocus
                                                       value="{{old('customer_name')}}">
                                                <div class="invalid-feedback">
                                                    Please provide your name.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-envelope"></i></span>
                                                </div>
                                                <input class="form-control" type="email" name="email" required=""
                                                       value="{{old('email')}}"
                                                       placeholder="Email">
                                                <div class="invalid-feedback">
                                                    Please provide a valid email address.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phone_no">Phone</label>
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-phone"></i></span>
                                                </div>
                                                <input class="form-control" id="phone_no" name="phone_no"
                                                       placeholder="Contact Phone #"
                                                       required=""
                                                       type="text"
                                                       value="{{old('phone_no')}}"
                                                >
                                                <div class="invalid-feedback">
                                                    Please provide a phone number.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label for="problem_description">Problem Description</label>
                                            <textarea class="form-control textarea" id="problem_description"
                                                      name="problem_description" required
                                                      placeholder="Enter Problem description">{{old('problem_description')}}</textarea>
                                            <div class="invalid-feedback">
                                                Please provide a problem description.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <input type="hidden" name="status" value="In Progress">
                                        <button class="btn btn-rounded btn-success mt-2"><i
                                                class="fas fa-ticket-alt"></i> Create Ticket
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Summernote Editor JS -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script type="text/javascript">

        $(function () {
            //Summernote Init
            $('.textarea').summernote({
                placeholder: 'Enter the problem description',
                tabsize: 2,
                height: 100,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        //JS Form validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                const forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                const validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        if (form.checkValidity()) {
                            $('form').find('button').prop('disabled', true);
                            postData();
                        }

                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        /**
         * API call for ticket details store
         */
        function postData() {
            const form = $('#openTicketForm');

            $.post('/tickets', form.serializeArray())
                .done(data => {
                    //Reset the form data
                    resetForm();

                    Swal.fire({
                        title: 'Good job!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText:
                            '<i class="far fa-thumbs-up"></i> Great!',
                        footer: `<strong>Ticket Ref #: ${data.ticket.ticket_ref}</strong>`,
                        showCloseButton: true,
                    });
                })
                .fail(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        showCloseButton: true,
                    })
                })
                .always(reps => {
                    $('form').find('button').prop('disabled', false);
                });
        }

        /**
         * Reset the form old state
         * @param form
         */
        function resetForm() {
            const form = document.getElementById("openTicketForm");

            form.reset();
            form.classList.remove("was-validated");
            $('.textarea').summernote('reset');
        }
    </script>
@endpush
