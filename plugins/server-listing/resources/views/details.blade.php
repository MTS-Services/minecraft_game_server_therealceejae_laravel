@extends('layouts.base')
@section('title', trans('server-listing::messages.server_details.title'))
@section('app')

    @push('styles')
        <style>
            :root {
                /* Primary Colors */
                --primary-green: #4CAF50;
                --primary-blue: #2196F3;
                --primary-purple: #9C27B0;
                --primary-gold: #FFD700;
                --primary-orange: #FF9800;

                /* Status Colors */
                --status-online: #28A745;
                --status-offline: #DC3545;
                --status-warning: #FFC107;

                /* Background Colors */
                --bg-primary: #ffffff;
                --bg-secondary: #f8f9fa;
                --bg-dark: #343a40;
                --bg-darker: #212529;

                /* Border Colors */
                --border-light: #dee2e6;
                --border-primary: #e1bee7;
                --border-dark: #495057;

                /* Text Colors */
                --text-primary: #212529;
                --text-secondary: #6c757d;
                --text-muted: #999;
                --text-white: #ffffff;

                /* Spacing */
                --spacing-md: .5rem;

                /* Border Radius */
                --border-radius-sm: 0.375rem;

                /* Shadows */
                --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                --shadow-lg: 1rem 3rem rgba(0, 0, 0, 0.175);

                /* Logo/Image Sizes */
                --logo-size-lg: 60px;
                --banner-height: 70px;
            }

            [data-bs-theme="dark"] {
                --bg-primary: #212529;
                --bg-secondary: #343a40;
                --text-primary: #ffffff;
                --text-secondary: #adb5bd;
                --border-light: #495057;
            }

            body {
                background-color: var(--bg-secondary);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .btn-orange {
                background-color: var(--primary-green);
                border-color: var(--primary-green);
                color: white;
            }

            .btn-orange:hover {
                background-color: #e55a2b;
                border-color: #e55a2b;
                color: white;
            }

            .server-rating {
                color: var(--status-warning);
            }

            .status-online {
                color: var(--status-online);
                font-weight: bold;
            }

            .status-offline {
                color: var(--status-offline);
                font-weight: bold;
            }

            .discord-widget {
                background: #7289da;
                color: var(--text-white);
                border-radius: 0 0 5px 5px;
                padding: 1rem;
                text-align: center;
            }

            .stats-item {
                border-right: 1px solid var(--border-light);
                padding: 1rem;
                text-align: center;
            }

            .stats-item:last-child {
                border-right: none;
            }

            .stats-number {
                font-size: 2rem;
                font-weight: bold;
                color: var(--primary-orange);
            }

            .minecraft-video {
                position: relative;
                width: 100%;
                height: 300px;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 300"><rect fill="%2332CD32" width="800" height="300"/><text x="50%" y="40%" font-family="Arial" font-size="48" font-weight="bold" fill="white" text-anchor="middle">HOW TO</text><text x="50%" y="60%" font-family="Arial" font-size="48" font-weight="bold" fill="yellow" text-anchor="middle">INSTALL</text><text x="50%" y="80%" font-family="Arial" font-size="36" font-weight="bold" fill="blue" text-anchor="middle">Pixelmon</text></svg>') center/cover;
                border-radius: 10px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .play-button {
                width: 80px;
                height: 80px;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                color: var(--primary-orange);
            }

            .server-info-item {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem 0;
                border-bottom: 1px solid var(--border-light);
            }

            .server-info-item:last-child {
                border-bottom: none;
            }

            .version-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                margin-top: 0.5rem;
            }

            .version-tag {
                background-color: var(--text-secondary);
                color: var(--text-white);
                padding: 0.25rem 0.5rem;
                border-radius: 3px;
                font-size: 0.8rem;
            }

            .footer-custom {
                background-color: var(--bg-darker);
                color: var(--text-secondary);
                padding: 3rem 0 1rem;
                margin-top: 4rem;
            }

            .footer-links {
                list-style: none;
                padding: 0;
            }

            .footer-links li {
                margin-bottom: 0.5rem;
            }

            .footer-links a {
                color: var(--text-secondary);
                text-decoration: none;
            }

            .footer-links a:hover {
                color: var(--primary-orange);
            }

            .other-servers {
                display: flex;
                gap: 1rem;
            }

            .server-thumb {
                width: 64px;
                height: 64px;
                background: var(--border-light);
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--text-secondary);
            }

            .custom-design {
                background: linear-gradient(135deg, #f3e5f5, #e3f2fd) !important;
                padding: 10px;
            }

            body[data-bs-theme="dark"] .custom-design {
                background: linear-gradient(135deg, #212529, #343a40) !important;
            }

            .custom-design-2 {
                background: linear-gradient(135deg, #f8f9fa, #c5cdd4);
                padding: 10px;
                border-radius: 0 0 10px 10px;
                overflow: hidden;
            }

            body[data-bs-theme="dark"] .custom-design-2 {
                background: linear-gradient(135deg, #343a40, #212529);
            }

            .card-header-custom {
                background: linear-gradient(135deg, var(--primary-purple), #673ab7);
                border-radius: 10px 10px 0 0;
                padding: 10px;
                color: var(--text-white);
            }

            .server-logo-container {
                width: 100px;
                height: 100px;
                background: var(--border-light);
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--text-secondary);
                margin-right: 10px;
                box-shadow: #96d7f54b 3px 3px 6px 0px inset, #9fddc380 -3px -3px 6px 1px inset;
            }

            .server-logo {
                width: 100%;
                height: 100%;
                object-fit: cover;
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
                box-shadow: #96d7f54b 3px 3px 6px 0px inset, #9fddc380 -3px -3px 6px 1px inset;
            }

            .server-banner-img,
            .server-banner-video {
                width: 100%;
                height: 100%;
                max-height: 65px;
                object-fit: cover;
            }

            .title-color {
                color: var(--primary-orange);
            }

            .server-title {
                background: linear-gradient(135deg, var(--primary-orange), #673ab7);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .server-row {
                transition: all 0.3s ease;
                padding: var(--spacing-md);
                border-bottom: 1px solid var(--border-light);
                position: relative;
            }

            .server-row:hover {
                background-color: var(--bg-secondary);
                transform: translateX(5px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .server-row:last-child {
                border-bottom: none;
            }

            /* Server Logos */
            .server-logo {
                width: var(--logo-size-lg);
                height: var(--logo-size-lg);
                border-radius: var(--border-radius-sm);
                overflow: hidden;
                border: 2px solid var(--border-light);
                transition: border-color 0.2s ease;
                position: relative;
            }

            .server-logo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .server-row:hover .server-logo {
                border-color: var(--primary-blue);
            }

            /* Server Banners */
            .server-banner {
                width: 100%;
                max-width: 500px;
                height: var(--banner-height);
                border-radius: var(--border-radius-sm);
                overflow: hidden;
                position: relative;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            .server-banner img,
            .server-banner video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.2s ease;
            }

            .server-banner:hover img,
            .server-banner:hover video {
                transform: scale(1.02);
            }

            .banner-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
                padding: var(--spacing-sm) var(--spacing-md);
                z-index: 2;
            }

            /* Responsive styles */
            @media (max-width: 767.98px) {
                .d-flex.flex-md-row {
                    flex-direction: column !important;
                }

                .server-logo-container,
                .server-banner-container {
                    margin-right: 0;
                }

                .server-banner-container {
                    width: 100%;
                    max-width: 100%;
                }

                .server-logo-container {
                    width: 80px;
                    height: 80px;
                    margin-bottom: 10px;
                }

                .server-logo {
                    width: 100%;
                    height: 100%;
                }

                .server-row .col-md-2,
                .server-row .col-md-4 {
                    margin-bottom: 10px;
                }

                .server-row .col-md-4 {
                    width: 100%;
                    max-width: none;
                }

                .server-row .server-banner {
                    width: 100%;
                    height: auto;
                    max-width: none;
                }

                .server-row .row {
                    flex-direction: column;
                    align-items: center;
                }
            }

            @media (max-width: 575.98px) {
                .server-row .d-flex.align-items-center {
                    flex-direction: column;
                }

                .server-row .server-logo {
                    margin-bottom: 10px;
                }
            }
        </style>
    @endpush

    <div class="container py-4">
        <div aria-label="breadcrumb" class="custom-design card-header-custom py-2 px-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }} " class="text-decoration-none title-color">Minecraft Servers List</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $serverDetail->name }}</li>
            </ol>
        </div>

        <div class="custom-design-2 py-4">
            <div>
                <h1 class="server-title fw-bold fs-4 mb-3">{{ $serverDetail->name }}</h1>
                <div class="d-flex flex-column flex-md-row justify-content-start align-items-center mb-4 gap-3">
                    <div class="server-logo-container">
                        <img src="{{ $serverDetail->logo_image_url }}" alt="{{ $serverDetail->name }}"
                            class="img-fluid server-logo">
                    </div>
                    <div class="server-banner-container">
                        {{-- <video src="{{ asset('img/server-banner.mp4') }}" class="server-banner-video" muted=""
                            autoplay="" loop="" playsinline="" allowfullscreen="false"></video> --}}
                        <img src="{{ $serverDetail->banner_image_url }}" class="server-banner-img"
                            alt="{{ $serverDetail->name }}">
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('server-listing.vote', $serverDetail->slug) }}" class="btn btn-success">
                    <i class="bi bi-hand-thumbs-up me-1"></i> Vote
                </a>
                <a href="{{ route('home') }}" class="btn btn-warning"><i class="bi bi-house"></i></a>
                <a href="{{ route('server-listing.favorite', $serverDetail->slug) }}" class="btn btn-warning">
                    @if ($serverDetail->isSelfFavorite())
                        <i class="bi bi-heart-fill text-danger"></i>
                    @else
                        <i class="bi bi-heart text-danger"></i>
                    @endif
                </a>
                {{-- <button class="btn btn-warning"><i class="bi bi-info-circle"></i></button>
                <button class="btn btn-warning"><i class="bi bi-question-circle"></i></button>
                <button class="btn btn-warning"><i class="bi bi-bar-chart"></i></button>

                <button class="btn btn-warning"><i class="bi bi-exclamation-triangle"></i></button> --}}
            </div>
        </div>

        <div class="mt-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header card-header-custom fw-semibold">
                            <i class="fas fa-info-circle me-2"></i> Server Information
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-play me-2"></i> Address</span>
                                <span>
                                    <button class="btn btn-sm btn-outline-secondary copy-btn me-2" title="Copy"
                                        onclick="copyIP('{{ $serverDetail->server_ip }}:{{ $serverDetail->server_port }}')">
                                        <i class="bi bi-clipboard-check"></i>
                                    </button>
                                    {{ $serverDetail->server_ip }}:{{ $serverDetail->server_port }}
                                </span>
                            </div>

                            <div class="border-bottom py-3">
                                <i class="fas fa-comment me-2"></i> MOTD
                                <div class="custom-design text-white p-2 mt-2 rounded" style="font-family: monospace;">
                                    <span style="color: var(--primary-orange);">{!! $serverDetail->motd !!}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-circle me-2"></i> Server Status</span>
                                <span class="text-success fw-semibold">
                                    {{ $serverDetail->online_label }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-users me-2"></i> Players</span>
                                <span>{{ $serverDetail->current_players }} / {{ $serverDetail->max_players }}</span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-map-marker-alt me-2"></i> Location</span>
                                <span><img style="height: 12px; width: 20px;" class="me-1"
                                        src="https://flagcdn.com/{{ strtolower($serverDetail?->country?->code) }}.svg"
                                        alt=""> {{ $serverDetail?->country?->name }}</span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-cube me-2"></i> Minecraft Version</span>
                                <span><span class="badge bg-primary">{{ $serverDetail->minecraft_version }}</span></span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-globe me-2"></i> Website</span>
                                <span>
                                    <a href="{{ $serverDetail->website_url }}" class="text-decoration-none"
                                        target="_blank">
                                        {{ $serverDetail->website_url }}
                                    </a>
                                </span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-user me-2"></i> Registered By</span>
                                <span>{{ $serverDetail->user?->name }}</span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-calendar me-2"></i> Registered Since</span>
                                <span>{{ $serverDetail->created_at_formatted }}</span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-clock me-2"></i> Last Update</span>
                                <span>{{ $serverDetail->updated_at_formatted }}</span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-palette me-2"></i> Theme</span>
                                <span><span class="badge bg-secondary">Modern</span></span>
                            </div>

                            <div class="py-2">
                                <i class="fas fa-tags me-2"></i> Game Modes / Tags:<br />

                                @forelse ($serverDetail->serverTags as $tag)
                                    <span
                                        class="badge tag-badge {{ Arr::random(tagsBgColors()) }} text-white">{{ $tag->name }}</span>
                                @empty
                                    <p class="text-muted">No game modes / tags available</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header card-header-custom fw-semibold">
                            <i class="fas fa-chart-line me-2"></i> Statistics
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span><i class="fas fa-clock me-2"></i> Uptime</span>
                                <span class="text-success fw-bold">{{ $serverDetail->getUpTimePercentage() }}%</span>
                            </div>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span><i class="fas fa-thumbs-up me-2"></i> Vote(s)</span>
                                <span>{{ $serverDetail->total_votes }}</span>
                            </div>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span><i class="fas fa-trophy me-2"></i> Rank</span>
                                <span>{{ $serverDetail->getRankByVotes() }}</span>
                            </div>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span><i class="fas fa-star me-2"></i> Score</span>
                                <span>{{ $serverDetail->calculateRankScore() }}</span>
                            </div>


                            <div class="d-flex justify-content-between pt-2">
                                <span><i class="fas fa-heart me-2"></i> Favorited</span>
                                <span>{{ $serverDetail->favorites_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header card-header-custom">
                <i class="fab fa-discord me-2"></i>Discord Server
            </div>
            <div class="card-body discord-widget">
                <i class="fab fa-discord" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h5>{{ $serverDetail->name }}</h5>
                <p>Minecraft Server</p>
                <a href="{{ $serverDetail->discord_url }}" target="_blank" class="btn btn-light">Join Discord</a>
            </div>
        </div>

        <div class="mt-4">
            <div class="card-header-custom">
                <i class="fas fa-play me-2"></i>Server Video
            </div>
            <div style="border-radius: 0 0 10px 10px; overflow: hidden">
                <iframe width="100%" height="641"
                    src="https://www.youtube.com/embed/{{ $serverDetail->youtube_video_id }}"
                    title="How to INSTALL PIXELMON! *FASTEST GUIDE* | Minecraft Pokemon Mod" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

        </div>

        <div class="card mt-4">
            <div class="card-header card-header-custom">
                <i class="fas fa-file-alt me-2"></i>About This Server
            </div>
            <div class="card-body">
                {!! $serverDetail->description !!}
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header card-header-custom">
                <i class="fas fa-server me-2"></i>Other Servers
            </div>
            <div class="card-body">
                <div class="server-row">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <div class="server-logo me-3">
                                    <img src="{{ asset('img/server-logo.png') }}" alt="Server Logo">
                                </div>
                                <div class="server-rank">
                                    <div class="simple-server-badge">
                                        <i class="bi bi-trophy text-white"></i>
                                        <span class="fw-bold simple-server-text">#3</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="server-banner">
                                <video src="{{ asset('img/server-banner.mp4') }}" autoplay loop muted
                                    class="w-100"></video>
                                <div class="banner-overlay">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="badge version-badge me-2">
                                                <i class="bi bi-gear me-1"></i> 1.16.5
                                            </span>
                                            <i class="bi bi-flag me-1"></i>
                                            <a class="text-white text-decoration-none" href="" target="_blank">
                                                <small>play.dynamic-craft.com</small>
                                            </a>
                                        </div>
                                        <button class="btn btn-sm copy-btn" onclick="copyIP('play.dynamic-craft.com')">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center">
                                <span class="player-count">
                                    500/1000
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center">
                                <span class="badge status-badge">
                                    <i class="bi bi-circle-fill me-1 pulse"></i> Online
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Copy IP functionality
        function copyIP(ip) {
            navigator.clipboard.writeText(ip).then(function() {
                showToast(`Server IP "${ip}" copied to clipboard!`, 'success');
            }).catch(function(err) {
                showToast('Failed to copy IP address', 'error');
                console.error('Could not copy text: ', err);
            });
        }

        // Toast notification system
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
                        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
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
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
            return container;
        }
    </script>

@endsection
