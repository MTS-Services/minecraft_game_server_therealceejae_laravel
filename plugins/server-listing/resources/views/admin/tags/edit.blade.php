@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.category.edit', ['category' => $category->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.categories.edit', $category->slug) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')

                @include('server-listing::admin.categories._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('server-listing::messages.actions.update') }}
                </button>
                <a href="{{ route('server-listing.admin.categories.destroy', $category->slug) }}" class="btn btn-danger"
                    data-confirm="delete">
                    <i class="bi bi-trash"></i> {{ trans('server-listing::messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
