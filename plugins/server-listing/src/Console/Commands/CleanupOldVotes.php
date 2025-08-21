<?php

namespace Azuriom\Plugin\ServerListing\Console\Commands;

use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Azuriom\Plugin\ServerListing\Models\ServerVoteStatistic;
use Illuminate\Console\Command;

class CleanupOldVotes extends Command
{
    protected $signature = 'votes:cleanup {--days=180 : Number of days to keep votes}';
    protected $description = 'Remove old vote records to keep database clean';

    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = now()->subDays($days);

        $deletedCount = ServerVote::where('voted_at', '<', $cutoffDate)->delete();

        $this->info("Cleaned up {$deletedCount} old vote records older than {$days} days.");

        // Also cleanup old vote statistics
        $deletedStatsCount = ServerVoteStatistic::where('date', '<', $cutoffDate)->delete();

        $this->info("Cleaned up {$deletedStatsCount} old vote statistics records.");
    }
}
