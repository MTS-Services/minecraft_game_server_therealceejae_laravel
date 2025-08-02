@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.server.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('messages.fields.logo') }}</th>
                            <th scope="col">{{ trans('messages.fields.name') }}</th>
                            <th scope="col">{{ trans('messages.fields.category') }}</th>
                            <th scope="col">{{ trans('messages.fields.server_ip') }}</th>
                            <th scope="col">{{ trans('messages.fields.featured') }}</th>
                            <th scope="col">{{ trans('messages.fields.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($servers as $server)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><img src="{{ $server->logoUrl() }}" class="img-small rounded" height="40"
                                        width="40" alt="{{ $server->name }}"></td>
                                <td>{{ $server->name }}</td>
                                <td>{{ $server->category->name }}</td>
                                <td>{{ $server->server_ip }}</td>
                                <td>
                                    <span class="badge bg-{{ $reward->is_featured ? 'success' : 'danger' }}">
                                        {{ trans_bool($reward->is_featured) }}
                                    </span>
                                </td>
                                <td>
                                    {{-- <a href="{{ route('vote.admin.rewards.edit', $reward) }}" class="mx-1"
                                        title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                            class="bi bi-pencil-square"></i></a> --}}

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <a class="btn btn-primary" href="">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
