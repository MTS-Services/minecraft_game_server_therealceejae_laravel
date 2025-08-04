@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.category.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('server-listing.admin.categories.create') }}" method="POST" enctype="multipart/form-data">
                @include('server-listing::admin.categories._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('server-listing::messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
