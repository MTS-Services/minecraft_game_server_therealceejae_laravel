<?php

namespace Azuriom\Plugin\ServerListing\View\Composers;

use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;
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
        ];
    }
}
