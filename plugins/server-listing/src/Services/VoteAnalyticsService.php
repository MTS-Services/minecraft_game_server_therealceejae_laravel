<?php

namespace Azuriom\Plugin\ServerListing\Services;

use Azuriom\Plugin\ServerListing\Models\ServerVote;

class VoteAnalyticsService
{
    public function getVoteStatistics($serverId, $period = '30days')
    {
        $startDate = $this->getPeriodStartDate($period);

        $baseQuery = ServerVote::where('server_id', $serverId)
            ->where('voted_at', '>=', $startDate);

        return [
            'total_votes' => $baseQuery->count(),
            'successful_votes' => $baseQuery->where('status', 'success')->count(),
            'failed_votes' => $baseQuery->where('status', 'failed')->count(),
            'pending_votes' => $baseQuery->where('status', 'pending')->count(),
            'unique_voters' => $baseQuery->distinct('username')->count('username'),
            'success_rate' => $this->calculateSuccessRate($baseQuery),
            'average_votes_per_day' => $this->calculateAverageVotesPerDay($baseQuery, $period),
            'top_voting_hours' => $this->getTopVotingHours($baseQuery),
            'geographical_distribution' => $this->getGeographicalDistribution($baseQuery),
        ];
    }

    public function getVoteTrends($serverId, $period = '30days')
    {
        $startDate = $this->getPeriodStartDate($period);

        return ServerVote::where('server_id', $serverId)
            ->where('voted_at', '>=', $startDate)
            ->selectRaw('DATE(voted_at) as date, COUNT(*) as votes, COUNT(DISTINCT username) as unique_voters')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'votes' => $item->votes,
                    'unique_voters' => $item->unique_voters,
                ];
            });
    }

    public function getTopVoters($serverId, $period = '30days', $limit = 10)
    {
        $startDate = $this->getPeriodStartDate($period);

        return ServerVote::where('server_id', $serverId)
            ->where('voted_at', '>=', $startDate)
            ->select('username')
            ->selectRaw('COUNT(*) as vote_count')
            ->selectRaw('MAX(voted_at) as last_vote')
            ->groupBy('username')
            ->orderByDesc('vote_count')
            ->limit($limit)
            ->get();
    }

    public function getRecentVotes($serverId, $limit = 20)
    {
        return ServerVote::where('server_id', $serverId)
            ->where('status', 'success')
            ->select('username', 'voted_at')
            ->orderByDesc('voted_at')
            ->limit($limit)
            ->get();
    }

    protected function getPeriodStartDate($period)
    {
        switch ($period) {
            case '24hours':
                return now()->subHours(24);
            case '7days':
                return now()->subDays(7);
            case '30days':
                return now()->subDays(30);
            case '90days':
                return now()->subDays(90);
            case 'year':
                return now()->subYear();
            default:
                return now()->subDays(30);
        }
    }

    protected function calculateSuccessRate($query)
    {
        $total = $query->count();
        if ($total === 0)
            return 0;

        $successful = $query->where('status', 'success')->count();
        return round(($successful / $total) * 100, 2);
    }

    protected function calculateAverageVotesPerDay($query, $period)
    {
        $total = $query->count();
        $days = $this->getPeriodDays($period);

        return $days > 0 ? round($total / $days, 2) : 0;
    }

    protected function getPeriodDays($period)
    {
        switch ($period) {
            case '24hours':
                return 1;
            case '7days':
                return 7;
            case '30days':
                return 30;
            case '90days':
                return 90;
            case 'year':
                return 365;
            default:
                return 30;
        }
    }

    protected function getTopVotingHours($query)
    {
        return $query->selectRaw('HOUR(voted_at) as hour, COUNT(*) as votes')
            ->groupBy('hour')
            ->orderByDesc('votes')
            ->limit(5)
            ->pluck('votes', 'hour')
            ->toArray();
    }

    protected function getGeographicalDistribution($query)
    {
        // This would require GeoIP integration
        // For now, return mock data
        return [
            'US' => 45,
            'CA' => 20,
            'UK' => 15,
            'DE' => 10,
            'AU' => 8,
            'Other' => 2
        ];
    }
}
