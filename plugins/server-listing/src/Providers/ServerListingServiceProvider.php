<?php

namespace Azuriom\Plugin\ServerListing\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Plugin\ServerListing\Verification\VoteVerifier;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\ServerListing\Models\ServerListing as Server;
use Azuriom\Plugin\ServerListing\Models\ServerTag;
use Azuriom\Plugin\ServerListing\Models\Vote\Reward;
use Azuriom\Plugin\ServerListing\Models\Vote\Site;
use Azuriom\Plugin\ServerListing\View\Composers\ServerListingAdminDashboardComposer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\View;

class ServerListingServiceProvider extends BasePluginServiceProvider
{
    public function register(): void
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        
        $this->app->bind(VoteVerifier::class, function ($app) {
            return VoteVerifier::for(''); // Domain will be set when used
        });
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
        ]);


        View::composer('admin.dashboard', ServerListingAdminDashboardComposer::class);


        Permission::registerPermissions([
            'server-listing.admin' => 'server-listing::admin.permissions.admin',
        ]);

        ActionLog::registerLogModels([
            Server::class,
            ServerTag::class,
            Reward::class,
            Site::class,
        ], 'server-listing::admin.logs');

        ActionLog::registerLogs('server-listing.vote.settings', [
            'icon' => 'hand-thumbs-up',
            'color' => 'info',
            'message' => 'server-listing::admin.logs.vote.settings',
        ]);
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
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('shop:subscriptions')->hourly();
        // $schedule->command('shop:payments')->hourly();
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'server-listing.index' => trans('server-listing::messages.title'),
            'server-listing.vote.index' => trans('server-listing::messages.vote.title'),
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
                'permission' => 'server-listing.admin',
                'items' => [
                    'server-listing.admin.servers.index' => trans('server-listing::admin.nav.servers'),
                    'server-listing.admin.tags.index' => trans('server-listing::admin.nav.tags'),
                    'server-listing.admin.vote.settings' => trans('server-listing::admin.nav.settings'),
                    'server-listing.admin.vote.sites.index' => trans('server-listing::admin.nav.sites'),
                    'server-listing.admin.vote.rewards.index' => trans('server-listing::admin.nav.rewards'),
                    'server-listing.admin.vote.votes.index' => trans('server-listing::admin.nav.votes'),
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
