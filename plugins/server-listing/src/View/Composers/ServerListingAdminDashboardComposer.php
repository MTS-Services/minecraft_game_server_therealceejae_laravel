<?php

namespace Azuriom\Plugin\ServerListing\View\Composers;

use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Illuminate\Support\Facades\Gate;

class ServerListingAdminDashboardComposer extends AdminDashboardCardComposer
{
    public function getCards()
    {
        if (!Gate::allows('server-listing.admin')) {
            return [];
        }

        return [
            'approved_servers' => [
                'color' => 'info',
                'name' => trans('server-listing::admin.card.approved_server'),
                'value' => ServerListing::approved()->count(),
                'icon' => 'bi bi-server',
            ],
            'premium_servers' => [
                'color' => 'info',
                'name' => trans('server-listing::admin.card.premium_server'),
                'value' => ServerListing::approved()->premium()->count(),
                'icon' => 'bi bi-gem',
            ],
            'this_month_bid_participants' => [
                'color' => 'info',
                'name' => trans('server-listing::admin.card.this_month_bid_participants'),
                'value' => ServerBid::whereMonth('bidding_at', now()->month)->count(),
                'icon' => 'bi bi-person-check',
            ],
            'this_month_top_10_total_bids' => [
                'color' => 'info',
                'name' => trans('server-listing::admin.card.this_month_top_10_total_bids'),
                'value' => "$" . ServerBid::whereMonth('bidding_at', now()->month)->orderBy('amount', 'asc')->take(10)->sum('amount'),
                'icon' => 'bi bi-cash-coin',
            ],
            'this_month_total_bids' => [
                'color' => 'info',
                'name' => trans('server-listing::admin.card.this_month_total_bids'),
                'value' => "$" . ServerBid::whereMonth('bidding_at', now()->month)->sum('amount'),
                'icon' => 'bi bi-cash-coin',
            ],
        ];
    }
}
