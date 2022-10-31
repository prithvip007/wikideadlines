<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($_TITLE) ? $_TITLE : 'WikiDashboard' }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/dashboard.js') }}" defer></script>

    @yield('head.scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="WikiDeadlines">
    <link rel="apple-touch-icon" href="{{ asset('/images/icons/icon-152x152.png') }}">
    <link rel="manifest" href="{{ url('manifest.json') }}">
</head>
<body class="d-flex">
    <div id="toasts-container"></div>
    <section style="min-height: 100vh;width: 215px;" class="d-none d-md-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar-collapse">
        <div style="top:1rem" class="position-sticky">
            <h4 class="mb-3"><span class="fa fa-gavel"></span> WikiDashboard
            </h4>
            <div style="top: 0" class="navbar navbar-light bg-light py-0 px-3">
                <div class="mt-2 w-100 text-muted text-uppercase">General</div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::route()->named('dashboard.users') ? 'active' : '' }}" href="{{ route('dashboard.users') }}">
                            <i class="fa fa-user-circle-o mr-2" aria-hidden="true"></i>
                            <span class="text-dark">Users</span>
                        </a>
                    </li>
                </ul>

                <div class="mt-3 w-100 text-muted text-uppercase">Deadlines</div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::route()->named('dashboard.deadline-rules') ? 'active' : '' }}" href="{{ route('dashboard.deadline-rules') }}">
                            <i class="fa fa-cubes mr-2" aria-hidden="true"></i>
                            <span class="text-dark">Rules</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::route()->named('dashboard.deadline-rules.requests') ? 'active' : '' }}" href="{{ route('dashboard.deadline-rules.requests') }}">
                            <i class="fa fa-folder-open mr-2" aria-hidden="true"></i>
                            <span class="text-dark">Requests</span>
                        </a>
                    </li>
                </ul>

                <div class="mt-3 w-100 text-muted text-uppercase">Documents</div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::route()->named('dashboard.documents') ? 'active' : '' }}" href="{{ route('dashboard.documents') }}">
                            <i class="fa fa-file mr-2" aria-hidden="true"></i>
                            <span class="text-dark">Documents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::route()->named('dashboard.delivery-methods') ? 'active' : '' }}" href="{{ route('dashboard.delivery-methods') }}">
                            <i class="fa fa-truck mr-2" aria-hidden="true"></i>
                            <span class="text-dark">Delivery Methods</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::route()->named('dashboard.documents.requests') ? 'active' : '' }}" href="{{ route('dashboard.documents.requests') }}">
                            <i class="fa fa-folder-open mr-2" aria-hidden="true"></i>
                            <span class="text-dark">Requests</span>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav mt-3 mr-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::route()->named('dashboard.feedbacks') ? 'active' : '' }}" href="{{ route('dashboard.feedbacks') }}">
                            <i class="fa fa-envelope-open mr-2" aria-hidden="true"></i>
                            <span class="text-dark">Feedbacks</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div style="flex: 1 1 auto;min-width: 0;">
        <div style="top: 0;z-index: 1;" class="d-flex align-items-center justify-content-between shadow-sm px-3 py-2 position-sticky bg-light navbar-light flex-wrap">
            <button type="button" class="btn btn-light px-2 py-0 side-collapse-btn">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" id="navbarDropdown" role="button" data-display="static" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle d-flex align-items-center">
                        <span class="d-inline-block" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->second_name }}
                        </span>
                    </a>
                    <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right position-absolute">
                        <a href="{{ route('home') }}" class="dropdown-item">WikiDeadlines</a>
                        <form method="POST" action="{{ route('logout') }}" class="form-group m-0">
                            @csrf
                            <button type="submit" class="btn btn-link dropdown-item">Log out</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <main style="overflow: auto; max-width: 1200px" class="pt-3 container-fluid">
            @yield('content')
        </main>
        <footer class="mt-3"></footer>
    </div>
</body>
</html>
