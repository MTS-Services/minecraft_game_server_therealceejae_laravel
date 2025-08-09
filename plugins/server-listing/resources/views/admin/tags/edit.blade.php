@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.tag.edit', ['tag' => $tag->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.tags.edit', $tag->slug) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')

                @include('server-listing::admin.tags._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('server-listing::messages.actions.update') }}
                </button>
                <a href="{{ route('server-listing.admin.tags.destroy', $tag->slug) }}" class="btn btn-danger"
                    data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('server-listing::messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
