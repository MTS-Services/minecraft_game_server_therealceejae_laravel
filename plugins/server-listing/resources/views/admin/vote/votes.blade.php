@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.vote.title'))

@section('content')
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('server-listing::admin.vote.votes') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary"><i class="bi bi-calendar"></i></div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $votesCount }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('server-listing::admin.vote.monthly_votes') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary"><i class="bi bi-calendar-month"></i></div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $votesCountMonth }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('server-listing::admin.vote.weekly_votes') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary"><i class="bi bi-calendar-week"></i></div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $votesCountWeek }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('server-listing::admin.vote.daily_votes') }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary"><i class="bi bi-calendar-day"></i></div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $votesCountDay }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.user') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.site') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.reward') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($votes as $vote)
                            <tr>
                                <th scope="row">{{ $vote->id }}</th>
                                <td>
                                    <a href="{{ route('admin.users.edit', $vote->user) }}">{{ $vote->user->name }}</a>
                                </td>
                                <td>
                                    @if ($vote->site)
                                        <a
                                            href="{{ route('server-listing.admin.vote.sites.edit', $vote->site) }}">{{ $vote->site->name }}</a>
                                    @else
                                        #{{ $vote->site_id }}
                                    @endif
                                </td>
                                <td>
                                    @if ($vote->reward)
                                        <a
                                            href="{{ route('server-listing.admin.vote.rewards.edit', $vote->reward) }}">{{ $vote->reward->name }}</a>
                                    @else
                                        #{{ $vote->reward_id }}
                                    @endif
                                </td>
                                <td>{{ format_date_compact($vote->created_at) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $votes->withQueryString()->links() }}
        </div>
    </div>
@endsection
