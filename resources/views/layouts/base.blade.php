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

    <footer class="text-center text-bg-dark mt-auto py-4">
        <div class="copyright">
            <div class="container">
                <p>{{ __('Copyright © ' . date('Y') . ' The Real Ceejae - All Rights Reserved.') }} | @lang('messages.copyright')
                </p>

                @foreach (social_links() as $link)
                    <a href="{{ $link->value }}" title="{{ $link->title }}" target="_blank"
                        rel="noopener noreferrer" data-bs-toggle="tooltip"
                        class="d-inline-block mx-1 p-2 rounded-circle" style="background: {{ $link->color }}">
                        <i class="{{ $link->icon }} text-white"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </footer>

    @stack('footer-scripts')

</body>

</html>
