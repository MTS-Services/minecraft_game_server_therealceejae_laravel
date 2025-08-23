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
    <div class="container  margintopwhites">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 col-xl-5  ">
                <div class="card registration-card shadow-lg border-0 margintopwhites" style="background-color: #f8fafc;">
                    <div class="card-header text-center pb-4 bg-transparent border-0 backgroundredsss">
                        <div class="my-3">
                            <img src="https://placehold.co/150x150" alt="Minecraft MP Logo" class="mx-auto d-block"
                                style="width: 80px; height: 80px; border-radius: 50%;">
                        </div>
                        <h1 class="card-title h2 mb-2 text-white">{{ trans('auth.login') }}</h1>
                        <p class="  mb-0 fw-semibold text-white">
                            {{ trans('auth.login_description') }}
                        </p>
                    </div>

                    <div class="card-body">
                        <!-- Removed novalidate and JavaScript-related attributes -->
                        <form method="POST" action="{{ route('login') }}" id="captcha-form">
                            @csrf
                            <div class="row g-3 px-4">
                                <div class="col-md-12">
                                    <label for="email" class="form-label">
                                        <span class="me-2">📧</span>Email
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Enter your Email"
                                        value="{{ old('email') }}" autocomplete="email" autofocus required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <br><br>
                                <div class="col-md-12">
                                    <label for="password" class="form-label">
                                        <span class="me-2">🔒</span> Password
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required minlength="8">
                                </div>

                                <!-- Terms Checkbox -->
                                {{-- <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeToTerms"
                                            name="agreeToTerms" required>
                                        <label class="form-check-label" for="agreeToTerms">
                                            I agree to the <a href="#" class="text-primary">Terms of Service</a> and
                                            <a href="#" class="text-primary">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div> --}}
                                @includeWhen($captcha, 'elements.captcha', ['center' => true])
                                <div class="col-12 pt-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2" style="font-size: 1.1rem;">
                                        {{ trans('auth.login') }}
                                    </button>
                                </div>
                                <div class="col-12 text-center pt-3">
                                    <p class="mb-0 text-muted">
                                        Registered Your Account? <a href="{{ route('register') }}"
                                            class="text-secondary fw-semibold text-decoration-underline">Registered
                                            here</a>
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
