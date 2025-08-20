@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.vote.rewards.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.vote.rewards.store') }}" method="POST" enctype="multipart/form-data">
                @include('server-listing::admin.vote.rewards._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
