<?php

namespace Azuriom\Plugin\ServerListing\Console\Commands;

use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerStats;
use Illuminate\Console\Command;

class UpdateStatsDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server-listing:update-stats-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update daily server statistics like uptime, votes, and players.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $today = today();

        foreach (ServerListing::all() as $server_) {
            $stats = ServerStats::firstOrNew([
                'server_id' => $server_->id,
                'date' => $today,
            ]);

            $dailyStats = $server_->getDailyStats($today);

            $stats->fill($dailyStats);
            $stats->save();
        }

        $this->info('Daily stats updated successfully.');
    }
}
