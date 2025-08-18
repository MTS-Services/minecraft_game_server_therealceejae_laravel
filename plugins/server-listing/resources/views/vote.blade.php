@extends('layouts.base')
@section('title', 'Vote for MineSuperior')
@section('app')
    @push('styles')
        <style>
            :root {
                --primary-green: #4CAF50;
                --primary-blue: #2196F3;
                --primary-purple: #9C27B0;
                --primary-gold: #FFD700;
                --primary-orange: #FF9800;
                --primary-orange-80: #ff9900de;

                --status-online: #28A745;
                --status-offline: #DC3545;
                --status-warning: #FFC107;

                --bg-primary: #ffffff;
                --bg-secondary: #f8f9fa;
                --bg-dark: #343a40;
                --bg-darker: #212529;

                --border-light: #dee2e6;
                --border-primary: #e1bee7;
                --border-dark: #495057;

                --text-primary: #212529;
                --text-secondary: #6c757d;
                --text-muted: #999;
                --text-white: #ffffff;

                --spacing-md: .5rem;
                --border-radius-sm: 0.375rem;
                --border-radius-md: 0.5rem;
                --border-radius-lg: 0.75rem;

                --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                --shadow-lg: 1rem 3rem rgba(0, 0, 0, 0.175);

                --logo-size-lg: 60px;
                --banner-height: 70px;
            }

            [data-bs-theme="dark"] {
                --bg-primary: #212529;
                --bg-secondary: #343a40;
                --text-primary: #ffffff;
                --text-secondary: #adb5bd;
                --border-light: #495057;

                --shadow-sm: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.050);
                --shadow-md: 0 0.5rem 1rem rgba(255, 255, 255, 0.075);
                --shadow-lg: 1rem 3rem rgba(255, 255, 255, 0.100);
            }

            body {
                background-color: var(--bg-secondary);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            /* Vote Card Styling */
            .vote-container {
                max-width: 1200px;
                margin: 2rem auto;
            }

            .vote-card {
                border-radius: var(--border-radius-lg);
                box-shadow: var(--shadow-sm);
                overflow: hidden;
                transition: all 0.3s ease;
                border: none;
            }

            .vote-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--shadow-md);
            }

            .vote-card-header {
                background: linear-gradient(135deg, #f8f9fa, #c5cdd442);
                color: var(--text-white);
                padding: 1.5rem;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            [data-bs-theme="dark"] .vote-card-header {
                background: linear-gradient(135deg, #343a40, #212529);
            }

            .server-title {
                font-size: 1.8rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                background: linear-gradient(to right, var(--primary-gold), var(--primary-orange));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .server-banner-container {
                width: 100%;
                max-width: 500px;
                height: 100%;
                max-height: 80px;
                background: var(--border-light);
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--text-secondary);
                margin-right: 10px;
                padding: 10px;
                overflow: hidden;
                margin: 1rem auto;
                box-shadow: #96d7f54b 3px 3px 6px 0px inset, #9fddc380 -3px -3px 6px 1px inset;
            }

            .server-banner-img,
            .server-banner-video {
                width: 100%;
                height: 100%;
                max-height: 65px;
                object-fit: cover;
                transition: transform 0.3s ease;
            }

            .server-banner-container:hover .server-banner-img,
            .server-banner-container:hover .server-banner-video {
                transform: scale(1.05);
            }

            /* Form Styling */
            .vote-form {
                padding: 2rem;
            }

            .form-control {
                border-radius: var(--border-radius-sm);
                padding: 0.75rem 1rem;
                border: 1px solid var(--border-light);
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: var(--primary-orange);
                box-shadow: 0 0 0 0.25rem rgba(175, 173, 76, 0.25);
            }

            .form-check-input {
                width: 1.2em;
                height: 1.2em;
                margin-top: 0.15em;
            }

            .form-check-input:checked {
                background-color: var(--primary-orange);
                border-color: var(--primary-gold);
            }

            .form-check-label {
                margin-left: 0.5rem;
            }

            .form-check-label a {
                color: var(--primary-orange);
                text-decoration: none;
                font-weight: 500;
            }

            .form-check-label a:hover {
                text-decoration: underline;
            }

            /* Verification Styling */
            .verification-container {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
                padding: 0.75rem;
                background-color: rgba(175, 157, 76, 0.1);
                border-radius: var(--border-radius-sm);
                border-left: 4px solid var(--primary-orange);
            }

            .verification-container .spinner {
                color: var(--primary-orange);
            }

            .verification-text {
                font-size: 0.9rem;
                color: var(--text-muted);
                margin-left: 0.5rem;
            }

            .cloudflare-logo {
                height: 20px;
                margin-left: auto;
            }

            /* Button Styling */
            .btn-vote {
                background-color: var(--primary-orange);
                border-color: var(--primary-gold);
                color: var(--text-white);
                padding: 0.75rem 1.5rem;
                border-radius: var(--border-radius-sm);
                font-weight: 600;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-vote:hover {
                background-color: var(--primary-orange-80);
                border-color: var(--primary-orange);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .btn-vote i {
                margin-right: 0.5rem;
            }

            .btn-back {
                background-color: var(--bg-secondary);
                border-color: var(--border-light);
                color: var(--text-primary);
                padding: 0.75rem 1.5rem;
                border-radius: var(--border-radius-sm);
                font-weight: 600;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-back:hover {
                background-color: var(--border-light);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .btn-back i {
                margin-right: 0.5rem;
            }

            /* Top Voters Card */
            .top-voters-card {
                border-radius: var(--border-radius-lg);
                box-shadow: var(--shadow-sm);
                overflow: hidden;
                height: 100%;
                transition: all 0.3s ease;
                border: none;
            }

            .top-voters-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--shadow-md);
            }

            .top-voters-header {
                background: linear-gradient(135deg, #f8f9fa, #c5cdd442);
                color: var(--primary-orange);
                padding: 1.5rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                font-size: 1.2rem;
            }

            [data-bs-theme="dark"] .top-voters-header {
                background: linear-gradient(135deg, #343a40, #212529);
            }

            .top-voters-header i {
                margin-right: 0.75rem;
                color: var(--primary-gold);
            }

            .top-voters-list {
                max-height: 500px;
                overflow-y: auto;
            }

            .top-voters-list::-webkit-scrollbar {
                width: 6px;
            }

            .top-voters-list::-webkit-scrollbar-track {
                background: var(--bg-secondary);
            }

            .top-voters-list::-webkit-scrollbar-thumb {
                background-color: var(--primary-orange);
                border-radius: 20px;
            }

            .voter-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid var(--border-light);
                transition: all 0.3s ease;
            }

            .voter-item:hover {
                background-color: rgba(76, 175, 80, 0.05);
            }

            .voter-item:last-child {
                border-bottom: none;
            }

            .voter-name {
                font-weight: 600;
                color: var(--text-primary);
            }

            /* Breadcrumb */
            .custom-design {
                background: linear-gradient(135deg, #f3e5f5, #e3f2fd) !important;
                padding: 10px;
            }

            [data-bs-theme="dark"] .custom-design {
                background: linear-gradient(135deg, #212529, #343a40) !important;
            }

            .card-header-custom {
                background: linear-gradient(135deg, var(--primary-purple), #673ab7);
                border-radius: 10px 10px 0 0;
                padding: 10px;
                color: var(--text-white);
            }

            .title-color {
                color: var(--primary-orange);
            }

            /* Content Container */
            .content-container {
                background-color: var(--bg-primary);
                border-radius: 0 0 var(--border-radius-lg) var(--border-radius-lg);
                box-shadow: var(--shadow-sm);
                padding: 2rem;
            }

            /* Responsive Adjustments */
            @media (max-width: 991.98px) {

                .vote-card,
                .top-voters-card {
                    margin-bottom: 1.5rem;
                }

                .vote-card-header {
                    padding: 1.25rem;
                }

                .server-title {
                    font-size: 1.5rem;
                }

                .vote-form {
                    padding: 1.5rem;
                }

                .btn-vote,
                .btn-back {
                    width: 100%;
                    margin-bottom: 0.5rem;
                }
            }

            @media (max-width: 767.98px) {
                .vote-container {
                    padding: 0 1rem;
                }

                .server-title {
                    font-size: 1.3rem;
                }

                .server-banner-container {
                    height: 80px;
                }

                .vote-form {
                    padding: 1.25rem;
                }

                .top-voters-header {
                    padding: 1.25rem;
                }

                .voter-item {
                    padding: 0.75rem 1rem;
                }
            }

            @media (max-width: 575.98px) {
                .breadcrumb-container {
                    padding: 0.75rem 1rem;
                }

                .content-container {
                    padding: 1rem;
                }

                .vote-card-header {
                    padding: 1rem;
                }

                .vote-form {
                    padding: 1rem;
                }

                .server-title {
                    font-size: 1.2rem;
                }

                .server-banner-container {
                    height: 70px;
                }
            }
        </style>
    @endpush

    <div class="vote-container">
        <!-- Breadcrumb Navigation -->

        <div aria-label="breadcrumb" class="custom-design card-header-custom py-2 px-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none title-color">Minecraft Servers List</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('server-listing.details', $serverDetail->slug) }}"
                        class="text-decoration-none title-color">{{ $serverDetail->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Vote</li>
            </ol>
        </div>

        <!-- Main Content -->
        <div class="content-container">
            <div class="row">
                <!-- Vote Card -->
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="vote-card h-100">
                        <div class="vote-card-header">
                            <h1 class="server-title">Vote for "{{ $serverDetail->name }}"</h1>
                            <div class="server-banner-container">
                                {{-- <video src="{{ asset('img/server-banner.mp4') }}" class="server-banner-video" muted=""
                            autoplay="" loop="" playsinline="" allowfullscreen="false"></video> --}}
                                <img src="{{ $serverDetail->banner_image_url }}" class="server-banner-img"
                                    alt="MineSuperior Banner">
                            </div>
                        </div>
                        <div class="vote-form">
                            <form id="voteForm" action="{{ route('server-listing.vote.store', $serverDetail->slug) }}"
                                method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="username" class="form-label fw-bold">Your Minecraft Username</label>
                                    <input type="text" class="form-control" id="username"
                                        placeholder="Enter your username">
                                    <div class="form-text">Make sure to enter your exact Minecraft username</div>
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="privacyCheckbox">
                                    <label class="form-check-label" for="privacyCheckbox">
                                        I agree to {{ config('app.name') }}'s <a href="#">Privacy Policy</a> and <a
                                            href="#">Terms of Service</a>
                                    </label>
                                </div>

                                <div class="mb-4 verification-container">
                                    <div class="spinner-border spinner-border-sm spinner" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span class="verification-text">Verifying human interaction...</span>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Cloudflare_Logo_Vector.svg/1200px-Cloudflare_Logo_Vector.svg.png"
                                        alt="Cloudflare" class="cloudflare-logo">
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-vote flex-grow-1">
                                        <i class="fas fa-check-circle me-2"></i> Vote Now
                                    </button>
                                    <a href="{{ route('server-listing.details', $serverDetail->slug) }}"
                                        class="btn btn-back flex-grow-1">
                                        <i class="fas fa-arrow-left me-2"></i> Back to Server
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Top Voters Card -->
                <div class="col-lg-4">
                    <div class="top-voters-card">
                        <div class="top-voters-header">
                            <i class="fas fa-trophy"></i>
                            <span>Top Voters This Month</span>
                        </div>
                        <div class="top-voters-list">
                            <div class="voter-item">
                                <span class="voter-name">ImArrowsRaz</span>
                                <span class="voter-count">18</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">GodsVsMortals</span>
                                <span class="voter-count">18</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">Kaladrian</span>
                                <span class="voter-count">18</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">_TF2</span>
                                <span class="voter-count">18</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">Ravens_wolf</span>
                                <span class="voter-count">18</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">FlewToTheCity</span>
                                <span class="voter-count">18</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">Acefr</span>
                                <span class="voter-count">17</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">Oogleman1</span>
                                <span class="voter-count">17</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">Samuele52011</span>
                                <span class="voter-count">17</span>
                            </div>
                            <div class="voter-item">
                                <span class="voter-name">TenarElf</span>
                                <span class="voter-count">17</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- 
    @push('footer-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Form submission handling
                const voteForm = document.getElementById('voteForm');
                if (voteForm) {
                    voteForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        // Simulate form submission
                        const submitBtn = voteForm.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;

                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';

                        // Simulate API call
                        setTimeout(function() {
                            // Show success message
                            showToast('Your vote has been recorded successfully!', 'success');

                            // Reset form
                            voteForm.reset();
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 2000);
                    });
                }

                // Toast notification function
                function showToast(message, type = 'success') {
                    const toastContainer = document.getElementById('toast-container') || createToastContainer();
                    const toast = document.createElement('div');
                    toast.className =
                        `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
                    toast.setAttribute('role', 'alert');
                    toast.setAttribute('aria-live', 'assertive');
                    toast.setAttribute('aria-atomic', 'true');

                    toast.innerHTML = `
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    `;

                    toastContainer.appendChild(toast);
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.show();

                    // Remove toast element after it's hidden
                    toast.addEventListener('hidden.bs.toast', () => {
                        toast.remove();
                    });
                }

                // Create toast container if it doesn't exist
                function createToastContainer() {
                    const container = document.createElement('div');
                    container.id = 'toast-container';
                    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                    container.style.zIndex = '9999';
                    document.body.appendChild(container);
                    return container;
                }
            });
        </script>
    @endpush --}}
@endsection
