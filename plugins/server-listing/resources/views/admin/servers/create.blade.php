@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.server.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.servers.create') }}" method="POST" enctype="multipart/form-data">
                @include('server-listing::admin.servers._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('server-listing::messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
