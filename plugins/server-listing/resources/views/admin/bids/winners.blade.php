@extends('admin.layouts.admin')

@section('title', trans('server-listing::messages.winners.title'))

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
            axios.post('{{ route('server-listing.admin.bids.update-order') }}', {
                'order': serialize(sortable),
                'page': '{{ $bids->currentPage() }}',
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
        })
    </script>
@endpush

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header">
            <form action="{{ route('server-listing.admin.bids.winners') }}" method="GET">
                <div class="input-group">
                    <select name="month" class="form-select">
                        @for ($month = 1; $month <= 12; $month++)
                            <option value="{{ $month }}"
                                {{ request('month') == $month ? 'selected' : (!request('month') && $month == now()->month ? 'selected' : '') }}>
                                {{ date('F', mktime(0, 0, 0, $month)) }}</option>
                        @endfor
                    </select>
                    <select name="year" class="form-select">
                        @for ($year = 2025; $year <= now()->year; $year++)
                            <option value="{{ $year }}"
                                {{ request('year') == $year ? 'selected' : (!request('year') && $year == now()->year ? 'selected' : '') }}>
                                {{ $year }}</option>
                        @endfor
                    </select>
                    <select name="payment" class="form-select">
                        <option value="all" {{ request('payment') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ request('payment') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
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
                                {{ trans('server-listing::messages.fields.amount') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.status') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.fields.bid_at') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.winners.gateway') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.winners.payment_id') }}
                            </span>
                            <span class="col">
                                {{ trans('server-listing::messages.winners.payment_at') }}
                            </span>
                        </div>
                    </div>
                </li>
                @forelse ($bids as $bid)
                    <li class="sortable-item  sortable-parent" data-id="{{ $bid->id }}">
                        <div class="card">
                            <div class="card-body row ">
                                <span class="col">
                                    <i class="bi bi-arrows-move sortable-handle"></i>
                                    <a href="{{ route('admin.users.edit', $bid?->user?->id) }}">
                                        {{ $bid->user?->name }}
                                    </a>
                                </span>
                                <span class="col">
                                    <a href="{{ route('server-listing.details', $bid?->serverListing?->slug) }}">
                                        {{ $bid->serverListing?->name }}
                                    </a>
                                </span>
                                <span class="col">
                                    ${{ $bid->amount }}
                                </span>
                                <span class="col">
                                    {{ $bid->status }}
                                </span>
                                <span class="col">
                                    {{ $bid->bidding_at->format('Y-m-d H:i:s') }}
                                </span>
                                <span class="col">
                                    {{ $bid->payments->last()?->gateway_type ?? trans('server-listing::messages.winners.not_yet') }}
                                </span>
                                <span class="col">
                                    {{ $bid->payments->last()?->transaction_id ?? trans('server-listing::messages.winners.not_yet') }}
                                </span>
                                <span class="col">
                                    {{ $bid->payments->last()?->created_at->format('Y-m-d H:i:s') ?? trans('server-listing::messages.winners.not_yet') }}
                                </span>
                            </div>
                        </div>
                    </li>
                @empty
                    <div class="col">
                        <div class="alert alert-info text-center" role="alert">
                            <i class="bi bi-info-circle"></i> {{ trans('server-listing::messages.winners.empty') }}
                        </div>
                    </div>
                @endforelse
            </ol>
            {{ $bids->links() }}
            {{-- <a class="btn btn-primary" href="{{ route('server-listing.admin.tags.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a> --}}
        </div>

    </div>
@endsection
