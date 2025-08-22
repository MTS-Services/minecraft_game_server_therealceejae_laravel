<?php

namespace Azuriom\Plugin\ServerListing\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\ServerListing\Console\Commands\UpdateStatsDaily;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerStats;
use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Azuriom\Plugin\ServerListing\View\Composers\ServerListingAdminDashboardComposer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Relations\Relation;

class ServerListingServiceProvider extends BasePluginServiceProvider
{
    public function register(): void
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerUserNavigation();

        $this->registerAdminNavigation();

        $this->registerSchedule();

        $this->commands([
            UpdateStatsDaily::class,
        ]);


        View::composer('admin.dashboard', ServerListingAdminDashboardComposer::class);


        Permission::registerPermissions([
            'server-listing.tag' => 'server-listing::admin.permissions.tag',
            'server-listing.server' => 'server-listing::admin.permissions.server',
            'server-listing.votes' => 'server-listing::admin.permissions.votes',
            'server-listing.stats' => 'server-listing::admin.permissions.stats',
            'server-listing.settings' => 'server-listing::admin.permissions.settings',
            'server-listing.bid' => 'server-listing::admin.permissions.bid',
        ]);

        ActionLog::registerLogModels([
            ServerListing::class,
            ServerVote::class,
            ServerStats::class,
        ], 'server-listing::admin.logs');
        // ActionLog::registerLogActions([
        //     ServerListing::class => [
        //         'created' => 'server-listing::admin.logs.server.created',
        //         'updated' => 'server-listing::admin.logs.server.updated',
        //         'deleted' => 'server-listing::admin.logs.server.deleted',
        //     ],
        //     ServerCategory::class => [
        //         'created' => 'server-listing::admin.logs.category.created',
        //         'updated' => 'server-listing::admin.logs.category.updated',
        //         'deleted' => 'server-listing::admin.logs.category.deleted',
        //     ],
        //     ServerVote::class => [
        //         'created' => 'server-listing::admin.logs.vote.created',
        //         'deleted' => 'server-listing::admin.logs.vote.deleted',
        //     ],
        //     ServerStats::class => [
        //         'created' => 'server-listing::admin.logs.stats.created',
        //     ],
        // ]);

        Relation::morphMap([
            'server_bid' => ServerBid::class,
        ]);
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('server-listing:update-stats-daily')->everyMinute();
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'server-listing.home' => trans('server-listing::messages.title'),
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'server-listing' => [
                'name' => trans('server-listing::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-server',
                'route' => 'server-listing.admin.*',
                'items' => [
                    'server-listing.admin.tags.index' => [
                        'name' => trans('server-listing::admin.nav.tags'),
                        'permission' => 'server-listing.tag',
                    ],
                    'server-listing.admin.servers.index' => [
                        'name' => trans('server-listing::admin.nav.servers'),
                        'permission' => 'server-listing.server',
                    ],
                    'server-listing.admin.bids.index' => [
                        'name' => trans('server-listing::admin.nav.bids'),
                        'permission' => 'server-listing.bid',
                    ],
                ],
            ],
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        // return [
        //     'shop' => [
        //         'route' => 'shop.profile',
        //         'name' => trans('shop::messages.profile.payments'),
        //         'icon' => 'bi bi-cash-coin',
        //     ],
        // ];
        return [];
    }
}
