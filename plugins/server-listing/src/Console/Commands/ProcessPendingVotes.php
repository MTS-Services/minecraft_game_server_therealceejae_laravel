<?php

namespace Azuriom\Plugin\ServerListing\Console\Commands;

use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Exception;
use Illuminate\Console\Command;
use Azuriom\Plugin\ServerListing\Jobs\ProcessVoteJob;

class ProcessPendingVotes extends Command
{
    protected $signature = 'votes:process-pending {--timeout=300 : Timeout in seconds for pending votes}';
    protected $description = 'Process votes that are stuck in pending status';

    public function handle()
    {
        $timeout = $this->option('timeout');
        $cutoffTime = now()->subSeconds($timeout);

        $pendingVotes = ServerVote::where('status', 'pending')
            ->where('voted_at', '<', $cutoffTime)
            ->with('server')
            ->get();

        $this->info("Found {$pendingVotes->count()} pending votes to process.");

        foreach ($pendingVotes as $vote) {
            try {
                ProcessVoteJob::dispatch($vote, $vote->server);
                $this->line("Queued vote ID {$vote->id} for processing");
            } catch (Exception $e) {
                $this->error("Failed to queue vote ID {$vote->id}: " . $e->getMessage());
            }
        }

        $this->info("Finished processing pending votes.");
    }
}
