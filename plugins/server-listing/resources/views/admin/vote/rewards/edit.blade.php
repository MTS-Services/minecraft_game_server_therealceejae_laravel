@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.vote.rewards.edit', ['reward' => $reward->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.vote.rewards.update', $reward) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')

                @include('server-listing::admin.vote.rewards._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <a href="{{ route('server-listing.admin.vote.rewards.destroy', $reward) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
