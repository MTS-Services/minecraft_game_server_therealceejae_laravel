<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ site_name() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ favicon() }}">

    {{-- Fontawsome CDN --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        html,
        body {
            height: 100%;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Base Styles */

        /* Minecraft Landscape Header */
        .minecraft-header {
            position: relative;
            overflow: hidden;
            border-bottom: 3px solid var(--primary-green);
        }

        .minecraft-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center;
        }

        .minecraft-header .position-absolute {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%);
        }
    </style>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .footer {
            background-color: #212529;
            /* Dark footer background */
            color: #f8f9fa;
            padding: 2rem 0;
            margin-top: auto;
            /* Pushes footer to the bottom */
            border-top: 5px solid #ff8c00;
        }

        .footer h5 {
            color: #ff8c00;
            font-weight: bold;
        }

        .footer a {
            color: #f8f9fa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #ffc107;
        }

        .social-links a {
            display: inline-block;
            margin-right: 0.5rem;
            font-size: 1.5rem;
            color: #f8f9fa;
            transition: transform 0.3s;
        }

        .social-links a:hover {
            transform: scale(1.1);
        }

        .social-links .fa-facebook-square:hover {
            color: #3b5998;
        }

        .social-links .fa-twitter-square:hover {
            color: #00acee;
        }

        .social-links .fa-instagram-square:hover {
            color: #e4405f;
        }

        .social-links .fa-linkedin:hover {
            color: #0077b5;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .footer-nav {
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .social-links {
                text-align: center;
            }
        }
    </style>
</head>

<body class="d-flex flex-column bg-body-secondary" @if (dark_theme()) data-bs-theme="dark" @endif>
    <div id="app" class="flex-shrink-0">
        <header>
            @include('elements.navbar')
        </header>

        <!-- Minecraft Landscape Header -->
        <div class="minecraft-header position-relative overflow-hidden" style="background: #1b152c;">
            {{-- <img src="https://placehold.co/1080x200/png?text=Minecraft+Landscape" alt="Minecraft Landscape" class="w-100"> --}}
            <img src="{{ asset('img/breadcrumb.gif') }}" alt="Minecraft Landscape" class="w-100 object-fit-cover px-5">
            <div class="position-absolute top-0 start-0 w-100 h-100"></div>
        </div>

        @yield('app')
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-logo">The Real Ceejae</h5>
                    <p class="text-secondary">Your trusted source for Minecraft servers.</p>                    
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h5>Navigation</h5>
                            <ul class="list-unstyled footer-nav">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('about') }}">About</a></li>
                                <li><a href="{{ route('server-listing.search') }}">Search</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Legal</h5>
                            <ul class="list-unstyled footer-nav">
                                <li><a href="{{ route('terms-condition') }}">Terms & Conditions</a></li>
                                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('faqs') }}">FAQ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: #555;">
            <div class="row">
                <div class="col text-center">
                    <p class="mb-0 text-muted">Copyright &copy; 2024 The Real Ceejae - All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    @stack('footer-scripts')

</body>

</html>
