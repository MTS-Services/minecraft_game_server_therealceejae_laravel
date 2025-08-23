@extends('layouts.app')

@section('title', trans('auth.login'))

@push('styles')
    <style>
        :root {
            /* Minecraft-inspired color palette */
            --primary: #91b859;
            /* Minecraft red */
            --primary-foreground: #ffffff;
            --secondary: #f59e0b;
            /* Minecraft amber */
            --secondary-foreground: #1f2937;
            --background: #ffffff;
            /* Dark slate */
            --foreground: #5c5c5c;
            --card: rgba(30, 41, 59, 0.95);
            /* Semi-transparent slate */
            --card-foreground: #f8fafc;
            --border: #334155;
            --input: #f8f8f8;
            --muted: #64748b;
            --muted-foreground: #94a3b8;
            --radius: 0.75rem;
            --font-heading: 'Montserrat', sans-serif;
            --font-body: 'Open Sans', sans-serif;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--background);
            color: var(--foreground);
            background-image: url('subtle.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .registration-card {
            background-color: var(--card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        .form-control {
            background-color: var(--input);
            border-color: var(--border);
            color: var(--foreground);
            border-radius: var(--radius);
        }

        .form-control:focus {
            background-color: var(--input);
            border-color: var(--primary);
            color: var(--foreground);
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }

        .form-control::placeholder {
            color: var(--muted-foreground);
        }

        .form-label {
            color: var(--foreground);
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--primary-foreground);
            font-weight: 700;
            border-radius: var(--radius);
        }

        .btn-primary:hover {
            background-color: #436730;
            border-color: #b91c1c;
        }

        .btn-primary:disabled {
            background-color: var(--muted);
            border-color: var(--muted);
        }

        .text-muted {
            color: var(--muted-foreground) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-secondary {
            color: var(--secondary) !important;
        }

        .card-title {
            font-family: var(--font-heading);
            font-weight: 900;
            color: var(--primary);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .invalid-feedback {
            color: #ef4444;
        }

        .is-invalid {
            border-color: #ef4444;
        }

        a {
            color: var(--primary);
            text-decoration: none;
        }

        a:hover {
            color: var(--secondary);
        }

        .backgroundredsss {
            background-color: #3b82f6 !important;


        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-6">
            <h1>{{ trans('auth.login') }}</h1>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="captcha-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="email">{{ trans('auth.email') }}</label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">{{ trans('auth.password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row gy-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        @checked(old('remember'))>

                                    <label class="form-check-label" for="remember">
                                        {{ trans('auth.remember') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                @if (Route::has('password.request'))
                                    <a class="float-md-end" href="{{ route('password.request') }}">
                                        {{ trans('auth.forgot_password') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        @includeWhen($captcha, 'elements.captcha', ['center' => true])

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary d-block">
                                {{ trans('auth.login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
