@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.vote.sites.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('messages.fields.name') }}</th>
                        <th scope="col">{{ trans('messages.fields.url') }}</th>
                        <th scope="col">{{ trans('messages.fields.enabled') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($sites as $site)
                        <tr>
                            <th scope="row">{{ $site->id }}</th>
                            <td>{{ $site->name }}</td>
                            <td>{{ $site->url }}</td>
                            <td>
                                <span class="badge bg-{{ $site->is_enabled ? 'success' : 'danger' }}">
                                    {{ trans_bool($site->is_enabled) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('server-listing.admin.vote.sites.edit', $site) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{ route('server-listing.admin.vote.sites.destroy', $site) }}" class="mx-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            <a class="btn btn-primary" href="{{ route('server-listing.admin.vote.sites.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
