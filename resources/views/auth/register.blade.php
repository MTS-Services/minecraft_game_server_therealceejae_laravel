@extends('layouts.app')

@section('title', trans('auth.register'))
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
            background-image: url('subtle-minecraft-landscape (1).png');
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
            background-color: #4d7536;
            border-color: #198754;
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
    {{-- <div class="row justify-content-center">
        <div class="col-md-9 col-lg-6">
            <h1>{{ trans('auth.register') }}</h1>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="captcha-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="name">{{ trans('auth.name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">{{ trans('auth.email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}"  autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">{{ trans('auth.password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" 
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password-confirm">{{ trans('auth.confirm_password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                 autocomplete="new-password">
                        </div>

                        @if ($registerConditions !== null)
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('conditions') is-invalid @enderror"
                                        type="checkbox" name="conditions" id="conditions" 
                                        @checked(old('conditions'))>

                                    <label class="form-check-label" for="conditions">
                                        {{ $registerConditions }}
                                    </label>

                                    @error('conditions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        @include('elements.captcha', ['center' => true])

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                {{ trans('auth.register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 ">
                <div class="card registration-card shadow-lg border-0 margintopwhites" style="background-color: #f8fafc;">
                    <div class="card-header text-center pb-4 bg-transparent border-0 backgroundredsss">
                        <div class="my-3">
                            <img src="https://placehold.co/150x150" alt="Minecraft MP Logo"
                                class="mx-auto d-block" style="width: 80px; height: 80px; border-radius: 50%;">
                        </div>
                        <h1 class="card-title h2 mb-2 text-white">{{ trans('auth.register_title') }}</h1>
                        <p class="  fw-semibold  mb-0 text-white">{{ trans('auth.register_description') }}</p>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" id="captcha-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label">
                                        <span class="me-2">🎮</span>Username
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter your Minecraft Name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">
                                        <span class="me-2">📧</span>Email Address
                                    </label>
                                    <input type="email" class="form-control  @error('name') is-invalid @enderror"
                                        id="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        <span class="me-2">🔒</span>Password
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                        placeholder="Create a password" minlength="6" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="confirmPassword" class="form-label">
                                        <span class="me-2">🔐</span>Confirm Password
                                    </label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="password_confirmation" placeholder="Confirm your password" minlength="6">
                                </div>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <!-- Terms Checkbox -->
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeToTerms"
                                            name="agreeToTerms">
                                        <label class="form-check-label" for="agreeToTerms">
                                            I agree to the <a href="#" class="text-primary">Terms of Service</a> and
                                            <a href="#" class="text-primary">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>

                                @include('elements.captcha', ['center' => true])

                                <div class="col-12 pt-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2" style="font-size: 1.1rem;">
                                        <span class="me-2">⚡</span>
                                        Create My Account
                                    </button>
                                </div>

                                <!-- Login Link -->
                                <div class="col-12 text-center pt-3">
                                    <p class="mb-0 text-muted">
                                        Already have an account? <a href="{{ route('login') }}"
                                            class="text-secondary fw-semibold text-decoration-underline">{{ trans('auth.already_have_account') }}</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
