@extends('layouts.base')
@section('title', trans('messages.home'))
@section('app')
    <!-- Minecraft Landscape Header -->
    <div class="minecraft-header position-relative overflow-hidden">
        <img src="https://placehold.co/1080x200/png?text=Minecraft+Landscape" alt="Minecraft Landscape" class="w-100"
            style="height: 200px; object-fit: cover; object-position: center;">
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.3) 100%);"></div>
    </div>

    <div class="container content my-5">
        @include('elements.session-alerts')

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-primary mb-3">{{ __('Minecraft Server List') }}</h1>
                    <p class="lead text-muted">
                        {{ __('Find the best Minecraft servers to play on. Browse through our extensive list
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        of servers and find your perfect match!') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search servers..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="category">
                                    <option value="">All Categories</option>
                                    <option value="survival">Survival</option>
                                    <option value="creative">Creative</option>
                                    <option value="pvp">PvP</option>
                                    <option value="skyblock">Skyblock</option>
                                    <option value="faction">Faction</option>
                                    <option value="pixelmon">Pixelmon</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="version">
                                    <option value="">All Versions</option>
                                    <option value="1.21.7">1.21.7</option>
                                    <option value="1.21.6">1.21.6</option>
                                    <option value="1.20">1.20</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top 10 Premium Servers - Ultra Premium Design --}}
        @if (isset($topServers) && count($topServers) > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="premium-top10-container">
                        <!-- Premium Header with Animation -->
                        <div class="premium-top10-header text-center mb-4">
                            {{-- <div class="premium-crown-icon">
                            <i class="bi bi-gem premium-gem-icon"></i>
                        </div> --}}
                            <h2 class="premium-title">
                                <span class="premium-text-gradient"><i
                                        class="bi bi-gem me-2"></i>{{ __('TOP 10 PREMIUM SERVERS') }}<i
                                        class="bi bi-gem ms-2"></i></span>
                            </h2>
                            <p class="premium-subtitle m-0">
                                {{ __('The most exclusive and highest quality Minecraft servers') }}
                            </p>
                        </div>

                        <div class="card premium-top10-card border-0 shadow-lg">
                            <div class="premium-top10-card-header">
                                <div class="row align-items-center text-white">
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold"><i
                                                class="bi bi-trophy text-warning me-2"></i>{{ __('Rank') }}</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="mb-0 fw-bold"><i
                                                class="bi bi-gem text-warning me-2"></i>{{ __('Elite Servers') }}</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold text-center"><i
                                                class="bi bi-people text-warning me-2"></i>{{ __('Players') }}</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold text-center"><i
                                                class="bi bi-circle text-warning me-2"></i>{{ __('Status') }}</h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold"><i
                                                class="bi bi-tags text-warning me-2"></i>{{ __('Features') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0 premium-top10-body">

                                @foreach ($topServers as $topServer)
                                    <div class="premium-top10-row border-bottom p-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="elit-server-logo me-3 rounded"
                                                        style="height: 60px; width: 60px;">
                                                        <img src="{{ $topServer->logo_image_url }}" alt="Server Logo"
                                                            class="rounded object-fit-cover h-100 w-100">
                                                        <div class="premium-logo-badge">
                                                            <i class="bi bi-gem"></i>
                                                        </div>
                                                    </div>
                                                    <div class="premium-rank">
                                                        <div class="premium-rank-badge">
                                                            <i class="bi bi-gem text-dark"></i>
                                                            <span
                                                                class="fw-bold premium-rank-text">{{ __('#1') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="premium-server-banner position-relative"
                                                    style="height: 70px; width: 400px;">
                                                    <img src="{{ $topServer->banner_image_url }}" alt="Server Banner"
                                                        class="rounded w-100 h-100 object-fit-cover">
                                                    <div class="premium-server-overlay">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge premium-version-badge me-2">
                                                                    <i class="bi bi-gear me-1"></i>
                                                                    {{ __($topServer->version) }}
                                                                </span>
                                                                <i class="bi bi-flag me-1 text-warning"></i>
                                                                <a class="text-white fw-bold"
                                                                    href="{{ $topServer->website_url }}"
                                                                    target="_blank"><small>{{ removeHttpFromUrl($topServer->website_url) }}</small></a>
                                                            </div>
                                                            <button class="btn btn-sm premium-copy-btn"
                                                                onclick="copyIP('{{ $topServer->website_url }}')">
                                                                <i class="bi bi-copy"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text-center ">
                                                    <h4 class="mb-0 premium-count-text">
                                                        {{ $topServer->current_players }}/{{ $topServer->max_players }}
                                                    </h4>
                                                    {{-- <small class="premium-count-label">Active Players</small> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text-center">
                                                    <span class="badge premium-status-badge">
                                                        <i class="bi bi-circle-fill me-1 premium-pulse"></i>
                                                        {{ __($topServer->online_label) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach (json_decode(json_decode($topServer->tags, true)[0], true) as $tag)
                                                        <span
                                                            class="badge {{ Arr::random(tagsBgColors()) }}">{{ $tag['value'] }}</span>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Premium Servers - Premium Design --}}
        @if (isset($premiumServers) && count($premiumServers) > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="premium-container">
                        <!-- Premium Header -->
                        <div class="premium-header text-center my-4">
                            <h3 class="premium-section-title">
                                <i class="bi bi-star-fill text-warning me-2"></i>
                                <span class="premium-gradient-text">{{ __('PREMIUM SERVERS') }}</span>
                                <i class="bi bi-star-fill text-warning ms-2"></i>
                            </h3>
                            <p class="premium-section-subtitle m-0">
                                {{ __('High-quality servers with enhanced features') }}
                            </p>
                        </div>

                        <div class="card premium-card border-0 shadow">
                            <div class="premium-card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold premium-header-text">
                                            <i class="bi bi-trophy text-info me-2"></i>{{ __('Rank') }}
                                        </h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="mb-0 fw-bold premium-header-text">
                                            <i class="bi bi-gem text-info me-2"></i>{{ __('Premium Server') }}
                                        </h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold text-center premium-header-text">
                                            <i class="bi bi-people text-info me-2"></i>{{ __('Players') }}
                                        </h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold text-center premium-header-text">
                                            <i class="bi bi-circle text-info me-2"></i>{{ __('Status') }}
                                        </h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="mb-0 fw-bold premium-header-text">
                                            <i class="bi bi-tags text-info me-2"></i>{{ __('Tags') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0 premium-body">

                                @foreach ($premiumServers as $premiumServer)
                                    <div class="premium-server-row border-bottom p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="premium-logo-container me-3"
                                                        style="height: 60px; width: 60px;">
                                                        <img src="{{ $premiumServer->logo_image_url }}" alt="Server Logo"
                                                            class="rounded premium-server-logo h-100 w-100 object-fit-cover">
                                                        <div class="premium-logo-badge">
                                                            <i class="bi bi-star-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="premium-rank-container">
                                                        <i class="bi bi-award text-warning"></i>
                                                        <span
                                                            class="fw-bold premium-rank-number">{{ __('#1') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="premium-banner-container position-relative"
                                                    style="height: 70px; width: 400px;">
                                                    <img src="{{ $premiumServer->banner_image_url }}" alt="Server Banner"
                                                        class="rounded w-100 premium-banner h-100 w-100 object-fit-cover">
                                                    <div class="premium-banner-overlay">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge premium-version me-2">
                                                                    <i class="bi bi-gear me-1"></i>
                                                                    {{ $premiumServer->version }}
                                                                </span>
                                                                <i class="bi bi-flag me-1"></i>
                                                                <a class="text-white"
                                                                    href="{{ $premiumServer->website_url }}"
                                                                    target="_blank"><small>{{ removeHttpFromUrl($premiumServer->website_url) }}</small></a>
                                                            </div>
                                                            <button class="btn btn-sm premium-copy-button"
                                                                onclick="copyIP('{{ $premiumServer->website_url }}')">
                                                                <i class="bi bi-copy"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text-center">
                                                    <h5 class="mb-0 premium-player-number">
                                                        {{ $premiumServer->current_players }}/{{ $premiumServer->max_players }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text-center">
                                                    <span class="badge premium-online-badge">
                                                        <i
                                                            class="bi bi-circle-fill me-1 premium-online-pulse"></i>{{ $premiumServer->online_label }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach (json_decode(json_decode($premiumServer->tags, true)[0], true) as $tag)
                                                        <span
                                                            class="badge {{ Arr::random(tagsBgColors()) }}">{{ $tag['value'] }}</span>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Additional premium servers would follow -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Middle Description --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm bg-secondary text-white my-4">
                    <div class="card-body">
                        <p class="m-0">
                            {{ __('Welcome on the top Minecraft server list. Find here all the best Minecraft servers with the most popular gamemodes such as Pixelmon, Skyblock, LifeSteal, Survival, Prison, Faction, Creative, Towny, McMMO and more. Navigate through the different categories in the menu above and find the perfect server to suit your Minecraft gameplay needs. Our server list supports Java and Bedrock cross-play servers.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Wold Top Servers --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm server-card">
                    <div class="server-card-header">
                        <div class="row align-items-center text-white">
                            <div class="col-md-2">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-trophy text-dark me-2"></i>{{ __('Rank') }}
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-server text-dark me-2"></i>{{ __('Server') }}
                                </h5>
                            </div>
                            <div class="col-md-2">
                                <h5 class="mb-0 fw-bold text-center"><i
                                        class="bi bi-people text-dark me-2"></i>{{ __('Players') }}
                                </h5>
                            </div>
                            <div class="col-md-2">
                                <h5 class="mb-0 fw-bold text-center"><i
                                        class="bi bi-circle text-dark me-2"></i>{{ __('Status') }}
                                </h5>
                            </div>
                            <div class="col-md-2">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-tags text-dark me-2"></i>{{ __('Features') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if (isset($popularServers) && count($popularServers) > 0)

                            @foreach ($popularServers as $popularServer)
                                <div class="server-row border-bottom p-3 hover-bg">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center">
                                                <div class="server-logo me-3" style="width: 60px; height: 60px;">
                                                    <img src="{{ $popularServer->logo_image_url }}" alt="Server Logo"
                                                        class="rounded h-100 w-100 object-fit-cover">
                                                </div>
                                                <div class="server-rank">
                                                    <div class="simple-server-badge">
                                                        <i class="bi bi-trophy text-white"></i>
                                                        <span
                                                            class="fw-bold simple-server-text">{{ __('#1') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="premium-banner-container position-relative"
                                                style="height: 70px; width: 400px;">
                                                <img src="{{ $popularServer->banner_image_url }}" alt="Server Banner"
                                                    class="rounded w-100 premium-banner h-100 w-100 object-fit-cover">
                                                <div class="premium-banner-overlay">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge premium-version me-2">
                                                                <i
                                                                    class="bi bi-gear me-1"></i>{{ $popularServer->version }}
                                                            </span>
                                                            <i class="bi bi-flag me-1"></i>
                                                            <a class="text-white"
                                                                href="{{ $popularServer->website_url }}"
                                                                target="_blank"><small>{{ removeHttpFromUrl($popularServer->website_url) }}</small></a>
                                                        </div>
                                                        <button class="btn btn-sm premium-copy-button"
                                                            onclick="copyIP('{{ $popularServer->website_url }}')">
                                                            <i class="bi bi-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="text-center">
                                                <h5 class="mb-0 premium-player-number">
                                                    {{ $popularServer->current_players }}/{{ $popularServer->max_players }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="text-center">
                                                <span class="badge premium-online-badge">
                                                    <i
                                                        class="bi bi-circle-fill me-1 premium-online-pulse"></i>{{ $popularServer->online_label }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach (json_decode(json_decode($popularServer->tags, true)[0], true) as $tag)
                                                    <span
                                                        class="badge {{ Arr::random(tagsBgColors()) }}">{{ $tag['value'] }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="server-row border-bottom p-3 hover-bg">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <h5 class="mb-0 fw-bold">No servers found.</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm server-listing-card text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-center py-5">
                        <h2 class="fw-bold mb-3">Want to promote your server?</h2>
                        <p class="lead mb-4">Get your Minecraft server listed and reach thousands of potential players!
                        </p>
                        <a href="" class="btn btn-light btn-lg px-5"> <i class="bi bi-plus me-2"></i>Add Your
                            Server </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination and CTA sections remain the same -->
    </div>

    <style>
        .server-listing-card {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
        }

        /* Top 10 Premium Servers - Ultra Premium Styling */
        .premium-top10-container {
            position: relative;
        }

        .premium-top10-header {
            background: linear-gradient(135deg, #ffd700, #ffed4e, #ffd700);
            background-size: 200% 200%;
            animation: premiumGradient 3s ease infinite;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
        }

        .premium-crown-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .premium-gem-icon {
            color: #ffd700;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
            animation: gemPulse 2s ease-in-out infinite;
        }

        .premium-title {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }

        .premium-text-gradient {
            background: linear-gradient(45deg, #ffd700, #ff6b35, #ffd700);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textShine 3s ease-in-out infinite;
        }

        .premium-subtitle {
            color: #333;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .premium-top10-card {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 3px solid transparent;
            background: linear-gradient(white, white) padding-box,
                linear-gradient(45deg, #ffd700, #ff6b35) border-box;
        }

        .premium-top10-card-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            padding: 1.5rem;
            border-bottom: 3px solid #ffd700;
        }

        .premium-top10-body {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
        }

        .premium-top10-row {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .premium-top10-row::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.1), transparent);
            transition: left 0.5s;
        }

        .premium-top10-row:hover::before {
            left: 100%;
        }

        .premium-top10-row:hover {

            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.2);
        }

        .premium-top10-row:hover .elit-server-logo {
            border: 2px solid #ffd700;
        }



        .elit-server-logo {
            position: relative;
            width: 60px;
            height: 60px;
        }

        .premium-logo-glow {
            animation: logoGlow 2s ease-in-out infinite alternate;
        }

        .premium-rank-badge {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
            color: white;
        }

        .premium-server-text {
            color: #1a1a2e;
        }

        .simple-server-badge {
            background: linear-gradient(135deg, #6c757d, #adb5bd);
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
            color: white;
        }

        .simple-server-text {
            color: white;
        }

        .premium-server-banner {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .premium-banner-glow {
            height: 80px;
            transition: all 0.3s ease;
        }

        .premium-server-banner:hover .premium-banner-glow {
            transform: scale(1.05);
            box-shadow: 0 15px 35px rgba(255, 215, 0, 0.3);
        }

        .premium-server-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
            padding: 1rem;
        }

        .premium-version-badge {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            border: none;
            font-weight: 600;
        }

        .premium-copy-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            backdrop-filter: blur(10px);
        }

        .premium-copy-btn:hover {
            background: rgba(255, 215, 0, 0.8);
            color: #1a1a2e;
        }

        .premium-player-count {
            background: linear-gradient(135deg, #28a745, #20c997);
            padding: 1rem;
            border-radius: 15px;
            color: white;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .premium-count-text {
            font-size: 1.5rem;
            font-weight: 900;
        }

        .premium-count-label {
            opacity: 0.9;
            font-weight: 500;
        }

        .premium-status-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            font-size: 1rem;
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .premium-pulse {
            animation: pulse 1.5s ease-in-out infinite;
        }

        .premium-tag {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            margin: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .premium-tag-1 {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .premium-tag-2 {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .premium-tag-3 {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .premium-tag-4 {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        .premium-tag-5 {
            background: linear-gradient(135deg, #fa709a, #fee140);
        }

        .premium-tag-6 {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
        }

        /* Premium Servers - Premium Styling */

        .premium-header {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            padding: 1.5rem;
            border-radius: 15px;
            border: 2px solid #e1bee7;
        }

        .premium-section-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .premium-gradient-text {
            background: linear-gradient(45deg, #9c27b0, #673ab7, #3f51b5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .premium-section-subtitle {
            color: #666;
            font-size: 1rem;
            font-weight: 500;
        }

        .premium-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            border: 2px solid #e1bee7;
        }

        .premium-card-header {
            background: linear-gradient(135deg, #9c27b0, #673ab7);
            padding: 1.2rem;
            color: white;
        }

        .server-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            border: 2px solid #e1bee7;
        }

        .server-card-header {
            background: linear-gradient(135deg, #6c757d, #adb5bd);
            padding: 1.2rem;
            color: white;
        }

        .premium-header-text {
            color: white;
        }

        .premium-body {
            background: linear-gradient(135deg, #fafafa, #f5f5f5);
        }

        .premium-server-row {
            transition: all 0.3s ease;
            position: relative;
        }

        .premium-server-row:hover {
            transform: translateX(10px);
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            box-shadow: 0 10px 25px rgba(156, 39, 176, 0.15);
        }

        .premium-server-row:hover .premium-server-logo {
            border: 2px solid #9c27b0;
        }


        .premium-logo-container,
        .premium-server-logo {
            position: relative;
        }

        .premium-server-logo {
            width: 55px;
            height: 55px;
            /* border: 2px solid #9c27b0; */
            box-shadow: 0 5px 15px rgba(156, 39, 176, 0.2);
        }

        .premium-logo-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: #1a1a2e;
        }

        .premium-rank-container {
            background: linear-gradient(135deg, #9c27b0, #673ab7);
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
            color: white;
        }

        .premium-rank-number {
            color: white;
            font-size: 1.1rem;
        }

        .premium-banner-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .premium-banner {
            height: 75px;
            transition: all 0.3s ease;
        }

        .premium-banner-container:hover .premium-banner {
            transform: scale(1.03);
        }

        .premium-banner-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 0.8rem;
        }

        .premium-version {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            border: none;
            font-weight: 600;
        }

        .premium-copy-button {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            backdrop-filter: blur(5px);
        }

        .premium-copy-button:hover {
            background: rgba(156, 39, 176, 0.8);
            color: white;
        }

        .premium-players {
            background: linear-gradient(135deg, #28a745, #20c997);
            padding: 0.8rem;
            border-radius: 12px;
            color: white;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .premium-player-number {
            font-size: 1.3rem;
            font-weight: 800;
        }

        .premium-player-text {
            opacity: 0.9;
            font-weight: 500;
        }

        .premium-online-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            font-size: 0.9rem;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .premium-online-pulse {
            animation: pulse 1.5s ease-in-out infinite;
        }

        .premium-feature-tag {
            font-size: 0.7rem;
            padding: 0.3rem 0.6rem;
            border-radius: 15px;
            font-weight: 600;
            margin: 1px;
        }

        .premium-feature-1 {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .premium-feature-2 {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .premium-feature-3 {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .premium-feature-4 {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        /* Animations */
        @keyframes premiumGradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes gemPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes textShine {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes logoGlow {
            0% {
                box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
            }

            100% {
                box-shadow: 0 0 30px rgba(255, 215, 0, 0.8);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Dark Mode Support */
        [data-bs-theme="dark"] .premium-top10-header {
            background: linear-gradient(135deg, #b8860b, #daa520, #b8860b);
        }

        [data-bs-theme="dark"] .premium-subtitle {
            color: #1a1a2e;
        }

        [data-bs-theme="dark"] .premium-top10-body {
            background: linear-gradient(135deg, #2d3748, #4a5568);
        }

        [data-bs-theme="dark"] .premium-header {
            background: linear-gradient(135deg, #2d3748, #4a5568);
            border-color: #9c27b0;
        }

        [data-bs-theme="dark"] .premium-section-subtitle {
            color: #a0aec0;
        }

        [data-bs-theme="dark"] .premium-body {
            background: linear-gradient(135deg, #2d3748, #4a5568);
        }

        [data-bs-theme="dark"] .premium-server-row:hover {
            background: linear-gradient(135deg, #4a5568, #718096);
        }

        /* Original styles for regular servers remain unchanged */
        .minecraft-header {
            border-bottom: 3px solid #4CAF50;
        }

        .server-row {
            transition: all 0.2s ease-in-out;
        }

        .hover-bg:hover {
            background-color: #f8f9fa !important;
            transform: translateX(5px);
        }

        [data-bs-theme="dark"] .hover-bg:hover {
            background-color: #495057 !important;
        }

        .server-banner img {
            transition: transform 0.2s ease-in-out;
        }

        .server-banner:hover img {
            transform: scale(1.05);
        }

        .badge {
            font-size: 0.7rem;
            margin: 1px;
        }

        .server-logo img {
            border: 2px solid #dee2e6;
            transition: border-color 0.2s ease-in-out;
        }

        .server-row:hover .server-logo img {
            border-color: #007bff;
        }

        .card {
            border-radius: 15px;
        }

        .server-banner {
            border-radius: 10px;
            overflow: hidden;
        }

        @media (max-width: 768px) {

            .server-row .row>div,
            .premium-server-row .row>div,
            .premium-top10-row .row>div {
                margin-bottom: 1rem;
            }

            .server-banner,
            .premium-banner-container,
            .premium-server-banner {
                margin-bottom: 1rem;
            }

            .premium-title {
                font-size: 1.8rem;
            }

            .premium-section-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <script>
        function copyIP(ip) {
            navigator.clipboard.writeText(ip).then(function() {
                const toast = document.createElement('div');
                toast.className = 'position-fixed top-0 end-0 m-3 alert alert-success alert-dismissible fade show';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>
                    Server IP "${ip}" copied to clipboard!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 3000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endsection
