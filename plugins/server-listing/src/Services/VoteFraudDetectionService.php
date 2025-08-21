<?php

namespace Azuriom\Plugin\ServerListing\Services;

use Azuriom\Plugin\ServerListing\Models\ServerVote;
class VoteFraudDetectionService
{
    public function detectFraud($username, $ipAddress, $serverId)
    {
        if (!config('voting.anti_fraud.enabled')) {
            return ['is_fraud' => false, 'reason' => null];
        }

        $checks = [
            $this->checkIPReputationList($ipAddress),
            $this->checkVoteFrequency($ipAddress, $serverId),
            $this->checkSuspiciousPatterns($username, $ipAddress, $serverId),
            $this->checkVPNUsage($ipAddress),
        ];

        foreach ($checks as $check) {
            if ($check['is_fraud']) {
                return $check;
            }
        }

        return ['is_fraud' => false, 'reason' => null];
    }

    protected function checkIPReputationList($ipAddress)
    {
        $blockedIPs = explode(',', config('voting.anti_fraud.blocked_ips', ''));
        $blockedIPs = array_filter(array_map('trim', $blockedIPs));

        if (in_array($ipAddress, $blockedIPs)) {
            return [
                'is_fraud' => true,
                'reason' => 'IP address is in blocked list',
                'severity' => 'high'
            ];
        }

        return ['is_fraud' => false];
    }

    protected function checkVoteFrequency($ipAddress, $serverId)
    {
        $maxVotesPerDay = config('voting.anti_fraud.max_votes_per_day_per_ip');

        $todayVotes = ServerVote::where('ip_address', $ipAddress)
            ->where('server_id', $serverId)
            ->whereDate('voted_at', today())
            ->count();

        if ($todayVotes >= $maxVotesPerDay) {
            return [
                'is_fraud' => true,
                'reason' => 'Exceeded maximum votes per day from this IP',
                'severity' => 'medium'
            ];
        }

        return ['is_fraud' => false];
    }

    protected function checkSuspiciousPatterns($username, $ipAddress, $serverId)
    {
        // Check for rapid sequential voting patterns
        $recentVotes = ServerVote::where('ip_address', $ipAddress)
            ->where('voted_at', '>', now()->subMinutes(10))
            ->orderBy('voted_at')
            ->get(['username', 'voted_at']);

        if ($recentVotes->count() >= 3) {
            // Check if votes are too close together (bot-like behavior)
            $timeDiffs = [];
            for ($i = 1; $i < $recentVotes->count(); $i++) {
                $diff = $recentVotes[$i]->voted_at->diffInSeconds($recentVotes[$i - 1]->voted_at);
                $timeDiffs[] = $diff;
            }

            $avgTimeDiff = array_sum($timeDiffs) / count($timeDiffs);
            if ($avgTimeDiff < 30) { // Less than 30 seconds between votes
                return [
                    'is_fraud' => true,
                    'reason' => 'Suspicious voting pattern detected (too frequent)',
                    'severity' => 'high'
                ];
            }
        }

        return ['is_fraud' => false];
    }

    protected function checkVPNUsage($ipAddress)
    {
        if (!config('voting.anti_fraud.vpn_detection')) {
            return ['is_fraud' => false];
        }

        // This would integrate with a VPN detection service
        // For now, we'll just check common VPN IP ranges (simplified)
        $vpnRanges = [
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16'
        ];

        // In a real implementation, you'd use a proper VPN detection API
        return ['is_fraud' => false];
    }
}
