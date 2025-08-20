@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.vote.sites.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.vote.sites.store') }}" method="POST">
                @include('server-listing::admin.vote.sites._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>

    @include('server-listing::admin.vote.sites._list')
@endsection
