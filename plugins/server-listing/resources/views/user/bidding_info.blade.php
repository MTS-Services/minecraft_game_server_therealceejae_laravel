@extends('layouts.base')
@section('title', trans('server-listing::messages.server_submission.title'))
@include('admin.elements.editor')
@section('app')
    @push('styles')
        <style>
            .breadcrumb-item a {
                color: #fd7e14;
                text-decoration: none;
            }

            .breadcrumb-item.active {
                color: #6c757d;
            }

            .page-title {
                color: #fd7e14;
                font-size: 2rem;
                font-weight: 400;
                margin-bottom: 1.5rem;
            }

            .bidding-table {
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                overflow: hidden;
            }

            .bidding-table th {
                background-color: #f8f9fa;
                font-weight: 600;
                border-bottom: 2px solid #dee2e6;
                width: 200px;
            }

            .bidding-table td {
                border-bottom: 1px solid #dee2e6;
            }

            .status-closed {
                background-color: #6c757d;
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-weight: 500;
                display: inline-block;
            }

            .table-success {
                background-color: #d4edda !important;
            }

            [data-bs-theme="dark"] .table-success {
                background-color: #3d3d3d !important;
            }

            [data-bs-theme="dark"] .bidding-table th {
                background-color: #6c757d;
                border-bottom: 2px solid #5f6468;
            }

            [data-bs-theme="dark"] .bidding-table td {
                border-bottom: 1px solid #6c757d;
            }
        </style>
    @endpush

    <div class="container mt-4">
        {{-- Modal start --}}
        <div class="modal fade" id="biddingModal" tabindex="-1" aria-labelledby="biddingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="biddingModalLabel">Place a Bid</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            @csrf
                            <!-- Bid Amount -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Bid Amount ($)</label>
                                <input type="number" name="amount" id="amount" step="0.01" class="form-control"
                                    required>
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Place Bid</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal end --}}

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Minecraft Servers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Premium Option</li>
            </ol>
        </nav>

        <!-- Page Title -->
        <h1 class="page-title">Premium Option</h1>

        <!-- Information Alert -->
        <div class="alert alert-info" role="alert">
            <p class="mb-2">
                Premium servers are displayed at the top on the first page of the site for a whole month.
                Premium servers will also appear at the top of search results, their country pages,
                tag pages and version pages (if they fit the criteria).
            </p>
            <p class="mb-0">
                If you want more information,
                <a href="#" data-bs-toggle="modal" data-bs-target="#faqModal">read our Premium FAQ</a>.
            </p>
        </div>

        <!-- Modal for FAQ -->
        <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="faqModalLabel">Premium FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Q: How long does a Premium listing last?</strong><br>
                            A: Each Premium placement lasts for 1 month.</p>
                        <p><strong>Q: Where will my server appear?</strong><br>
                            A: At the top of the main page, search results, and relevant categories.</p>
                        <p><strong>Q: Can I renew Premium?</strong><br>
                            A: Yes, you can rebid for another slot in the next auction.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bidding Information Section -->
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-4">Bidding information</h2>
                <div class="text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#biddingModal">
                        Bidding
                    </button>
                </div>
            </div>
            <div class="accordion" id="biddingAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            View Bidding Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#biddingAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table bidding-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Status:</th>
                                            <td><span class="status-closed">Closed</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Slots:</th>
                                            <td><strong>5</strong></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Current time:</th>
                                            <td>August 17th, 2025 11:02 PM EST</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Bidding start:</th>
                                            <td>August 7th, 2025 09:00 AM EST</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Bidding end:</th>
                                            <td>August 12th, 2025 03:00 PM EST</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Payment limit date:</th>
                                            <td>August 15th, 2025 03:00 PM EST</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Banner display start:</th>
                                            <td><strong>August 17th, 2025 03:00 PM EST</strong></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Banner display end:</th>
                                            <td><strong>September 17th, 2025 03:00 PM EST</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Bids Section -->
        <div class="my-5">
            <h4 class="mb-3">Current bids</h4>
            <p class="text-muted">Only the top 5 bidders will win the "Premium Option".</p>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Place</th>
                            <th scope="col">Server</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Paid</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-success">
                            <td>1</td>
                            <td>MineSuperior</td>
                            <td>$2205</td>
                            <td>Yes</td>
                            <td>August 12th, 2025 03:00 PM EST</td>
                        </tr>
                        <tr class="table-success">
                            <td>2</td>
                            <td>OPBlocks Network</td>
                            <td>$1800</td>
                            <td>Yes</td>
                            <td>August 12th, 2025 02:59 PM EST</td>
                        </tr>
                        <tr class="table-success">
                            <td>3</td>
                            <td>Daedric</td>
                            <td>$855</td>
                            <td>Yes</td>
                            <td>August 12th, 2025 02:59 PM EST</td>
                        </tr>
                        <tr class="table-success">
                            <td>4</td>
                            <td>Foxcraft</td>
                            <td>$765</td>
                            <td>Yes</td>
                            <td>August 12th, 2025 02:59 PM EST</td>
                        </tr>
                        <tr class="table-success">
                            <td>5</td>
                            <td>ManaCube</td>
                            <td>$755</td>
                            <td>Yes</td>
                            <td>August 12th, 2025 02:59 PM EST</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>The World Is Your Oyster SMP</td>
                            <td>$740</td>
                            <td>Yes</td>
                            <td>August 10th, 2025 01:59 PM EST</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>PrestigiousMC | pgmc.world</td>
                            <td>$625</td>
                            <td>Yes</td>
                            <td>August 11th, 2025 01:03 PM EST</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Advancius Network</td>
                            <td>$455</td>
                            <td>Yes</td>
                            <td>August 12th, 2025 02:59 PM EST</td>
                        </tr>
                        <!-- More rows if needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
