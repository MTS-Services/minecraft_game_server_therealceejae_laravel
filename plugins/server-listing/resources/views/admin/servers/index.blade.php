@extends('admin.layouts.admin')

@section('title', trans('server-listing::admin.server.title'))

@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
        const sortable = document.getElementById('sortable');

        function serialize(sortable) {
            return [].slice.call(sortable.children).map(function(child) {
                const nested = child.querySelector('.sortable');
                return {
                    id: parseInt(child.dataset['id']),
                    children: nested ? serialize(nested) : [],
                };
            });
        }

        function updateOrder() {
            axios.post('{{ route('server-listing.admin.servers.update-order') }}', {
                'order': serialize(sortable),
                'page': '{{ $servers->currentPage() }}',
                'per_page': '{{ $per_page }}',
            }).then(function(json) {
                createAlert('success', json.data.message, true);
            }).catch(function(error) {
                createAlert('danger', error.response.data.message || 'Something went wrong.', true);
            });
        }

        document.querySelectorAll('.sortable-list').forEach(function(el) {
            Sortable.create(el, {
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onEnd: function() {
                    updateOrder(); // call axios automatically after reorder
                }
            });
        });
    </script>
@endpush

@section('content')

    <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('server-listing.admin.servers.index') }}"
        method="GET">
        <div class="mb-3">
            <label for="searchInput" class="visually-hidden">
                {{ trans('messages.actions.search') }}
            </label>

            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}"
                    placeholder="{{ trans('messages.actions.search') }}">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-body">
            <a class="btn btn-primary" href="{{ route('server-listing.admin.servers.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
            <ol class="list-unstyled sortable sortable-list mb-2" id="sortable">
                <li class="default-item">
                    <div class="card">
                        <div class="card-body row ">
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.name') }}
                            </span>
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.server') }}
                            </span>
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.country') }}
                            </span>
                            <span class="col-6 col-md-2">
                                {{ trans('server-listing::messages.fields.server_ip') }}
                            </span>
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.votes') }}
                            </span>
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.favorites') }}
                            </span>
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.server_status') }}
                            </span>
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.premium_status') }}
                            </span>
                            <span class="col-6 col-md">
                                {{ trans('server-listing::messages.fields.status') }}
                            </span>
                            <span class="col-6 col-md-1">
                                {{ trans('server-listing::messages.fields.actions') }}
                            </span>
                        </div>
                    </div>
                </li>
                @foreach ($servers as $server)
                    <li class="sortable-item  sortable-parent" data-id="{{ $server->id }}">
                        <div class="card">
                            <div class="card-body row ">
                                <span class="col-6 col-md">
                                    <i class="bi bi-arrows-move sortable-handle"></i>
                                    <a href="{{ route('admin.users.edit', $server?->user?->id) }}">
                                        {{ $server->user->name }}
                                    </a>
                                </span>
                                <span class="col-6 col-md">
                                    <a href="{{ route('server-listing.details', $server->slug) }}">
                                        {{ $server->name }}
                                    </a>
                                </span>
                                <span class="col-6 col-md">
                                    {{ $server->country?->name }}
                                </span>
                                <span class="col-6 col-md-2">
                                    {{ $server->server_ip }}

                                </span>
                                <span class="col-6 col-md">
                                    {{ $server->votes?->count() ?? 0 }}
                                </span>
                                <span class="col-6 col-md">
                                    {{ $server->favorites->count() }}
                                </span>
                                <span class="col-6 col-md">
                                    <span class="{{ $server->online_bg }}">
                                        {{ $server->online_label }}
                                    </span>
                                </span>
                                <span class="col-6 col-md">
                                    <span class="{{ $server->premium_bg }}">
                                        {{ $server->premium_label }}
                                    </span>
                                </span>
                                <span class="col-6 col-md">
                                    <span class="{{ $server->approved_bg }}">
                                        {{ $server->approved_label }}
                                    </span>
                                </span>
                                <span class="col-6 col-md-1">
                                    <a href="{{ route('server-listing.admin.servers.edit', $server->slug) }}"
                                        class="m-1" title="{{ trans('server_listing::messages.actions.edit') }}"
                                        data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                    <a href="{{ route('server-listing.admin.servers.destroy', $server->slug) }}"
                                        class="m-1" title="{{ trans('server_listing::messages.actions.delete') }}"
                                        data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
            {{ $servers->links() }}
            {{-- <a class="btn btn-primary" href="{{ route('server-listing.admin.servers.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a> --}}
        </div>

    </div>
@endsection
