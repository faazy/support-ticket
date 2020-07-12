@extends('layouts.app')

@section('content')
    @push('stylesheets')
        <!-- Summernote Editor CSS-->
        <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    @endpush

    {{--Breadcrumb--}}
    @include('partials.breadcrumb')

    {{--Page Content--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('frontend.ticket_details')
                    <div class="col-md-12">
                        <div class="tc-editor">
                            <h3>Reply this ticket</h3>
                            <form method="POST" action="{{route('tickets.update',['ticket' => $ticket])}}"
                                  accept-charset="UTF-8" id="replies">
                                @method('put')
                                @csrf
                                <textarea name="reply_text" class="form-control textarea"
                                          spellcheck="false">{{old('reply_text')}}</textarea>
                                <div class="text-left">
                                    <a type="submit" class="btn btn-danger text-white">
                                        <i class="fas fa-arrow-left"></i>
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-reply"></i>
                                        Reply
                                    </button>

                                </div>
                            </form>
                            <div class="alert alert-danger reply-body" style="display: none">
                                <strong>Alert!</strong> Reply body can not be empty!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--End Page Content--}}
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
    </script>
@endpush
