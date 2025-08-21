<?php

namespace Azuriom\Plugin\ServerListing\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServerVoteReward extends Model
{
    use HasTablePrefix;
    protected $table = 'server_listing_vote_rewards';

    protected $fillable = [
        'server_id',
        'reward_name',
        'reward_description',
        'reward_commands',
        'votes_required',
        'status'
    ];

    protected $casts = [
        'reward_commands' => 'array',
        'status' => 'integer',
    ];

    public function server()
    {
        return $this->belongsTo(ServerListing::class, 'server_id', 'id');
    }


    /**
     * Get rewards that a user is eligible for based on their vote count
     */
    public static function getEligibleRewards($serverId, $userVoteCount)
    {
        return self::where('server_id', $serverId)
            ->where('status', 1)
            ->where('votes_required', '<=', $userVoteCount)
            ->orderBy('votes_required', 'desc')
            ->get();
    }

    /**
     * Get the next reward milestone for a user
     */
    public static function getNextReward($serverId, $userVoteCount)
    {
        return self::where('server_id', $serverId)
            ->where('status', 1)
            ->where('votes_required', '>', $userVoteCount)
            ->orderBy('votes_required', 'asc')
            ->first();
    }

    /**
     * Check if user has reached a new reward milestone
     */
    public static function checkNewRewards($serverId, $username, $oldVoteCount, $newVoteCount)
    {
        // Get rewards that the user just became eligible for
        $newRewards = self::where('server_id', $serverId)
            ->where('status', 1)
            ->where('votes_required', '>', $oldVoteCount)
            ->where('votes_required', '<=', $newVoteCount)
            ->orderBy('votes_required', 'asc')
            ->get();

        return $newRewards;
    }

    /**
     * Execute reward commands
     */
    public function executeCommands($username, $serverListing = null)
    {
        if (empty($this->reward_commands)) {
            return ['success' => true, 'message' => 'No commands to execute'];
        }

        $results = [];
        $serverListing = $serverListing ?: $this->server;

        foreach ($this->reward_commands as $command) {
            // Replace placeholders
            $processedCommand = $this->processCommandPlaceholders($command, $username);

            // Execute the command through your game server connection
            $result = $this->executeServerCommand($processedCommand, $serverListing);

            $results[] = [
                'command' => $processedCommand,
                'success' => $result['success'],
                'response' => $result['response'] ?? null
            ];
        }

        return [
            'success' => !collect($results)->contains('success', false),
            'results' => $results
        ];
    }

    /**
     * Process command placeholders
     */
    protected function processCommandPlaceholders($command, $username)
    {
        $placeholders = [
            '{username}' => $username,
            '{player}' => $username,
            '{reward_name}' => $this->reward_name,
            '{votes_required}' => $this->votes_required,
            '{timestamp}' => now()->timestamp,
            '{date}' => now()->format('Y-m-d H:i:s')
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $command);
    }

    /**
     * Execute a command on the game server
     */
    protected function executeServerCommand($command, $serverListing)
    {
        // This depends on your game server type and connection method
        // For Minecraft, you might use RCON, for other games different methods

        try {
            // Example for RCON connection (you'll need to implement this based on your server type)
            if ($serverListing->rcon_host && $serverListing->rcon_port && $serverListing->rcon_password) {
                return $this->executeRconCommand($command, $serverListing);
            }

            // If no RCON, you might queue the command for manual execution
            // or use another method like writing to a file that the server monitors
            return $this->queueCommand($command, $serverListing);

        } catch (\Exception $e) {
            return [
                'success' => false,
                'response' => 'Command execution failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Execute command via RCON (example implementation)
     */
    protected function executeRconCommand($command, $serverListing)
    {
        // You'll need to implement RCON connection here
        // This is just a placeholder structure

        return [
            'success' => true,
            'response' => 'Command queued for execution'
        ];
    }

    /**
     * Queue command for later execution
     */
    protected function queueCommand($command, $serverListing)
    {
        // Store command in a queue table or file for later processing
        // This is useful when you can't directly connect to the game server

        return [
            'success' => true,
            'response' => 'Command queued for execution'
        ];
    }
}


