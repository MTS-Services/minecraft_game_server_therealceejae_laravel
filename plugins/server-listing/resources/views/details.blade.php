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
                --spacing-sm: 0.5rem;
                --spacing-lg: 1.5rem;
                --spacing-xl: 2rem;

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

            .discord-widget {
                background: #7289da;
                color: var(--text-white);
                border-radius: 0 0 5px 5px;
                padding: 1rem;
                text-align: center;
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

            /* Badges */
            .version-badge {
                background: linear-gradient(135deg, var(--primary-blue), var(--primary-green));
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
                border-radius: var(--border-radius-sm);
                border: none;
                font-weight: 600;
            }

            .status-badge {
                background: var(--status-online);
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
                border-radius: 15px;
                font-weight: 600;
            }

            .status-badge.offline {
                background: var(--status-offline);
            }

            .player-count {
                font-size: 0.95rem;
                font-weight: 700;
                color: var(--primary-green);
            }

            .tag-badge {
                font-size: 0.6rem;
                padding: 0.2rem 0.4rem;
                border-radius: 10px;
                margin: 1px;
                font-weight: 500;
            }

            .copy-btn {
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: var(--text-white);
                font-size: 0.75rem;
                padding: 0.2rem 0.4rem;
                border-radius: var(--border-radius-sm);
                backdrop-filter: blur(5px);
                transition: all 0.2s ease;
            }

            .copy-btn:hover {
                background: var(--primary-blue);
                color: var(--text-white);
            }

            .premium-rank-badge {
                background: linear-gradient(135deg, var(--primary-gold), var(--primary-orange));
                color: var(--text-primary);
                font-size: 0.75rem;
                padding: 0.3rem 0.5rem;
                border-radius: var(--border-radius-sm);
                font-weight: 700;
            }

            .simple-server-badge {
                background: linear-gradient(135deg, var(--bg-dark), var(--text-secondary));
                padding: 0.3rem 0.5rem;
                border-radius: var(--border-radius-sm);
                font-size: 0.7rem;
                color: white;
            }

            .mobile-server-card {
                background: white;
                border-radius: 15px;
                margin-bottom: 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                border: 2px solid var(--border-primary);
            }

            .mobile-server-header {
                background: linear-gradient(135deg, var(--bg-dark), var(--bg-darker));
                color: white;
                padding: 1rem;
            }

            .mobile-server-content {
                padding: 1rem;
            }

            .mobile-server-banner {
                width: 100%;
                height: 120px;
                border-radius: 10px;
                overflow: hidden;
                position: relative;
                margin-bottom: 1rem;
            }

            .mobile-server-banner img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .mobile-banner-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
                padding: 0.5rem;
                color: white;
            }

            .mobile-server-info {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .mobile-server-logo {
                width: 50px;
                height: 50px;
                border-radius: 8px;
                overflow: hidden;
                border: 2px solid var(--border-light);
                position: relative;
            }

            .mobile-server-logo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .mobile-server-details h6 {
                margin: 0;
                font-weight: bold;
                color: var(--text-primary);
            }

            .mobile-server-stats {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .mobile-stat-item {
                text-align: center;
            }

            .mobile-stat-value {
                font-size: 1.2rem;
                font-weight: bold;
                color: var(--primary-green);
                display: block;
            }

            .mobile-stat-label {
                font-size: 0.8rem;
                color: var(--text-secondary);
            }

            .mobile-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 0.25rem;
                margin-bottom: 1rem;
            }

            /* Dark Mode Adjustments */
            [data-bs-theme="dark"] .server-row:hover {
                background-color: var(--bg-dark);
            }

            [data-bs-theme="dark"] .mobile-server-card {
                background: var(--bg-secondary);
                border-color: var(--border-dark);
            }

            [data-bs-theme="dark"] .mobile-server-details h6 {
                color: var(--text-white);
            }

            /* Animations */
            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            .details-link {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                z-index: 1;
                background: transparent;
            }

            /* Responsive Design */
            @media (max-width: 992px) {

                /* Hide desktop table headers on tablet and mobile */
                .desktop-table-header {
                    display: none !important;
                }

                /* Show mobile cards on tablet and mobile */
                .desktop-server-row {
                    display: none !important;
                }

                .mobile-server-row {
                    display: block !important;
                }
            }

            @media (min-width: 993px) {

                /* Show desktop table on desktop */
                .desktop-table-header {
                    display: block !important;
                }

                .desktop-server-row {
                    display: block !important;
                }

                /* Hide mobile cards on desktop */
                .mobile-server-row {
                    display: none !important;
                }
            }

            @media (max-width: 768px) {

                /* Header adjustments */
                .minecraft-header img {
                    height: 120px;
                }

                .minecraft-header .px-5 {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }

                /* Filter form - stack vertically on mobile */
                .filter_card .row.g-3>* {
                    margin-bottom: 0.5rem;
                }

                .filter_card .col-md-4,
                .filter_card .col-md-2,
                .filter_card .col-md-1 {
                    width: 100%;
                    max-width: none;
                }

                /* Mobile server cards spacing */
                .mobile-server-card {
                    margin-bottom: 1.5rem;
                }

                .mobile-server-banner {
                    height: 100px;
                }

                .mobile-server-logo {
                    width: 45px;
                    height: 45px;
                }

                .mobile-server-stats {
                    grid-template-columns: 1fr 1fr 1fr;
                    gap: 0.5rem;
                }

                .mobile-stat-value {
                    font-size: 1rem;
                }

                .mobile-stat-label {
                    font-size: 0.7rem;
                }

                /* Reduce spacing */
                .container.content {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                /* Card padding */
                .card-header-custom {
                    padding: 1rem;
                }

                .server-row {
                    padding: 1rem 0.5rem;
                }

                /* Badge sizing */
                .tag-badge {
                    font-size: 0.65rem;
                    padding: 0.15rem 0.3rem;
                    margin: 0.1rem;
                }

                /* Copy button sizing */
                .copy-btn {
                    padding: 0.3rem 0.5rem;
                    font-size: 0.7rem;
                }

                /* Player count sizing */
                .player-count {
                    font-size: 0.9rem;
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

            @media (max-width: 480px) {

                /* Extra small screens */
                .mobile-server-stats {
                    grid-template-columns: 1fr 1fr;
                }

                .mobile-server-banner {
                    height: 80px;
                }

                .mobile-server-logo {
                    width: 40px;
                    height: 40px;
                }

                .container.content {
                    margin-top: 1rem !important;
                    margin-bottom: 1rem !important;
                }

                .mobile-banner-overlay {
                    padding: 0.25rem;
                }

                .mobile-server-content {
                    padding: 0.75rem;
                }
            }

            /* Landscape mobile adjustments */
            @media (max-width: 768px) and (orientation: landscape) {
                .minecraft-header img {
                    height: 80px;
                }
            }

            /* Tablet specific adjustments */
            @media (min-width: 769px) and (max-width: 992px) {
                .mobile-server-banner {
                    height: 140px;
                }

                .mobile-server-logo {
                    width: 55px;
                    height: 55px;
                }

                .mobile-stat-value {
                    font-size: 1.3rem;
                }

                .mobile-server-stats {
                    grid-template-columns: 1fr 1fr 1fr;
                    gap: 1.5rem;
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
                @if ($serverDetail->isVoteAble())
                    <a href="{{ route('server-listing.vote', $serverDetail->slug) }}" class="btn btn-success">
                        <i class="bi bi-hand-thumbs-up me-1"></i> Vote
                    </a>
                @endif

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

                            {{-- <div class="d-flex justify-content-between border-bottom py-2">
                                <span><i class="fas fa-palette me-2"></i> Theme</span>
                                <span><span class="badge bg-secondary">Modern</span></span>
                            </div> --}}

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
                                <span>{{ $serverDetail->votes?->count() ?? 0 }}</span>
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

        @if ($serverDetail->youtube_video_id)
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
        @endif
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
                @forelse ($relatedServers as $index => $server)

                    <div class="server-row desktop-server-row">
                        <a href="{{ route('server-listing.details', $server->slug) }}" class="details-link"></a>
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3">
                                        <img src="{{ $server->logo_image_url }}" alt="Server Logo">
                                    </div>
                                    <div class="{{ $server->is_premium ? 'premium-rank' : 'server-rank' }}">
                                        <div
                                            class="{{ $server->is_premium ? 'premium-rank-badge' : 'simple-server-badge' }}">
                                            <i
                                                class="{{ $server->is_premium ? 'bi bi-gem text-black' : 'bi bi-trophy text-white' }} "></i>
                                            <span
                                                class="fw-bold {{ $server->is_premium ? 'premium-server-text' : 'simple-server-text' }}">#{{ $server->server_rank }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner">
                                    <img src="{{ $server->banner_image_url }}" alt="Server Banner">
                                    <div class="banner-overlay">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <span class="badge version-badge me-2">
                                                    <i
                                                        class="bi bi-gear me-1"></i>{{ remove_before_dash($server->minecraft_version) }}
                                                </span>

                                                <img style="height: 12px; width: 20px;" class="me-1"
                                                    src="https://flagcdn.com/{{ strtolower($server?->country?->code) }}.svg"
                                                    alt="">

                                                <span class="text-white text-decoration-none">
                                                    <small>{{ removeHttpFromUrl($server->server_ip) }}</small>
                                                </span>
                                            </div>
                                            <button class="btn btn-sm copy-btn"
                                                onclick="copyIP('{{ $server->server_ip }}')">
                                                <i class="bi bi-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <span class="player-count">
                                        {{ $server->current_players }}/{{ $server->max_players }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <span class="badge status-badge {{ $server->is_online ?: 'offline' }}">
                                        <i
                                            class="me-1 {{ $server->is_online ? 'pulse bi bi-circle-fill' : '' }}"></i>{{ __($server->online_label) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($server->serverTags as $tag)
                                        <span
                                            class="badge tag-badge {{ Arr::random(tagsBgColors()) }} text-white">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mobile-server-row">
                        <div class="mobile-server-card">
                            <div class="mobile-server-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="simple-server-badge me-2">
                                            <i class="bi bi-trophy text-white"></i>
                                            <span class="fw-bold">#{{ $index + 3 }}</span>
                                        </div>
                                        <h6 class="mb-0 text-white">
                                            <i class="bi bi-server me-1"></i>{{ __('Server') }}
                                        </h6>
                                    </div>
                                    <span class="badge status-badge {{ $server->is_online ?: 'offline' }}">
                                        <i class="me-1 {{ $server->is_online ? 'pulse bi bi-circle-fill' : '' }}"></i>
                                        {{ __($server->online_label) }}
                                    </span>
                                </div>
                            </div>
                            <div class="mobile-server-content">
                                <a href="{{ route('server-listing.details', $server->slug) }}" class="details-link"></a>

                                <div class="mobile-server-banner">
                                    <img src="{{ $server->banner_image_url }}" alt="Server Banner">
                                    <div class="mobile-banner-overlay">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <span class="badge version-badge me-2">
                                                    <i
                                                        class="bi bi-gear me-1"></i>{{ remove_before_dash($server->minecraft_version) }}
                                                </span>
                                                <img style="height: 10px; width: 16px;" class="me-1"
                                                    src="https://flagcdn.com/{{ strtolower($server?->country?->code) }}.svg"
                                                    alt="">
                                            </div>
                                            <button class="btn btn-sm copy-btn"
                                                onclick="copyIP('{{ $server->server_ip }}')">
                                                <i class="bi bi-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mobile-server-info">
                                    <div class="mobile-server-logo">
                                        <img src="{{ $server->logo_image_url }}" alt="Server Logo">
                                    </div>
                                    <div class="mobile-server-details flex-grow-1">
                                        <h6>{{ removeHttpFromUrl($server->server_ip) }}</h6>
                                        <small class="text-muted">{{ __('Minecraft Server') }}</small>
                                    </div>
                                </div>

                                <div class="mobile-server-stats">
                                    <div class="mobile-stat-item">
                                        <span class="mobile-stat-value player-count">{{ $server->current_players }}</span>
                                        <small class="mobile-stat-label">{{ __('Online') }}</small>
                                    </div>
                                    <div class="mobile-stat-item">
                                        <span class="mobile-stat-value player-count">{{ $server->max_players }}</span>
                                        <small class="mobile-stat-label">{{ __('Max') }}</small>
                                    </div>
                                </div>

                                <div class="mobile-tags">
                                    @foreach ($server->serverTags as $tag)
                                        <span
                                            class="badge tag-badge {{ Arr::random(tagsBgColors()) }} text-white">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col">
                        <div class="alert alert-warning text-center" role="alert">
                            <i class="bi bi-info-circle"></i> {{ __('No Related Servers found') }}
                        </div>
                    </div>
                @endforelse
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
