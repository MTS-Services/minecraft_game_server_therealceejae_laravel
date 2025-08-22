@extends('layouts.base')
@section('title', 'Search Minecraft Servers')
@include('server-listing::admin.elements.select')
@section('app')
    @push('styles')
        <style>
            .search-container {
                max-width: 1200px;
                margin: 40px auto;
                padding: 20px;
            }

            .search-card {
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                padding: 30px;
            }

            .search-title {
                color: #343a40;
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 30px;
            }

            .form-label {
                font-weight: 600;
                color: #495057;
            }

            .form-select,
            .form-control {
                border-radius: 8px;
                border-color: #dee2e6;
            }

            .btn-primary {
                background-color: #28a745;
                border-color: #28a745;
                font-weight: 600;
                border-radius: 8px;
                padding: 10px 25px;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #218838;
                border-color: #1e7e34;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
            }

            .tag-list-section {
                margin-top: 20px;
            }

            .tag-list-title {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 15px;
            }

            .form-check-label {
                cursor: pointer;
                color: #6c757d;
            }

            .form-check-input:checked+.form-check-label {
                font-weight: 600;
                color: #212529;
            }

            .result-section {
                margin-top: 40px;
            }

            .result-title {
                font-size: 1.75rem;
                font-weight: 600;
                color: #343a40;
            }
        </style>
    @endpush
    <div class="container search-container">

        <div class="search-card">
            <h1 class="search-title">Minecraft Server Search</h1>

            <form action="{{ route('server-listing.search.filter') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="keyword" class="form-label">Keyword</label>
                        <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Enter keyword">
                    </div>
                    <div class="col-md-6">
                        <label for="mc-version" class="form-label">Minecraft Version</label>
                        <select id="mc-version" name="version" class="form-select">
                            <option selected value="">All</option>
                            @foreach ($minecraft_versions as $version)
                                <option value="{{ $version }}">{{ $version }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Location</label>
                        <select id="location" class="form-select" name="country">
                            <option selected value="">All</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->code }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="col-md-6">
                        <label for="theme" class="form-label">Theme</label>
                        <select id="theme" class="form-select">
                            <option selected>All Service</option>
                            <option>Survival</option>
                            <option>Creative</option>
                            <option>Minigames</option>
                            <option>Roleplay</option>
                            <option>...</option>
                        </select>
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <label for="tag" class="form-label">Tags/Game Mode</label>
                        <select id="tag" name="tag" class="form-select">
                            <option selected value="">All</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <label for="theme" class="form-label">Ping</label>
                        <div class="col-lg-5 d-flex">
                            <select id="theme" class="form-select">

                                <option value=""></option>
                                <option value="inferior">&lt;=</option>

                            </select>
                            <select id="theme" class="form-select col-12">

                                <option value=""></option>
                                <option value="10">Australia, Sydney</option>
                                <option value="7">Brazil, Rio de Janeiro</option>
                                <option value="11">China, Hong Kong</option>
                                <option value="6">Eastern Europe</option>
                                <option value="12">Germany, Frankfurt</option>
                                <option value="2">North America</option>
                                <option value="8">Russia, Moscow</option>
                                <option value="15">South Africa</option>
                                <option value="14">Spain, Madrid</option>
                                <option value="9">Sweden, Stockholm</option>
                                <option value="4">US, Chicago</option>
                                <option value="3">US, Dallas</option>
                                <option value="5">US, Los Angeles</option>
                                <option value="13">US, Portland</option>
                                <option value="1">Western Europe</option>

                            </select>
                            <select id="theme" class="form-select col-12">
                                <option selected>
                                <option value=""></option>
                                <option value="50">50ms</option>
                                <option value="100">100ms</option>
                                <option value="150">150ms</option>
                                <option value="200">200ms</option>
                                </option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <label for="players" class="form-label">Connected Players</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="online_min_players" placeholder="Min"
                                aria-label="Min">
                            <span class="input-group-text">to</span>
                            <input type="number" class="form-control" name="online_max_players" placeholder="Max"
                                aria-label="Max">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="players" class="form-label">Server Max. Players</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="min_total_players" placeholder="Min"
                                aria-label="Min">
                            <span class="input-group-text">to</span>
                            <input type="number" class="form-control" name="max_total_players" placeholder="Max"
                                aria-label="Max">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="order-by" class="form-label">Order By</label>
                        <div class="input-group ">
                            <select id="order-by" class="form-select col-6" name="order_by">
                                <option selected value="server_rank">Rank</option>
                                <option value="current_players">Online Players</option>
                                <option value="max_players">Max Players</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="order-by" class="form-label">With Teamspeak Server </label>
                        <div class="input-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="with_teamspeak" id="tag-survival">
                                <label class="form-check-label" for="tag-survival"></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="order-by" class="form-label">With Discord Server</label>
                        <div class="input-group">
                            <div class="form-check">
                                <input class="form-check-input" name="with_discord" type="checkbox" id="tag-survival">
                                <label class="form-check-label" for="tag-survival"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tag-list-section mt-4">
                    <h5 class="tag-list-title">Tags</h5>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                @foreach ($tags->chunk(8) as $tagsChunk)
                                    <div class="col-md-3 col-sm-6 mb-2">
                                        @foreach ($tagsChunk as $tag)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="tag-survival-{{ $tag->id }}" name="tags[]"
                                                    value="{{ $tag->id }}">
                                                <label class="form-check-label"
                                                    for="tag-survival-{{ $tag->id }}">{{ $tag->name }}</label>
                                            </div>
                                        @endforeach

                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>


                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </form>
        </div>

    </div>
@endsection
