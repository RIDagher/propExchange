<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Landing Page')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">PropExchange</a>
                <div id="navbar" class="navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link btn btn-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-link" href="{{ route('search-properties') }}">Find a Property</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-link" href="{{ route('search-agents') }}">Find a Realtor</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @auth
                        @if(Auth::user()->role === 'client')
                            <li class="nav-item">
                                <a class="nav-link btn btn-link" href="{{ route('properties.create') }}">
                                    <i class="bi bi-plus-circle"></i> List New Property
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link btn btn-link" href="{{ route('properties.my') }}">
                                <i class="bi bi-house-door"></i> My Properties
                            </a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link"> Hello, {{ Auth::user()->username }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" id="logout-btn" class="nav-link btn btn-link">Logout</button>
                            </form>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link btn btn-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link btn btn-link">Register</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer text-white text-center p-3">
        <p>&copy; PropExchange | All Rights Reserved</p>
    </footer>

    <div id="flashMessageContainer" data-flash-message="{{ session('success') ?? session('error') }}"></div>

    <div id="flashToast" class="toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
    <div class="d-flex">
        <div class="toast-body">
            @if(session('success'))
                {{ session('success') }}
            @elseif(session('error'))
                {{ session('error') }}
            @endif
        </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    @yield('scripts')
    
</body>
</html>