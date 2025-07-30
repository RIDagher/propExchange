<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Landing Page')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}?v={{ time() }}" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    
    <script src="{{ asset('js/app.js') }}" defer></script>

    
    <style>
        /* Your styles here */
             body {
            margin: 0;
        }

        .navbar {
            background-color: #DD1D2E !important;
        }

        .footer {
            background-color: #DD1D2E !important;
        }

        .hero {
            background-color: #003DA5 !important;
        }

        .info-section h2 {
            margin-bottom: 0.1rem !important;
        }

        .info-section p {
            margin-top: 0 !important;
        }

        .property-cards {
            background-color: #003DA5 !important;
        }

        .property-cards a {
            background-color: #003DA5 !important;
            color: white !important;
            transition: ease 0.3s !important;
        }

        .property-cards a:hover {
            background-color: #014fd6 !important;
            color: white !important;
        }

        #login-form {
            width: 500px !important;
            border-radius: 5px !important;
            margin: 150px !important;
        }

        #login-btn {
            background-color: #003DA5 !important;
            border: none !important;
        }

        #login-btn:hover {
            background-color: #014fd6 !important;
        }

        #register-form {
            width: 500px;
            border-radius: 5px;
            margin: 110px;
        }

        #register-btn {
            background-color: #003DA5;
            border: none;
        }

        #register-btn:hover {
            background-color: #014fd6;
        }

        #search-results {
            display: none;
            z-index: 1000;
        }

        #logout-bnt {
            padding: 0;
            border: none;
        }

        .btn-link:focus,
        #logout-bnt:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        #agent-container {
            margin-bottom: 200px;
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>

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
