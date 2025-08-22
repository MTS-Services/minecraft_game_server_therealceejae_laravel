@extends('layouts.base')
@section('title', trans('server-listing::messages.server_details.title'))
@section('app')


    <h1>Select Payment Method</h1>

    {{-- @dd($gateways, $bid) --}}

    <div class="row gy-3">
        @forelse($gateways as $gateway)
            <div class="col-md-3">
                <div class="card">
                    {{-- Change this to a form --}}
                    <form action="{{ route('server-listing.payments.pay', $gateway->type) }}" method="POST">
                        @csrf
                        {{-- Add a hidden input field for the bid ID --}}
                        <input type="hidden" name="bid_id" value="{{ encrypt($bid->id) }}">

                        <button type="submit" class="payment-method btn p-0 border-0 w-100 h-100 bg-white">
                            <div class="card-body text-center">
                                <img src="{{ $gateway->paymentMethod()->image() }}" style="max-height: 45px"
                                    class="img-fluid" alt="{{ $gateway->name }}">
                            </div>
                        </button>
                    </form>
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
