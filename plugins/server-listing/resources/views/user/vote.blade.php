@extends('layouts.base')
@section('title', trans('server-listing::messages.server_submission.title'))
@include('admin.elements.editor')
@push('styles')
    <style>
        :root {
            --primary-blue: #3b82f6;
            --dark-blue: #1e3a8a;
            --accent-yellow: #fbbf24;
            --premium-purple: #8b5cf6;
            --dark-bg: #1f2937;
            --darker-bg: #111827;
        }

        .vote-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            backdrop-filter: blur(10px);
            padding-bottom: 35px;
        }

        .vote-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .vote-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .vote-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .vote-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .server-info {
            background: linear-gradient(135deg, var(--accent-yellow) 0%, #f59e0b 100%);
            color: #92400e;
            padding: 1rem;
            margin: -1px;
            text-align: center;
            font-weight: bold;
        }

        .form-section {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-bg);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .btn-vote {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border: none;
            color: white;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn-vote:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
            color: white;
        }

        .btn-vote:active {
            transform: translateY(0);
        }

        .btn-vote:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .vote-info {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--premium-purple);
        }

        .vote-info h5 {
            color: var(--premium-purple);
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(139, 92, 246, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: var(--dark-bg);
        }

        .info-value {
            font-weight: bold;
            color: var(--premium-purple);
        }

        .countdown-timer {
            background: linear-gradient(135deg, var(--premium-purple) 0%, #7c3aed 100%);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 1rem;
        }

        .timer-text {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .timer-value {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .vote-container {
                margin: 1rem;
                border-radius: 10px;
            }

            .vote-header {
                padding: 1.5rem;
            }

            .vote-header h1 {
                font-size: 2rem;
            }

            .form-section {
                padding: 1.5rem;
            }
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }
    </style>
@endpush
@section('app')



    {{-- <form action="{{ route('server-listing.vote.submit', $server_->slug) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="vote">User Name</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username">
        </div>
        <div class="form-group">
            <label for="vote">Captcha</label>
            <input type="text" name="captcha" class="form-control" placeholder="Enter your username">
        </div>
        <button type="submit" class="btn btn-primary">Submit Vote</button>
    </form> --}}

    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif
                <div class="vote-container">
                    <div class="vote-header">
                        <h1><i class="bi bi-server me-3"></i>{{ $server_->name }}</h1>
                        <p>Support your favorite Minecraft server</p>
                    </div>

                    <div class="server-info">
                        <i class="fas fa-server me-2"></i>
                        Help us climb the rankings - Vote every 12 hours!
                    </div>

                    <div class="form-section">
                        <div class="vote-info">
                            <h5><i class="fas fa-info-circle me-2"></i>Server Information</h5>
                            <div class="info-item">
                                <span class="info-label">Server IP:</span>
                                <span class="info-value">{{ $server_->server_ip }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Version:</span>
                                <span class="info-value">{{ $server_->minecraft_version }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Players Online:</span>
                                <span class="info-value">{{ $server_->current_players }}/{{ $server_->max_players }}</span>
                            </div>
                        </div>

                        <form action="{{ route('server-listing.vote.submit', $server_->slug) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user text-primary"></i>
                                    Minecraft Username
                                </label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Enter your Minecraft username" pattern="[a-zA-Z0-9_]{3,16}"
                                    title="Username must be 3-16 characters, letters, numbers, and underscores only">
                                <div class="form-text">
                                    <i class="fas fa-info-circle text-muted"></i>
                                    Enter your exact Minecraft username to receive rewards
                                </div>
                                @error('username')
                                    <div class="alert alert-danger mt-2">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @include('elements.captcha', ['center' => true])

                            <div class="d-grid">
                                <button type="submit" class="btn btn-vote text-white" id="submitBtn">
                                    <span class="loading-spinner" id="loadingSpinner"></span>
                                    Submit Vote
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
