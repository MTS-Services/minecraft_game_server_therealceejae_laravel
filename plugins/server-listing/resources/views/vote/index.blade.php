@extends('layouts.app')

@section('title', 'Vote for ' . ($server_->name ?? ''))

@section('content')
    <h1>Vote for {{ $server_->name ?? '' }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('server-listing.vote.submit', $server_->slug) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Your Minecraft Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="{{ auth()->user()->name ?? old('username') }}" required
                        @if (auth()->check()) readonly @endif>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                    <label class="form-check-label" for="agree">I agree to the <a href="#">Privacy
                            Policy</a>.</label>
                </div>

                <button type="submit" class="btn btn-primary">Vote</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title">
                Top Voters
            </h2>

            <table class="table mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Votes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($votes as $vote)
                        <tr>
                            <th scope="row">#{{ $loop->iteration }}</th>
                            <td>{{ $vote->user?->name }}</td>
                            <td>{{ $vote->votes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No votes yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @auth
                @if (isset($user->votes_count))
                    <p class="mt-3 mb-0">Your votes: {{ $user->votes_count }}</p>
                @endif
            @endauth
        </div>
    </div>

    @if (setting('server-listing.vote.display-rewards') && $rewards->isNotEmpty())
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">
                    Rewards
                </h2>

                <table class="table mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Chances</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rewards as $reward)
                            <tr>
                                <th scope="row">
                                    {{ $reward->name ?? 'No Name' }}
                                </th>
                                <td>{{ $reward->chances }} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @if ($ipv6)
        <script src="https://ipv6-adapter.com/api/v1/api.js" async defer></script>
    @endif

    <script>
        const VOTE_API_URL = '';
    </script>
    <script src="{{ plugin_asset('server-listing', 'js/vote.js') }}" defer></script>
    @auth
        <script>
            window.username = '{{ Auth::user()->name ?? '' }}';
        </script>
    @endauth
@endpush

@push('styles')
    <style>
        #vote-card .btn:not(:last-child) {
            margin-right: 0.5rem;
        }

        #vote-card .spinner-parent {
            display: none;
        }

        #vote-card.voting .spinner-parent {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(70, 70, 70, 0.6);
            z-index: 10;
        }
    </style>
@endpush
