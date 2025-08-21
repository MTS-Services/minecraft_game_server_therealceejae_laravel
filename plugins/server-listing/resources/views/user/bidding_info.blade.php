@extends('layouts.base')
@section('title', trans('server-listing::messages.server_submission.title'))
@include('admin.elements.editor')
@section('app')
    @push('styles')
        <style>
            :root {
                --blue: #007bff;
                --indigo: #6610f2;
                --purple: #8b5cf6;
                --pink: #e83e8c;
                --red: #dc3545;
                --orange: #fd7e14;
                --yellow: #ffc107;
                --green: #28a745;
                --teal: #20c997;
                --cyan: #17a2b8;
                --white: #fff;
                --gray: #6c757d;
                --gray-dark: #343a40;
                --primary: #007bff;
                --secondary: #6c757d;
                --success: #28a745;
                --info: #17a2b8;
                --warning: #ffc107;
                --danger: #dc3545;
                --light: #f8f9fa;
                --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
                --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
                --glass-bg: rgba(255, 255, 255, 0.25);
                --glass-border: rgba(255, 255, 255, 0.18);
                /* --shadow-light: 0 8px 32px 0 rgba(31, 38, 135, 0.37); */
                --shadow-medium: 0 15px 35px rgba(0, 0, 0, 0.1);
                --shadow-heavy: 0 20px 40px rgba(0, 0, 0, 0.15);

                [data-bs-theme="dark"] {
                    --bg-primary: #212529;
                    --bg-secondary: rgba(255, 255, 255, 0.1);
                    --drak-text-primary: #ffffff;
                    --text-secondary: #adb5bd;
                    --border-light: #495057;
                    --shadow-light: 0 8px 32px 0 rgba(31, 38, 135, 0.37);

                }
            }

            * {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            [data-bs-theme="dark"] {
                .bidding-table {
                    background: var(--bg-secondary);
                }

                .stat-card,
                .bid-info-card {
                    background: var(--bg-secondary);
                }

                .stat-label {
                    color: var(--text-secondary);
                }

            }

            .breadcrumb-custom {
                background: var(--glass-bg);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid var(--glass-border);
                border-radius: 15px;
                padding: 0.75rem 1.25rem;
                margin-bottom: 2rem;
                box-shadow: var(--shadow-light);
            }

            .breadcrumb-custom a {
                color: var(--blue);
                text-decoration: none;
                font-weight: 500;
            }

            .breadcrumb-custom a:hover {
                color: var(--indigo);
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            }

            .page-title {
                color: #ff8c00;
                font-weight: bold;
                font-size: 2rem;
                margin-bottom: 1.5rem;
            }

            .info-card {
                background: linear-gradient(135deg, #17a2b8, #20c997);
                color: white;
                border-radius: 10px;
                padding: 1.5rem;
                margin-bottom: 2rem;
            }

            .bidding-info {
                background: var(--glass-bg);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid var(--glass-border);
                border-radius: 15px;
                margin-bottom: 2rem;
                box-shadow: var(--shadow-medium);
            }

            .section-header {
                background: var(--primary-gradient);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 15px 15px 0 0;
                font-weight: 600;
                font-size: 1.2rem;
                box-shadow: var(--shadow-light);
                position: relative;
                overflow: hidden;
            }

            .bidding-table {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-radius: 0 0 15px 15px;
                box-shadow: var(--shadow-medium);
                overflow: hidden;
            }

            .table-row {
                padding: 1.5rem 2rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: relative;
            }

            .table-row:hover {
                background: linear-gradient(90deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
                transform: translateX(5px);
            }

            .table-row:last-child {
                border-bottom: none;
            }

            .status-badge {
                padding: 0.5rem 1rem;
                border-radius: 25px;
                font-size: 0.875rem;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            .status-offline {
                background: var(--secondary-gradient);
                color: white;
            }

            .btn-bidding,
            .btn-pay {
                border: none;
                color: white;
                padding: 0.5rem 1.5rem;
                border-radius: 30px;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                position: relative;
                overflow: hidden;
            }

            .btn-bidding {
                background: var(--warning-gradient);
                box-shadow: 0 8px 25px rgba(67, 233, 123, 0.3);
            }

            .btn-pay {
                background: var(--success-gradient);
                box-shadow: 0 8px 25px rgba(226, 235, 103, 0.3);
            }

            .btn-bidding::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.5s;
            }

            .btn-bidding:hover {
                box-shadow: 0 12px 35px rgba(67, 233, 123, 0.4);
                color: white;
            }

            .btn-bidding:hover::before {
                left: 100%;
            }

            .premium-features {
                /* background: rgba(255, 255, 255, 0.95); */
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 20px;
                padding: 2.5rem;
                margin-bottom: 3rem;
                box-shadow: var(--shadow-medium);
                position: relative;
                overflow: hidden;
            }

            .premium-features::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: var(--success-gradient);
                border-radius: 20px 20px 0 0;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 3rem;
            }

            .stat-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                padding: 1.5rem;
                border-radius: 20px;
                text-align: center;
                box-shadow: var(--shadow-light);
                border: 1px solid rgba(255, 255, 255, 0.3);
                position: relative;
                overflow: hidden;
            }

            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: var(--primary-gradient);
            }

            .stat-card:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: var(--shadow-heavy);
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                background: var(--primary-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 0.5rem;
            }

            .stat-label {
                color: #6c757d;
                font-size: 1rem;
                font-weight: 500;
            }

            .bid-info-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                padding: 1.5rem;
            }

            .bid-info-card {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                padding: 1rem;
                border-radius: 20px;
                text-align: center;
                box-shadow: var(--shadow-light);
                border: 1px solid rgba(255, 255, 255, 0.3);
                position: relative;
                overflow: hidden;
            }

            .bid-info-grid .bid-info-number {}

            .feature-item {
                display: flex;
                align-items: center;
                background: rgba(102, 126, 234, 0.05);
                margin-bottom: 1rem;
                padding: 0.75rem;
                border-radius: 10px;
                transition: all 0.3s ease;
            }

            .feature-item:hover {
                background: rgba(102, 126, 234, 0.10);
                transform: translateX(10px);
            }

            .feature-item i {
                margin-right: 1rem;
                font-size: 1.2rem;
                width: 24px;
                text-align: center;
            }

            .badge {
                font-weight: 500;
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-size: 0.875rem;
            }

            .server-header {
                background: var(--glass-bg);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid var(--glass-border);
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 2rem;
            }

            .server-logo {
                box-shadow: var(--shadow-medium);
            }

            .server-logo img {
                width: 60px;
                height: 60px object-fit: cover;
            }

            .server-logo:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .server-stats-card {
                background: rgba(255, 255, 255, 0.856);
                backdrop-filter: blur(5px);
                -webkit-backdrop-filter: blur(5px);
                border-radius: 15px;
                padding: 1.5rem;
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.3);
                transition: all 0.3s ease;
            }

            .server-stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .btn-outline-secondary {
                border: 2px solid rgba(255, 255, 255, 0.3);
                color: white;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 0.75rem 2rem;
                font-weight: 600;
            }

            .btn-outline-secondary:hover {
                background: rgba(255, 255, 255, 0.2);
                border-color: rgba(255, 255, 255, 0.5);
                color: white;
                transform: translateY(-2px);
            }

            @media (max-width: 768px) {
                .page-title {
                    font-size: 2rem;
                }

                .stats-grid {
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 1rem;
                }

                .info-card,
                .premium-features {
                    padding: 1.5rem;
                }
            }

            #biddingModal .modal-header {
                background: linear-gradient(135deg, #17a2b8, #20c997);
                color: white;
                border: none ! important;
            }

            #biddingModal .place-bid-btn {
                background: linear-gradient(135deg, #20c997, #17a2b8);
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 5px;
                transition: all 0.3s ease;
            }

            #biddingModal .place-bid-btn:hover {
                background: linear-gradient(135deg, #17a2b8, #20c997);
            }

            #biddingModal .form-control {
                outline: none ! important;
            }

            #biddingModal .form-control:focus {
                border-color: var(--purple);
            }
        </style>
    @endpush

    <div class="container mt-4">
        @if (biddingIsOpen())
            <div class="modal fade" id="biddingModal" tabindex="-1" aria-labelledby="biddingModalLabel" aria-hidden="true"
                data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="biddingModalLabel">Place a Bid</h1>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('server-listing.bids.place-bid', $serverList->slug) }}" method="POST">
                                @csrf
                                <!-- Bid Amount -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Bid Amount ($)</label>
                                    <input type="number" name="amount" id="amount" step="0.01" class="form-control"
                                        required>
                                </div>
                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="place-bid-btn">Place Bid</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Breadcrumb -->
        <nav class="breadcrumb-custom">
            <a href="#" class="text-decoration-none">Minecraft Servers</a>
            <span class="mx-2">/</span>
            <span class="">Premium Option</span>
        </nav>

        <!-- Page Title -->
        <h1 class="page-title">
            <i class="fas fa-crown me-3"></i>Premium Option
        </h1>

        <!-- Premium Info Card -->
        <div class="info-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-3"><i class="fas fa-star me-2"></i>Premium Server Benefits</h4>
                    <p class="mb-2">Premium servers are displayed at the top on the first page of the site for a whole
                        month. Premium servers will also appear at the top of search results, their country pages, tag pages
                        and version pages (if they fit the criteria).</p>
                    <p class="mb-0">If you want more information, <a href="#" class="text-white"><u>read our
                                Premium
                                FAQ</u></a>.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-trophy" style="font-size: 5rem; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
        <div class="bidding-info">
            <!-- Bidding Information -->
            <div class="section-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-gavel me-2"></i>Bidding Information</span>
                <div class="d-flex align-items-center gap-2">
                    @if (biddingIsOpen())
                        <button type="button" class="btn-bidding float-end z-1" data-bs-toggle="modal"
                            data-bs-target="#biddingModal">
                            <i class="bi bi-cash-stack me-1"></i>Start Bidding
                        </button>
                    @else
                        <button type="button" class="btn-bidding float-end" style="cursor: not-allowed" disabled>
                            <i class="bi bi-cash-stack me-1"></i>Bidding Closed
                        </button>
                    @endif

                    @if (isset($bid))
                        <form action="{{ route('server-listing.payments.payment', encrypt($bid->id)) }}" method="POST"
                            class="float-end">
                            @csrf
                            <button type="submit" class="btn-pay">
                                <i class="fas fa-credit-card me-1"></i>Pay Now
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="bid-info-grid">
                <div class="bid-info-card">
                    <div class="bid-info-number"><i class="fas fa-dollar-sign"></i><span
                            class="fw-bold">{{ now()->endOfMonth()->day }}</span></div>
                    <div class="bid-info-label">Minimum Bid</div>
                </div>
                <div class="bid-info-card">
                    <div class="bid-info-number"><i class="fas fa-play me-2 text-success"></i>
                        {{ now()->format('M d, Y') }}
                    </div>
                    <div class="bid-info-label">Bidding Start Date</div>
                </div>
                <div class="bid-info-card">
                    <div class="bid-info-number"><i class="fas fa-stop me-2 text-danger"></i>
                        {{ now()->format('M d, Y') }}
                    </div>
                    <div class="bid-info-label">Bidding End Date</div>
                </div>
                <div class="bid-info-card">
                    <div class="bid-info-number"><i class="fas fa-play me-2 text-success"></i>
                        {{ now()->format('M d, Y') }}
                    </div>
                    <div class="bid-info-label">Payment Start Date</div>
                </div>
                <div class="bid-info-card">
                    <div class="bid-info-number"><i class="fas fa-stop me-2 text-danger"></i>
                        {{ now()->format('M d, Y') }}
                    </div>
                    <div class="bid-info-label">Payment End Date</div>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">10</div>
                <div class="stat-label">Available Slots</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">30</div>
                <div class="stat-label">Days Duration</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Visibility Boost</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Premium Support</div>
            </div>
        </div>

        <!-- Premium Features -->
        <div class="premium-features">
            <h5 class="mb-4"><i class="fas fa-server me-2"></i>Server Information:</h5>

            <!-- Server Header -->
            <div class="server-header mb-4">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="server-logo">
                            <img src="{{ $serverList->logo_image_url }}" alt="">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 text-warning fw-bold">{{ $serverList->name }}</h6>
                        <small class="text-muted">{{ $serverList->server_ip }}</small>
                    </div>
                    <div>
                        <span class="badge bg-{{ $serverList->is_online ? 'success' : 'danger' }}"
                            style="padding: 0.5rem 1rem; border-radius: 20px;">
                            <i
                                class=" me-1 {{ $serverList->is_online ? 'pulse bi bi-circle-fill' : '' }}"></i>{{ __($serverList->online_label) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Server Stats Grid -->
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="server-stats-card">
                        <i class="fas fa-users text-primary mb-2" style="font-size: 2rem;"></i>
                        <div class="fw-bold text-primary" style="font-size: 1.5rem;">206/862</div>
                        <small class="text-muted">Players Online</small>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="server-stats-card">
                        <i class="fas fa-chart-line text-success mb-2" style="font-size: 2rem;"></i>
                        <div class="fw-bold text-success" style="font-size: 1.5rem;">100%</div>
                        <small class="text-muted">Uptime</small>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="server-stats-card">
                        <i class="fas fa-trophy text-warning mb-2" style="font-size: 2rem;"></i>
                        <div class="fw-bold text-warning" style="font-size: 1.5rem;">#1</div>
                        <small class="text-muted">Server Rank</small>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="server-stats-card">
                        <i class="fas fa-thumbs-up text-info mb-2" style="font-size: 2rem;"></i>
                        <div class="fw-bold text-info" style="font-size: 1.5rem;">6,828</div>
                        <small class="text-muted">Total Votes</small>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
