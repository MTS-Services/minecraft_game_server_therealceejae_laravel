<?php

namespace Azuriom\Plugin\ServerListing\Jobs;

use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Azuriom\Plugin\ServerListing\Models\ServerVoteStatistic;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Azuriom\Plugin\ServerListing\Services\VoteFraudDetectionService;
use Illuminate\Support\Facades\Log;
use Azuriom\Plugin\ServerListing\Services\VotifierService;
use Azuriom\Plugin\ServerListing\Services\VoteNotificationService;
use VoteSubmitted;

class ProcessVoteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ServerVote $vote;
    public ServerListing $server;
    public $tries = 3;
    public $timeout = 30;

    public function __construct(ServerVote $vote, ServerListing $server)
    {
        $this->vote = $vote;
        $this->server = $server;
    }

    public function handle()
    {
        try {
            // Fraud detection
            $fraudDetection = app(VoteFraudDetectionService::class);
            $fraudCheck = $fraudDetection->detectFraud(
                $this->vote->username,
                $this->vote->ip_address,
                $this->server->id
            );

            if ($fraudCheck['is_fraud']) {
                $this->vote->update([
                    'status' => 'failed',
                    'votifier_response' => 'Blocked: ' . $fraudCheck['reason']
                ]);

                Log::warning('Vote blocked due to fraud detection', [
                    'vote_id' => $this->vote->id,
                    'reason' => $fraudCheck['reason'],
                    'username' => $this->vote->username,
                    'ip' => $this->vote->ip_address
                ]);

                return;
            }

            // Process Votifier if configured
            $votifierResult = null;
            if ($this->server->votifier_host && $this->server->votifier_port && $this->server->votifier_public_key) {
                $votifierService = new VotifierService(
                    $this->server->votifier_host,
                    $this->server->votifier_port,
                    $this->server->votifier_public_key
                );

                $votifierResult = $votifierService->sendVote($this->vote->username);

                $this->vote->update([
                    'reward_sent' => $votifierResult['success'],
                    'votifier_response' => $votifierResult['response'] ?? $votifierResult['message'],
                    'status' => $votifierResult['success'] ? 'success' : 'failed'
                ]);

                if (!$votifierResult['success']) {
                    throw new Exception('Votifier failed: ' . $votifierResult['message']);
                }
            } else {
                $this->vote->update(['status' => 'success']);
            }

            // Update server statistics
            $this->server->increment('total_votes');
            ServerVoteStatistic::updateStats($this->server->id);

            // Send notifications
            $notificationService = app(VoteNotificationService::class);
            $notificationService->sendVoteNotification($this->vote, $this->server);

            // Trigger event
            event(new VoteSubmitted($this->vote, $this->server));

        } catch (Exception $e) {
            Log::error('Vote processing failed', [
                'vote_id' => $this->vote->id,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            // Update vote status
            $this->vote->update([
                'status' => 'failed',
                'votifier_response' => $e->getMessage()
            ]);

            // Retry if attempts remaining
            if ($this->attempts() < $this->tries) {
                $this->release(30); // Retry after 30 seconds
            }
        }
    }
    public function failed(Exception $exception)
    {
        Log::error('Vote processing permanently failed', [
            'vote_id' => $this->vote->id,
            'error' => $exception->getMessage()
        ]);
    }

}
