@extends('layouts.base')@section('title', trans('messages.home'))@section('app') <!-- Minecraft Landscape Header -->
<div class="minecraft-header position-relative overflow-hidden"> <img
        src="https://placehold.co/1080x200/png?text=Minecraft+Landscape" alt="Minecraft Landscape" class="w-100"
        style="height: 200px; object-fit: cover; object-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100"
        style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.3) 100%);"></div>
</div>
<div class="container content my-5"> @include('elements.session-alerts') <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold text-primary mb-3">Minecraft Server List</h1>
                <p class="lead text-muted">Find the best Minecraft servers to play on. Browse through our extensive list
                    of servers and find your perfect match!</p>
            </div>
        </div>
    </div> <!-- Search and Filter Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('server-listing.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group"> <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" name="search" placeholder="Search servers..."
                                    value="{{ request('search') }}"> </div>
                        </div>
                        <div class="col-md-3"> <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                <option value="survival">Survival</option>
                                <option value="creative">Creative</option>
                                <option value="pvp">PvP</option>
                                <option value="skyblock">Skyblock</option>
                                <option value="faction">Faction</option>
                                <option value="pixelmon">Pixelmon</option>
                            </select> </div>
                        <div class="col-md-3"> <select class="form-select" name="version">
                                <option value="">All Versions</option>
                                <option value="1.21.7">1.21.7</option>
                                <option value="1.21.6">1.21.6</option>
                                <option value="1.20">1.20</option>
                            </select> </div>
                        <div class="col-md-2"> <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> {{-- Top 10 Premium Servers --}} <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-trophy text-warning me-2"></i>Rank</h5>
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-gem text-primary me-2"></i>Top 10 Premium Server
                            </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold text-center"><i class="bi bi-people text-success me-2"></i>Players
                            </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold text-center"><i class="bi bi-circle text-info me-2"></i>Status</h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-tags text-secondary me-2"></i>Tags</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0"> <!-- Server 1 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span class="badge bg-info me-2"> <i
                                                    class="bi bi-gear"></i> 1.21.7</span> <i
                                                class="bi bi-flag me-1"></i> <small>mp.mc-complex.com</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.mc-complex.com')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">1246/5000</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-primary">Cobblemon</span>
                                    <span class="badge bg-warning">Faction</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-success">Pixelmon</span> <span
                                        class="badge bg-secondary">Pokemon</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 2 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.mcs.gg</small> <button class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.mcs.gg')"> <i class="bi bi-copy"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">240/2500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Economy</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-primary">McMMO</span> <span class="badge bg-success">PvP</span>
                                    <span class="badge bg-secondary">Roleplay</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 3 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#3</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>mp.connected.gg</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.connected.gg')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">33/2025</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-info">City</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-secondary">Discord</span> <span
                                        class="badge bg-warning">Economy</span> <span
                                        class="badge bg-success">Events</span> <span class="badge bg-danger">PvP</span>
                                    <span class="badge bg-dark">PvP</span> <span class="badge bg-primary">SMP</span>
                                    <span class="badge bg-warning">War</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 4 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#4</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.7</span> <i class="bi bi-flag me-1"></i>
                                            <small>go.advancius.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('go.advancius.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">175/500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-danger">BedWars</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Earth</span> <span
                                        class="badge bg-warning">KitPvP</span> <span class="badge bg-info">Land
                                        Claim</span> <span class="badge bg-dark">Skyblock</span> <span
                                        class="badge bg-secondary">SMP</span> <span
                                        class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 5 -->
                    <div class="server-row p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.20.4</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.example.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.example.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">4/5</h5> {{-- <small class="text-muted">Online
                                        Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Casual</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Economy</span> <span
                                        class="badge bg-info">Events</span> <span class="badge bg-secondary">Land
                                        Claim</span> <span class="badge bg-danger">McMMO</span> <span
                                        class="badge bg-dark">PvE</span> <span class="badge bg-primary">SMP</span> <span
                                        class="badge bg-warning">Survival</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 6 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.7</span> <i class="bi bi-flag me-1"></i>
                                            <small>mp.mc-complex.com</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.mc-complex.com')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">1246/5000</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-primary">Cobblemon</span>
                                    <span class="badge bg-warning">Faction</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-success">Pixelmon</span> <span
                                        class="badge bg-secondary">Pokemon</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 7 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.mcs.gg</small> <button class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.mcs.gg')"> <i class="bi bi-copy"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">240/2500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Economy</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-primary">McMMO</span> <span class="badge bg-success">PvP</span>
                                    <span class="badge bg-secondary">Roleplay</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 8 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#3</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>mp.connected.gg</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.connected.gg')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">33/2025</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-info">City</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-secondary">Discord</span> <span
                                        class="badge bg-warning">Economy</span> <span
                                        class="badge bg-success">Events</span> <span class="badge bg-danger">PvP</span>
                                    <span class="badge bg-dark">PvP</span> <span class="badge bg-primary">SMP</span>
                                    <span class="badge bg-warning">War</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 9 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#4</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.7</span> <i class="bi bi-flag me-1"></i>
                                            <small>go.advancius.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('go.advancius.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">175/500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-danger">BedWars</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Earth</span> <span
                                        class="badge bg-warning">KitPvP</span> <span class="badge bg-info">Land
                                        Claim</span> <span class="badge bg-dark">Skyblock</span> <span
                                        class="badge bg-secondary">SMP</span> <span
                                        class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 10 -->
                    <div class="server-row p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.20.4</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.example.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.example.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">4/5</h5> {{-- <small class="text-muted">Online
                                        Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Casual</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Economy</span> <span
                                        class="badge bg-info">Events</span> <span class="badge bg-secondary">Land
                                        Claim</span> <span class="badge bg-danger">McMMO</span> <span
                                        class="badge bg-dark">PvE</span> <span class="badge bg-primary">SMP</span> <span
                                        class="badge bg-warning">Survival</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- Middle Short Description --}} <div class="row">
        <div class="col-12">
            <div class="card shadow-sm bg-secondary text-white my-4">
                <div class="card-body">
                    <p class="m-0">Welcome on the top Minecraft server list. Find here all the best Minecraft servers
                        with the most popular gamemodes such as Pixelmon, Skyblock, LifeSteal, Survival, Prison,
                        Faction, Creative, Towny, McMMO and more. Navigate through the different categories in the menu
                        above and find the perfect server to suit your Minecraft gameplay needs. Our server list
                        supports Java and Bedrock cross-play servers.</p>
                </div>
            </div>
        </div>
    </div> {{-- Premium Servers --}} <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-trophy text-warning me-2"></i>Rank</h5>
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-gem text-primary me-2"></i>Premium Server </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold text-center"><i class="bi bi-people text-success me-2"></i>Players
                            </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold text-center"><i class="bi bi-circle text-info me-2"></i>Status </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-tags text-secondary me-2"></i>Tags</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0"> <!-- Server 1 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span class="badge bg-info me-2"> <i
                                                    class="bi bi-gear"></i> 1.21.7</span> <i
                                                class="bi bi-flag me-1"></i> <small>mp.mc-complex.com</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.mc-complex.com')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">1246/5000</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-primary">Cobblemon</span>
                                    <span class="badge bg-warning">Faction</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-success">Pixelmon</span> <span
                                        class="badge bg-secondary">Pokemon</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 2 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.mcs.gg</small> <button class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.mcs.gg')"> <i class="bi bi-copy"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">240/2500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Economy</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-primary">McMMO</span> <span class="badge bg-success">PvP</span>
                                    <span class="badge bg-secondary">Roleplay</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 3 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#3</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>mp.connected.gg</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.connected.gg')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">33/2025</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-info">City</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-secondary">Discord</span> <span
                                        class="badge bg-warning">Economy</span> <span
                                        class="badge bg-success">Events</span> <span class="badge bg-danger">PvP</span>
                                    <span class="badge bg-dark">PvP</span> <span class="badge bg-primary">SMP</span>
                                    <span class="badge bg-warning">War</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 4 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#4</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.7</span> <i class="bi bi-flag me-1"></i>
                                            <small>go.advancius.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('go.advancius.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">175/500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-danger">BedWars</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Earth</span> <span
                                        class="badge bg-warning">KitPvP</span> <span class="badge bg-info">Land
                                        Claim</span> <span class="badge bg-dark">Skyblock</span> <span
                                        class="badge bg-secondary">SMP</span> <span
                                        class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 5 -->
                    <div class="server-row p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.20.4</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.example.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.example.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">4/5</h5> {{-- <small class="text-muted">Online
                                        Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Casual</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Economy</span> <span
                                        class="badge bg-info">Events</span> <span class="badge bg-secondary">Land
                                        Claim</span> <span class="badge bg-danger">McMMO</span> <span
                                        class="badge bg-dark">PvE</span> <span class="badge bg-primary">SMP</span> <span
                                        class="badge bg-warning">Survival</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- Middle Short Description --}} <div class="row">
        <div class="col-12">
            <div class="card shadow-sm bg-secondary text-white my-4">
                <div class="card-body">
                    <p class="m-0">Welcome on the top Minecraft server list. Find here all the best Minecraft servers
                        with the most popular gamemodes such as Pixelmon, Skyblock, LifeSteal, Survival, Prison,
                        Faction, Creative, Towny, McMMO and more. Navigate through the different categories in the menu
                        above and find the perfect server to suit your Minecraft gameplay needs. Our server list
                        supports Java and Bedrock cross-play servers.</p>
                </div>
            </div>
        </div>
    </div> {{-- Wold Top Servers --}} <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-trophy text-warning me-2"></i>Rank</h5>
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-server text-primary me-2"></i>Server </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold text-center"><i class="bi bi-people text-success me-2"></i>Players
                            </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold text-center"><i class="bi bi-circle text-info me-2"></i>Status </h5>
                        </div>
                        <div class="col-md-2">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-tags text-secondary me-2"></i>Tags</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0"> <!-- Server 1 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span class="badge bg-info me-2"> <i
                                                    class="bi bi-gear"></i> 1.21.7</span> <i
                                                class="bi bi-flag me-1"></i> <small>mp.mc-complex.com</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.mc-complex.com')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">1246/5000</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-primary">Cobblemon</span>
                                    <span class="badge bg-warning">Faction</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-success">Pixelmon</span> <span
                                        class="badge bg-secondary">Pokemon</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 2 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.mcs.gg</small> <button class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.mcs.gg')"> <i class="bi bi-copy"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">240/2500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Economy</span> <span
                                        class="badge bg-info">LifeSteal</span> <span
                                        class="badge bg-primary">McMMO</span> <span class="badge bg-success">PvP</span>
                                    <span class="badge bg-secondary">Roleplay</span> <span
                                        class="badge bg-dark">Skyblock</span> <span class="badge bg-danger">SMP</span>
                                    <span class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 3 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#3</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.6</span> <i class="bi bi-flag me-1"></i>
                                            <small>mp.connected.gg</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('mp.connected.gg')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">33/2025</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-info">City</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-secondary">Discord</span> <span
                                        class="badge bg-warning">Economy</span> <span
                                        class="badge bg-success">Events</span> <span class="badge bg-danger">PvP</span>
                                    <span class="badge bg-dark">PvP</span> <span class="badge bg-primary">SMP</span>
                                    <span class="badge bg-warning">War</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 4 -->
                    <div class="server-row border-bottom p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#4</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.21.7</span> <i class="bi bi-flag me-1"></i>
                                            <small>go.advancius.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('go.advancius.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">175/500</h5> {{-- <small
                                        class="text-muted">Online Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-danger">BedWars</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Earth</span> <span
                                        class="badge bg-warning">KitPvP</span> <span class="badge bg-info">Land
                                        Claim</span> <span class="badge bg-dark">Skyblock</span> <span
                                        class="badge bg-secondary">SMP</span> <span
                                        class="badge bg-primary">Survival</span> <span
                                        class="badge bg-warning">Towny</span> </div>
                            </div>
                        </div>
                    </div> <!-- Server 5 -->
                    <div class="server-row p-3 hover-bg">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="server-logo me-3"> <img src="https://placehold.co/50" alt="Server Logo"
                                            class="rounded" style="width: 50px; height: 50px;"> </div>
                                    <div> <i class="bi bi-trophy text-warning"></i> <span class="fw-bold">#5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="server-banner position-relative"> <img src="https://placehold.co/70X400"
                                        alt="Server Banner" class="rounded w-100"
                                        style="height: 70px; width: 100%; object-fit: cover;">
                                    <div class="server-info position-absolute bottom-0 start-0 p-2 text-white"
                                        style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                        <div class="d-flex align-items-center"> <span
                                                class="badge bg-info me-2">1.20.4</span> <i class="bi bi-flag me-1"></i>
                                            <small>play.example.net</small> <button
                                                class="btn btn-sm btn-outline-light ms-2"
                                                onclick="copyIP('play.example.net')"> <i class="bi bi-copy"></i>
                                            </button> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <h5 class="mb-0 text-success fw-bold">4/5</h5> {{-- <small class="text-muted">Online
                                        Players</small> --}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center"> <span class="badge bg-success fs-6 px-3 py-2"> <i
                                            class="bi bi-circle me-1"></i>Online </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex flex-wrap gap-1"> <span class="badge bg-warning">Casual</span> <span
                                        class="badge bg-primary">Cross-Play</span> <span
                                        class="badge bg-success">Economy</span> <span
                                        class="badge bg-info">Events</span> <span class="badge bg-secondary">Land
                                        Claim</span> <span class="badge bg-danger">McMMO</span> <span
                                        class="badge bg-dark">PvE</span> <span class="badge bg-primary">SMP</span> <span
                                        class="badge bg-warning">Survival</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- Pagination --}} <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Server pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"> <a class="page-link" href="#" tabindex="-1"
                            aria-disabled="true">Previous</a> </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"> <a class="page-link" href="#">Next</a> </li>
                </ul>
            </nav>
        </div>
    </div> <!-- Add Your Server CTA -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient text-white"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-center py-5">
                    <h2 class="fw-bold mb-3">Want to promote your server?</h2>
                    <p class="lead mb-4">Get your Minecraft server listed and reach thousands of potential players! </p>
                    <a href="{{ route('server-listing.submit') }}" class="btn btn-light btn-lg px-5"> <i
                            class="bi bi-plus me-2"></i>Add Your Server </a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
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
        .server-row .row>div {
            margin-bottom: 1rem;
        }

        .server-banner {
            margin-bottom: 1rem;
        }
    }
</style>
<script> function copyIP(ip) { navigator.clipboard.writeText(ip).then(function () { // Create a temporary toast notification const toast = document.createElement('div'); toast.className = 'position-fixed top-0 end-0 m-3 alert alert-success alert-dismissible fade show'; toast.style.zIndex = '9999'; toast.innerHTML = ` <i class="bi bi-check-circle me-2"></i> Server IP "${ip}" copied to clipboard! <button type="button" class="btn-close" data-bs-dismiss="alert"></button> `; document.body.appendChild(toast); // Auto remove after 3 seconds setTimeout(() => { if (toast.parentNode) { toast.parentNode.removeChild(toast); } }, 3000); }).catch(function(err) { console.error('Could not copy text: ', err); }); } </script>
@endsectionin