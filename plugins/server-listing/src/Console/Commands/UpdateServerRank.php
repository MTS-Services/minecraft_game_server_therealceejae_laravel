<?php

namespace Azuriom\Plugin\ServerListing\Console\Commands;

use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Illuminate\Console\Command;

class UpdateServerRank extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server-listing:update-server-rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update server ranks based on votes and statistics every 30 minutes.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $allServers = ServerListing::latest()->get();
        foreach ($allServers as $server_) {
            $server_->update([
                'server_rank' => $server_->getRankByVotes(),
            ]);
        }
        $this->info('Daily stats updated successfully.');
    }
}
