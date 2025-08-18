@extends('layouts.base')
@section('title', trans('server-listing::messages.server_submission.title'))
@include('admin.elements.editor')
@section('app')

    @push('styles')
        <style>
            .dashboard-card {
                border-radius: 12px;
                padding: 2rem;
                text-align: center;
                height: 100%;
                transition: box-shadow 0.15s ease-in-out;
                background-color: #ffffff;
            }

            .dashboard-card:hover {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .dashboard-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
                color: #6c757d;
            }

            .section-title {
                color: #6c757d;
                font-weight: 600;
                margin-bottom: 2rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid #dee2e6;
            }

            .main-title {
                color: #fd7e14;
                font-weight: 600;
                margin-bottom: 3rem;
            }

            .monetize-card {
                background-color: #e3f2fd;
                border-color: #2196f3;
            }

            .monetize-card .dashboard-icon {
                color: #2196f3;
            }

            .btn-dashboard {
                background-color: #495057;
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                font-size: 0.875rem;
            }

            .btn-dashboard:hover {
                background-color: #343a40;
                color: white;
            }

            .btn-monetize {
                background-color: #2196f3;
                color: white;
            }

            .btn-monetize:hover {
                background-color: #1976d2;
                color: white;
            }
        </style>
    @endpush


    <div class="container py-5">
        <!-- Main Title -->
        <div class="row">
            <div class="col-12">
                <h1 class="main-title">User Dashboard</h1>
            </div>
        </div>

        <!-- Servers Section -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="section-title">Servers</h2>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <a href="{{ route('server-listing.submission') }}">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-plus-square text-primary"></i>
                        </div>
                        <button class="btn btn-dashboard">Register a Server <i class="bi bi-plus"></i></button>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('server-listing.list') }}">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-list-ul text-primary"></i>
                        </div>
                        <button class="btn btn-dashboard">Manage Your Servers <i class="bi bi-list"></i></button>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="YourAccount.html">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-pencil-square text-primary"></i>
                        </div>
                        <button class="btn btn-dashboard">Your Account <i class="bi bi-pencil"></i></button>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="yourFavorites.html">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-trophy-fill text-primary"></i>
                        </div>
                        <button class="btn btn-dashboard">Your Achievements <i class="bi bi-heart"></i></button>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="logout.html">
                    <div class="dashboard-card">
                        <div class="dashboard-icon">
                            <i class="bi bi-power text-primary"></i>
                        </div>
                        <button class="btn btn-dashboard">Logout <i class="bi bi-box-arrow-right"></i></button>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
