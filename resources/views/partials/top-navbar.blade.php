<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (collect(request()->segments())->first() !=null )
                        <li class="nav-item mr-md-2 mb-2 mb-md-0">
                            <a href="{{ route('landing') }}">
                                <button type="button" class="btn btn-block btn-outline-primary">
                                    <i class="fas fa-home"></i>
                                    Home
                                </button>
                            </a>
                        </li>
                    @endif

                    @if(collect(request()->segments())->first() !='tickets')
                        <li class="nav-item mr-md-2 mb-2 mb-md-0">
                            <a href="{{ route('tickets.create') }}">
                                <button type="button" class="btn btn-block btn-outline-danger">
                                    <i class="fas fa-ticket-alt"></i>
                                    Open Ticket
                                </button>
                            </a>
                        </li>
                    @endif
                    @if (collect(request()->segments())->first() !== 'login' )
                        <li class="nav-item">
                            <a href="{{ route('login') }}">
                                <button type="button" class="btn btn-block btn-outline-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>

                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item mr-md-2 mb-2 mb-md-0">
                        <a href="{{ route('home') }}">
                            <button type="button" class="btn btn-block btn-outline-secondary">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </button>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
