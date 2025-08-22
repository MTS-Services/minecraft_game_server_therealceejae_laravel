<?php

namespace Azuriom\Plugin\ServerListing\Console\Commands;

use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Azuriom\Plugin\ServerListing\Models\ServerVoteStatistic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupOldVotes extends Command
{
    protected $signature = 'server-listing:votes_cleanup';
    protected $description = 'Remove old vote records to keep database clean';

    public function handle()
    {
        try {
            $days = 30;
            $cutoffDate = now()->subDays($days);
            Log::info("Starting cleanup. Cutoff date: {$cutoffDate}");
            $deletedCount = ServerVote::whereDate('voted_at', '<', $cutoffDate)->delete();
            Log::info("Deleted votes: {$deletedCount}");

            $deletedStatsCount = ServerVoteStatistic::where('date', '<', $cutoffDate)->delete();
            Log::info("Deleted stats: {$deletedStatsCount}");

            $this->info("Cleanup completed successfully.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            Log::error("Vote cleanup failed: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $this->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
