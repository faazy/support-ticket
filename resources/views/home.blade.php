@extends('layouts.app')

@section('content')
    {{--Breadcrumb--}}
    @include('partials.breadcrumb')

    {{--Begin Wwidgets Tile--}}
    <div class="row">
        @foreach ($widgets as $widget)
            <div class="col-md-4">
                <div class="small-box bg-{{$widget['bg']??'secondary'}}">
                    <div class="inner">
                        <h3>{{$widget['count']}}</h3>
                        <p>{{$widget['title']}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <a href="{{$widget['url']}}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    {{--End Wwidgets Tile--}}
@endsection
