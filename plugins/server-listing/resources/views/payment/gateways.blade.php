@extends('layouts.base')
@section('title', trans('server-listing::messages.server_details.title'))
@section('app')

    @push('footer-scripts')
        <script>
            document.querySelectorAll('.payment-method').forEach(function(el) {
                el.addEventListener('click', function(ev) {
                    ev.preventDefault();

                    const form = document.getElementById('submitForm');
                    form.action = el.href;
                    form.submit();
                });
            });
        </script>
    @endpush

    <h1>Select Payment Method</h1>

    <div class="row gy-3">
        @forelse($gateways as $gateway)
            <div class="col-md-3">
                <div class="card">
                    <a href="{{ isset($route) ? $route($gateway->type) : route('shop.payments.pay', $gateway->type) }}"
                        class="payment-method">
                        <div class="card-body text-center">
                            <img src="{{ $gateway->paymentMethod()->image() }}" style="max-height: 45px" class="img-fluid"
                                alt="{{ $gateway->name }}">
                        </div>
                    </a>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-circle"></i> No payment methods available
                </div>
            </div>
        @endforelse
    </div>

    <form method="POST" id="submitForm">
        @csrf
    </form>

@endsection
