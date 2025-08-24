@extends('layouts.base')
@section('title', trans('server-listing::messages.server_submission.title'))
@include('admin.elements.editor')
@section('app')

    @push('styles')
        <style>
            /* Light and Dark Mode Variables */
            :root {
                --text-color: #343a40;
                --muted-text-color: #6c757d;
                --monetize-border: #2196f3;
                --monetize-icon: #2196f3;
                --dashboard-btn-bg: #495057;
                --dashboard-btn-hover-bg: #343a40;
                --primary-icon-color: #0d6efd;
                --main-title-color: #fd7e14;
            }

            @media (prefers-color-scheme: dark) {
                :root {

                    /* --card-background: #1e1e1e; */
                    --muted-text-color: #a0a0a0;
                    --border-color: #444444;
                    --monetize-bg: #1e2a38;
                    --monetize-border: #2196f3;
                    --monetize-icon: #2196f3;
                    --dashboard-btn-bg: #4a4a4a;
                    --dashboard-btn-hover-bg: #606060;
                    --primary-icon-color: #64b5f6;
                    --main-title-color: #ffa726;

                }
            }

            body {
                color: var(--text-color);
            }

            .dashboard-card {
                border-radius: 12px;
                padding: 2rem;
                text-align: center;
                height: 100%;
                border: 2px solid #c5c5c5;
            }

            .dashboard-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
                color: var(--muted-text-color);
            }

            .section-title {
                color: var(--muted-text-color);
                font-weight: 600;
                margin-bottom: 2rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid var(--border-color);
            }

            .main-title {
                color: var(--main-title-color);
                font-weight: 600;
                margin-bottom: 3rem;
            }


            .monetize-card .dashboard-icon {
                color: var(--monetize-icon);
            }

            .btn-dashboard {

                border: none;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                font-size: 0.875rem;
            }

            .btn-monetize {
                background-color: #2196f3;

            }

            .btn-monetize:hover {
                background-color: #1976d2;

            }
        </style>
    @endpush


    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="main-title">User Dashboard</h1>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <a href="{{ route('server-listing.submission') }}">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-plus-square"></i>
                        </div>
                        <h5>Register a Server</h5>
                        <p>Add your server to the list</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('server-listing.list') }}">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-list-ul"></i>
                        </div>
                        <h5>Manage Your Servers</h5>
                        <p>Edit or update your server details</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('profile.index') }}">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h5>Your Account</h5>
                        <p>Update your profile & settings</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('server-listing.my_favorite_servers') }}">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h5>Favorite Servers</h5>
                        <p>View your saved servers</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('shop.profile') }}">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h5>Your Payments</h5>
                        <p>Check your purchase history</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="logout.html">
                    <div class="dashboard-card logout-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        <h5>Logout</h5>
                        <p>Sign out of your account</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        .dashboard-card {
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s ease;

            cursor: pointer;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-6px);

        }

        .dashboard-card h5 {
            margin-top: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: #838383;
        }

        .dashboard-card p {
            font-size: 0.95rem;
            color: #6c757d;
            margin: 0;
        }

        /* Icons inside circle */
        .dashboard-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
        }

        /* Special style for logout */
        .logout-card .dashboard-icon {
            background: linear-gradient(135deg, #dc3545, #a71d2a);
        }

        /* 🌞 Light mode */
        @media (prefers-color-scheme: light) {
            body {
                /* background-color: #f8f9fa; */
                color: #212529;
            }

            .dashboard-card {
                /* background-color: #ffffff; */
            }
        }

        /* 🌙 Dark mode */
        @media (prefers-color-scheme: dark) {
            body {

                color: #e9ecef;
            }

            .dashboard-card {

                color: #e9ecef;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.171);
            }

            .dashboard-card p {
                color: #adb5bd;
            }
        }
    </style>
@endsection
