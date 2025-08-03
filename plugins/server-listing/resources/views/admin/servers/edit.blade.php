@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.server.edit', ['server' => $server->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.servers.edit', $server->slug) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')

                @include('server-listing::admin.servers._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('server-listing::messages.actions.update') }}
                </button>
                <a href="{{ route('server-listing.admin.servers.destroy', $server->slug) }}" class="btn btn-danger"
                    data-confirm="delete"
                    onclick="event.preventDefault(); document.getElementById('deleteForm').submit(); ">
                    <i class="bi bi-trash"></i> {{ trans('server-listing::messages.actions.delete') }}
                </a>
                <form id="deleteForm" action="{{ route('server-listing.admin.servers.destroy', $server->slug) }}"
                    method="POST">
                    @method('DELETE')
                </form>
            </form>
        </div>
    </div>
@endsection
