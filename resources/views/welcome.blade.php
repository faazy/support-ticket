<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    {{--Template CSS--}}
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }


        body {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
        }
    </style>
</head>
<body>

@include('partials.top-navbar')

<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">

        </div>
    @endif

    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="#" class="needs-validation" id="searchForm" method="post" novalidate>
                                    <div class="input-group input-group-lg">
                                        <input class="form-control" id="ticket_ref" name="ticket_ref"
                                               placeholder="Enter Support Ticket Reference No ..."
                                               required
                                               type="text">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-primary search">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('shared.ticket-modal-view')

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

{{--Custom Scripts--}}
<script type="text/javascript">

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
                        fetchData();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    function fetchData() {
        const ticket_ref = $('#ticket_ref').val();

        if (ticket_ref.trim()) {
            $.get('/tickets/search', {ticket_ref: ticket_ref})
                .done(data => {
                    $('#ticket-detailed-ui')
                        .find('.modal-body')
                        .empty()
                        .append(data.ticket);

                    $('#ticket-detailed-ui').modal('show');
                }).fail(error => {
                const {message} = error.responseJSON;
                Swal.fire(
                    'Oops...!',
                    message,
                    'error'
                ).then(response => {
                    $('#ticket_ref').val('');
                    $('#ticket_ref').focus();
                });

            });
        }
    }
</script>
</body>
</html>


