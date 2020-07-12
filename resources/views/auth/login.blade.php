@extends('layouts.app')
@push('stylesheets')
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
@endpush

@section('content')
    @include('partials.top-navbar')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-5 mx-auto mt-5 pt-5">
                <!-- Login Card Starts-->
                <div class="card card-signin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="card-title text-center d-block">Signin In To Your Account</h5>
                            </div>
                        </div>

                        <form action="{{ route('login') }}" class="form-signin" id="loginForm" method="POST"
                              novalidate="novalidate">
                            @csrf
                            <div class="form-group">
                                <label for="inputEmail">{{ __('E-Mail Address') }}</label>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input
                                        autocomplete="email" autofocus
                                        class="form-control @error('email') is-invalid @enderror" maxlength="256"
                                        name="email" placeholder="Enter Email"
                                        required value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">{{ __('Password') }}</label>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input autocomplete="current-password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="inputPassword" name="password" placeholder="Enter Password"
                                           required type="password">
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input class="checkradios" name="remember"
                                       {{ old('remember') ? 'checked' : '' }}
                                       type="checkbox">
                                <span class="list-label"> Remember Me</span>
                            </div>
                            <button id="loginButton"
                                    class="btn btn-lg btn-primary btn-block text-uppercase "
                                    data-style="zoom-in" data-size="l" type="submit"><i class="fas fa-sign-in-alt"></i>
                                Sign In
                            </button>
                        </form>
                    </div>
                    <div class="card-footer p15 text-center">
                        @if (Route::has('password.request'))
                            <p>Help Me !.
                                <a class="text-theme-secondary"
                                   href="{{ route('password.request') }}">
                                    {{ __('I Forgot Password!') }}</a>
                            </p>
                        @endif

                    </div>
                </div>
                <!-- Login Card Ends-->
            </div>
        </div>
    </div>
@endsection

