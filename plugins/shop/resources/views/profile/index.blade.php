@extends('layouts.app')

@section('title', trans('shop::messages.profile.payments'))

@section('content')
    {{--
        Note: The style block should ideally be in a shared CSS file.
        Keeping it here for a self-contained example as requested.
    --}}
    <style>
        :root {
            /* Primary Colors */
            --primary-green: #4CAF50;
            --primary-blue: #2196F3;
            --primary-purple: #9C27B0;
            --primary-gold: #FFD700;
            --primary-orange: #FF9800;

            /* Status Colors */
            --status-online: #28A745;
            --status-offline: #DC3545;
            --status-warning: #FFC107;

            /* Background Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-dark: #343a40;
            --bg-darker: #212529;

            /* Border Colors */
            --border-light: #dee2e6;
            --border-primary: #e1bee7;
            --border-dark: #495057;

            /* Text Colors */
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #999;
            --text-white: #ffffff;

            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: .5rem;
            --spacing-lg: .5rem;
            --spacing-xl: 2rem;

            /* Border Radius */
            --border-radius-sm: 0.375rem;
            --border-radius-md: 0.5rem;
            --border-radius-lg: 0.75rem;
            --border-radius-xl: 1rem;

            /* Shadows */
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --shadow-lg: 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        /* Dark mode variables */
        [data-bs-theme="dark"] {
            --bg-primary: #212529;
            --bg-secondary: #343a40;
            --text-primary: #ffffff;
            --text-secondary: #adb5bd;
            --border-light: #495057;
        }

        /* Card Styling for Payments */


        .payments-header {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
            text-align: center;
            border-bottom: 2px solid var(--border-primary);
            margin-bottom: 20px;
        }


        .payments-header h2 {
            background: linear-gradient(45deg, var(--primary-gold), var(--primary-orange), var(--primary-gold));
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textShine 3s ease-in-out infinite;
        }

        @keyframes textShine {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        [data-bs-theme="dark"] .payments-header {
            background: linear-gradient(135deg, var(--bg-secondary), var(--bg-dark));
        }

        .payments-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(45deg, var(--primary-purple), #673ab7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .payments-table thead {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            padding: 1.5rem !important;
            border-bottom: 3px solid var(--primary-gold);
            border-radius: 10px 10px 0 0 !important;
        }

        /* Table Styling */
        .payments-table thead th {
            border: none;
            background: transparent;
            color: var(--text-white);
        }

        .payments-table tbody tr {
            transition: all 0.3s ease;
            position: relative;
            border-bottom: 1px solid var(--border-light);
        }

        .payments-table tbody tr:hover {
            background-color: var(--bg-secondary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }


        .payments-table tbody tr:last-child {
            border-bottom: none;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 15px;
            font-weight: 600;
        }

        .status-badge.bg-success {
            background-color: var(--status-online) !important;
        }

        .status-badge.bg-danger {
            background-color: var(--status-offline) !important;
        }

        .status-badge.bg-warning {
            background-color: var(--status-warning) !important;
        }

        /* Subscriptions Card */
        .subscriptions-card {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 3px solid transparent;
            background: linear-gradient(white, white) padding-box,
                linear-gradient(45deg, var(--primary-gold), var(--primary-orange)) border-box;
        }

        [data-bs-theme="dark"] .subscriptions-card {
            background: linear-gradient(var(--bg-primary), var(--bg-primary)) padding-box,
                linear-gradient(45deg, var(--primary-gold), var(--primary-orange)) border-box;
        }

        .subscriptions-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            padding: 2rem;
            border-bottom: 3px solid var(--primary-gold);
            text-align: center;
        }

        .subscriptions-title {
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(45deg, var(--primary-gold), var(--primary-orange), var(--primary-gold));
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textShine 3s ease-in-out infinite;
        }

        /* New premium table classes */

        [data-bs-theme="dark"] .payments-card {
            background: linear-gradient(var(--bg-primary), var(--bg-primary)) padding-box,
                linear-gradient(45deg, var(--primary-gold), var(--primary-orange)) border-box;
        }


        .card-header-title {
            background: linear-gradient(135deg, #f3e5f5, #e3f2fd);
            padding: 1.5rem;
            border: 2px solid var(--border-primary) !important;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
        }

        .payments-card-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            padding: 1.5rem;
            border-bottom: 3px solid var(--primary-gold);
            border-radius: 25px 25px 0 0;
        }

        .payments-card-row {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--border-light);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            background: linear-gradient(white, white) padding-box,
                linear-gradient(45deg, var(--primary-gold), var(--primary-orange)) border-box;
        }

        .payments-card-row:hover {
            transform: translateY(-5px);
            background-color: var(--bg-secondary);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.2);
        }

        [data-bs-theme="dark"] .payments-card-row:hover {
            background-color: var(--bg-dark);
        }

        .payments-card-row:last-child {
            border-bottom: none;
        }

        .col-text-white {
            color: var(--text-white)
        }
    </style>

    {{-- <h1 class="text-center">{{ trans('shop::messages.profile.payments') }}</h1> --}}

    {{-- Payments Card - Updated to use premium design --}}
    <div class="payments-card">

        <div class="card-header-title text-center">
            <h2 class="subscriptions-title">{{ trans('shop::messages.profile.payments') }}</h2>
        </div>

        @if (!$payments->isEmpty())
            <div class="payments-card-body">
                {{-- Refactored Payments "Table" --}}
                <div
                    class="d-flex flex-wrap text-white text-uppercase fw-bold text-center p-3 payments-card-header text-center">
                    <div class="col-1 col-md-1">#</div>
                    <div class="col-2 col-md-2">{{ trans('shop::messages.fields.price') }}</div>
                    <div class="col-2 col-md-2">{{ trans('messages.fields.type') }}</div>
                    <div class="col-2 col-md-2">{{ trans('messages.fields.status') }}</div>
                    <div class="col-2 col-md-2">{{ trans('shop::messages.fields.payment_id') }}</div>
                    <div class="col-3 col-md-3">{{ trans('messages.fields.date') }}</div>
                </div>
                @foreach ($payments as $payment)
                    <div class="payments-card-row d-flex flex-wrap text-center">
                        <div class="col-1 col-md-1 fw-bold">{{ $loop->iteration }}</div>
                        <div class="col-2 col-md-2">{{ $payment->formatPrice() }}</div>
                        <div class="col-2 col-md-2">{{ $payment->getTypeName() }}</div>
                        <div class="col-2 col-md-2">
                            <span class="badge status-badge bg-{{ $payment->statusColor() }}">
                                {{ trans('shop::admin.payments.status.' . $payment->status) }}
                            </span>
                        </div>
                        <div class="col-2 col-md-2">{{ $payment->transaction_id ?? trans('messages.unknown') }}
                        </div>
                        <div class="col-3 col-md-3">{{ format_date($payment->created_at, true) }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-4 text-center text-muted">
                <p class="text-muted m-0">Payments not found</p>
            </div>

        @endif


    </div>

    @if (!$subscriptions->isEmpty())
        {{-- Subscriptions Card - Updated to use premium design --}}
        <div class="payments-card mt-5">
            <div class="card-header-title text-center">
                <h2 class="subscriptions-title">{{ trans('shop::messages.profile.subscriptions') }}</h2>
            </div>

            <div class="payments-card-body">
                {{-- Refactored Subscriptions "Table" --}}
                <div class="payments-card-header d-flex flex-wrap text-white text-uppercase fw-bold text-center p-3">
                    <div class="col-1 col-md-1">#</div>
                    <div class="col-1 col-md-1">{{ trans('shop::messages.fields.price') }}</div>
                    @if (!use_site_money())
                        <div class="col-1 col-md-1">{{ trans('messages.fields.type') }}</div>
                    @endif
                    <div class="col-2 col-md-2">{{ trans('shop::messages.fields.package') }}</div>
                    <div class="col-1 col-md-1">{{ trans('messages.fields.status') }}</div>
                    <div class="col-2 col-md-2">{{ trans('shop::messages.fields.subscription_id') }}</div>
                    <div class="col-1 col-md-1">{{ trans('messages.fields.date') }}</div>
                    <div class="col-2 col-md-2">{{ trans('shop::messages.fields.renewal_date') }}</div>
                    <div class="col-1 col-md-1">{{ trans('messages.fields.action') }}</div>
                </div>
                @foreach ($subscriptions as $subscription)
                    <div class="payments-card-row d-flex flex-wrap text-center">
                        <div class="col-1 col-md-1 fw-bold">{{ $loop->iteration }}</div>
                        <div class="col-1 col-md-1">{{ $subscription->formatPrice() }}</div>
                        @if (!use_site_money())
                            <div class="col-1 col-md-1">{{ $subscription->getTypeName() }}</div>
                        @endif
                        <div class="col-2 col-md-2">
                            {{ $subscription->package?->name ?? trans('messages.unknown') }}</div>
                        <div class="col-1 col-md-1">
                            <span class="badge status-badge bg-{{ $subscription->statusColor() }}">
                                {{ trans('shop::admin.subscriptions.status.' . $subscription->status) }}
                            </span>
                        </div>
                        <div class="col-2 col-md-2">
                            {{ $subscription->subscription_id ?? trans('messages.unknown') }}</div>
                        <div class="col-1 col-md-1">{{ format_date($subscription->created_at) }}</div>
                        <div class="col-2 col-md-2">{{ format_date($subscription->ends_at) }}</div>
                        <div class="col-1 col-md-1">
                            @if ($subscription->isActive() && !$subscription->isCanceled())
                                <form action="{{ route('shop.subscriptions.destroy', $subscription) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> {{ trans('messages.actions.cancel') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
