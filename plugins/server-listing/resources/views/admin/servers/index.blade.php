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
    <div class="card shadow mb-4">
        <div class="card-body">
            <a class="btn btn-primary" href="{{ route('server-listing.admin.servers.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
            <ol class="list-unstyled sortable sortable-list mb-2" id="sortable">
                <li class="default-item">
                    <div class="card">
                        <div class="card-body row ">
                            <span class="col">
                                {{ trans('server-listing::messages.fields.name') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.server') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.country') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.server_address') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.featured') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.server_status') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.premium_status') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.status') }}
                            </span>
                            <span class="col-1">
                                {{ trans('server-listing::messages.fields.actions') }}
                            </span>
                        </div>
                    </div>
                </li>
                @foreach ($servers as $server)
                    <li class="sortable-item  sortable-parent" data-id="{{ $server->id }}">
                        <div class="card">
                            <div class="card-body row ">
                                <span class="col">
                                    <i class="bi bi-arrows-move sortable-handle"></i>
                                    {{ $server->user->name }}
                                </span>
                                <span class="col">
                                    {{ $server->name }}
                                </span>
                                <span class="col">
                                    {{ $server->country?->name }}
                                </span>
                                <span class="col">
                                    {{ $server->full_address }}
                                </span>
                                <span class="col">
                                    <span class="{{ $server->featured_bg }}">
                                        {{ $server->featured_label }}
                                    </span>
                                </span>
                                <span class="col">
                                    <span class="{{ $server->online_bg }}">
                                        {{ $server->online_label }}
                                    </span>
                                </span>
                                <span class="col">
                                    <span class="{{ $server->premium_bg }}">
                                        {{ $server->premium_label }}
                                    </span>
                                </span>
                                <span class="col">
                                    <span class="{{ $server->approved_bg }}">
                                        {{ $server->approved_label }}
                                    </span>
                                </span>
                                <span class="col-1">
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
