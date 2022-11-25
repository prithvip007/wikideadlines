<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('head')

    <title>{{ isset($_TITLE) ? $_TITLE : 'WikiDeadlines' }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @yield('head.scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="WikiDeadlines">
    <link rel="apple-touch-icon" href="{{ asset('/images/icons/icon-152x152.png') }}">
    <link rel="manifest" href="{{ url('manifest.json') }}">
</head>
<body>
<div id="toasts-container"></div>
<div id="app">
        <nav style="z-index:3; background-color: #2D76F9 !important" class="navbar navbar-expand-md navbar-m bg-white shadow-sm">
            <div
                class="container position-relative{{ isset($_CONTAINER_CLASS) ? ' ' . $_CONTAINER_CLASS : '' }}{{ (isset($_HIDE_AUTH_NAV) || isset($_HIDE_NAV)) ? ' justify-content-center' : '' }}"
            >
                @if (Auth::check() === false || Request::route()->named('login'))
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <span class="fa fa-gavel"></span> WikiDeadlines
                    </a>
                    @empty($_HIDE_AUTH_NAV)
                        <div class="position-absolute" style="right:0" >
                            <a href="{{ route('login') }}" class="btn btn-link px-3 auth-link">Log in</a>
                            <a href="{{ route('signup') }}" class="btn btn-link px-3 btn btn-warning text-dark">Sign up</a>
                        </div>
                    @endempty
                @else
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <span class="fa fa-gavel"></span> WikiDeadlines
                    </a>
                    @empty($_HIDE_NAV)
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="mr-auto"></div>
                            <ul class="navbar-nav my-2 my-lg-0">
                                <li class="nav-item {{ Request::route()->named('calculate') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('calculate') }}">Calculator</a>
                                </li>
                                <li class="nav-item {{ Request::route()->named('history') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('history') }}">My Deadlines</a>
                                </li>
                                    <li class="nav-item {{ Request::route()->named('pricing') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link" href="#feedback">Feedback</a>
                                </li>
                                <li class="nav-item dropdown {{ Request::route()->named('profile') ? 'active' : '' }}" style="width: 100px;">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-display="static" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-inline-block" style="max-width: 200px; overflow:hidden; text-overflow:ellipsis">
                                            {{ Auth::user()->first_name . ' ' . Auth::user()->second_name }}
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('profile') }}">Settings</a>
                                        @if (Auth::user()->isAn('admin'))
                                            <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                        @endif
                                        @if (Auth::user()->isAn('owner'))
                                            <a class="dropdown-item" href="{{ url('telescope') }}">Telescope</a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('privacy') }}">Privacy Policy</a>
                                        <form class="form-group m-0" method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-link dropdown-item">Log out</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endempty
                @endif
            </div>
        </nav>

    <main class="d-flex">
        @yield('content')
    </main>
    @yield('widgets')
    <feedback initial-email="{{ Auth::user()->email ?? '' }}" trigger-hash="feedback" ref="feedback"></feedback>
</div>
</body>
</html>
