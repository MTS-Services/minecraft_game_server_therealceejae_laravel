@extends('admin.layouts.admin')

@section('title', 'Vote Settings')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.vote.settings') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label"
                        for="topPlayersCount">Top Players Count</label>
                    <input type="number" class="form-control" id="topPlayersCount" name="top-players-count" min="5"
                        max="100"
                        value="{{ old('top-players-count', setting('server-listing.vote.top-players-count', 10)) }}"
                        required="required">
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="displayRewards" name="display-rewards"
                            @checked(old('display-rewards', setting('server-listing.vote.display-rewards', true)))>
                        <label class="form-check-label"
                            for="displayRewards">Display rewards on vote page</label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="ipCompatibility" name="ipv4-v6-compatibility"
                            @checked(old('ipv4-v6-compatibility', setting('server-listing.vote.ipv4-v6-compatibility', false))) aria-describedby="ipCompatibilityLabel">
                        <label class="form-check-label"
                            for="ipCompatibility">Enable IPv4/IPv6 compatibility</label>
                    </div>
                    <div id="ipCompatibilityLabel" class="form-text">
                        This allows users to vote on both IPv4 and IPv6 addresses, even if they are different.</div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="authRequired" name="auth-required"
                            @checked(old('auth-required', setting('server-listing.vote.auth-required', true)))>
                        <label class="form-check-label"
                            for="authRequired">Require authentication to vote</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Global Rewards Commands</label>
                    @include('admin.elements.list-input', [
                        'name' => 'commands',
                        'values' => json_decode(setting('server-listing.vote.commands', '[]'), true),
                        'placeholder' => 'ex: /give {player} stone 1',
                    ])
                    <div class="form-text">The {player} and {ip} variables are available.</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save
                </button>
            </form>
        </div>
    </div>
@endsection
