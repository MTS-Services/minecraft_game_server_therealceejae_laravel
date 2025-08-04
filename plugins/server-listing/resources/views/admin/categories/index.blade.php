@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.category.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.name') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.slug') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.status') }}</th>
                            <th scope="col">{{ trans('server-listing::messages.fields.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td><span class="{{ $category->status_bg }}"> {{ $category->status_label }} </span></td>
                                <td>
                                    <a href="{{ route('server-listing.admin.categories.edit', $category->slug) }}"
                                        class="mx-1" title="{{ trans('server-listing::messages.actions.edit') }}"
                                        data-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                    <a href="{{ route('server-listing.admin.categories.destroy', $category->slug) }}"
                                        class="mx-1 text-danger" data-confirm="delete"
                                        title="{{ trans('server-listing::messages.actions.delete') }}"
                                        data-toggle="tooltip"><i class="bi bi-trash"></i></a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <a class="btn btn-primary" href="{{ route('server-listing.admin.categories.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('server-listing::messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
