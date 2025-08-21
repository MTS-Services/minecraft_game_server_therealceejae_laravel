<?php

namespace Azuriom\Plugin\ServerListing\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VoteNotificationService
{
    public function sendVoteNotification($vote, $server)
    {
        // Email notification to server owner
        if ($server->user && $server->user->email) {
            Mail::to($server->user->email)->queue(new VoteReceivedMail($vote, $server));
        }

        // Discord webhook notification
        if ($server->discord_webhook_url) {
            $this->sendDiscordNotification($vote, $server);
        }

        // Slack notification (if configured)
        if ($server->slack_webhook_url) {
            $this->sendSlackNotification($vote, $server);
        }

        // In-game broadcast (via Votifier or RCON)
        if ($server->enable_vote_broadcast) {
            $this->sendIngameBroadcast($vote, $server);
        }
    }

    protected function sendDiscordNotification($vote, $server)
    {
        $webhook = new \GuzzleHttp\Client();

        $embed = [
            'title' => 'New Vote Received!',
            'description' => "**{$vote->username}** just voted for **{$server->name}**",
            'color' => 3066993, // Green color
            'fields' => [
                [
                    'name' => 'Player',
                    'value' => $vote->username,
                    'inline' => true
                ],
                [
                    'name' => 'Status',
                    'value' => ucfirst($vote->status),
                    'inline' => true
                ],
                [
                    'name' => 'Reward Sent',
                    'value' => $vote->reward_sent ? 'Yes' : 'No',
                    'inline' => true
                ]
            ],
            'timestamp' => $vote->voted_at->toISOString(),
            'footer' => [
                'text' => $server->name,
                'icon_url' => $server->logo_url
            ]
        ];

        try {
            $webhook->post($server->discord_webhook_url, [
                'json' => [
                    'embeds' => [$embed]
                ]
            ]);
        } catch (Exception $e) {
            Log::error('Discord notification failed: ' . $e->getMessage());
        }
    }

    protected function sendSlackNotification($vote, $server)
    {
        // Similar implementation for Slack
        // Implementation would depend on Slack webhook format
    }

    protected function sendIngameBroadcast($vote, $server)
    {
        if ($server->rcon_enabled && $server->rcon_host && $server->rcon_password) {
            try {
                $timeout = 3;
                $rcon = new \Thedudeguy\Rcon($server->rcon_host, $server->rcon_port, $server->rcon_password, $timeout);
                $rcon->connect();
                $rcon->sendCommand("broadcast §a{$vote->username} §fhas voted for the server! §b/vote");
                $rcon->disconnect();
            } catch (Exception $e) {
                Log::error('RCON broadcast failed: ' . $e->getMessage());
            }
        }
    }
}
