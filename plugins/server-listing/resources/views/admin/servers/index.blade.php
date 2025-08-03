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
                            <th scope="col">{{ trans('server-listing::messages.fields.logo') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.name') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.category') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.server_ip') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.featured') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($servers as $server)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><img src="{{ $server->logo_image_url }}" class="img-small rounded" height="40"
                                        width="40" alt="{{ $server->name }}"></td>
                                <td>{{ $server->name }}</td>
                                <td>{{ $server->category->name }}</td>
                                <td>{{ $server->server_ip }}</td>
                                <td>
                                    <span class="{{ $server->featured_bg }}">
                                        {{ $server->featured_label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('server-listing.admin.servers.edit', $server->slug) }}"
                                        class="mx-1" title="{{ trans('server-listing::messages.actions.edit') }}"
                                        data-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                    <a href="{{ route('server-listing.admin.servers.destroy', $server->slug) }}"
                                        class="mx-1 text-danger" data-confirm="delete"
                                        title="{{ trans('server-listing::messages.actions.delete') }}"
                                        data-toggle="tooltip"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <a class="btn btn-primary" href="{{ route('server-listing.admin.servers.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('server-listing::messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
