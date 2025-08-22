<?php

namespace Azuriom\Plugin\ServerListing\Console\Commands;

use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerStats;
use Illuminate\Console\Command;
use Azuriom\Plugin\ServerListing\Services\ServerStatusService;

class UpdateStatsDaily extends Command
{
    protected ServerStatusService $serverStatusService;

    public function __construct(ServerStatusService $serverStatusService)
    {
        parent::__construct();
        $this->serverStatusService = $serverStatusService;
    }
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

        foreach (ServerListing::latest()->get() as $server_) {

            try {
                // $dailyStats = $server_->getDailyStats($today);
                $data = $this->serverStatusService->getServerUpdatedData($server_->ip, $server_->port);
                if ($data['success']) {

                    $stats = ServerStats::firstOrNew([
                        'server_id' => $server_->id,
                        'date' => $today,
                    ]);
                    $validated['logo_image'] = $data['server_data']['icon'];
                    $validated['motd'] = implode('<br> ', $data['server_data']['motd']['html']);
                    $validated['minecraft_version'] = $data['server_data']['protocol']['name'];
                    $validated['max_players'] = $data['server_data']['players']['max'];
                    $validated['current_players'] = $data['server_data']['players']['online'];
                    $validated['server_port'] = $data['server_data']['port'];
                    $validated['server_datas'] = $data['server_data'];
                    $validated['is_online'] = $data['server_data']['is_online'];
                    $validated['server_rank'] = $server_->getRankByVotes();

                    $server_->update($validated);

                    $date = $date ? now()->parse($date) : today();

                    $server_->refresh();

                    $server_->loadCount('votes');

                    $uniqueVotes = $server_->votes()
                        ->whereDate('created_at', $date)
                        ->count();

                    $totalVotes = $server_->votes()
                        ->whereDate('created_at', $date)
                        ->count();

                    $avgPlayers = 0;
                    $maxPlayers = 0;
                    $uptime = 0.00;

                    if ($server_->is_online) {
                        $uptime = 100.00;
                    }
                    $onlinePlayers = $server_->current_players;
                    $maxPlayers = $server_->max_players;
                    $avgPlayers = $onlinePlayers;
                    $dailyStats = [
                        'unique_votes' => $uniqueVotes,
                        'total_votes' => $totalVotes,
                        'avg_players' => $avgPlayers,
                        'max_players_reached' => $maxPlayers,
                        'uptime_percentage' => $uptime,
                        'position' => 0,
                    ];

                    $stats->fill($dailyStats);
                    $stats->save();

                }
            } catch (\Throwable $e) {
                $server_->update(['is_approved' => false, 'is_online' => false]);
                $this->error('Failed to update stats for server ID ' . $server_->id . ': ' . $e->getMessage());
                continue;
            }
        }

        $this->info('Daily stats updated successfully.');
    }
}
