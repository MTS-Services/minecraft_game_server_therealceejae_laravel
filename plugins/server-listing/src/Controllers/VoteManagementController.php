<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Azuriom\Plugin\ServerListing\Services\VotifierService;
use Illuminate\Http\Request;

class VoteManagementController extends Controller
{

    public function index(Request $request)
    {
        $servers = ServerListing::where('user_id', auth()->id())
            ->withCount([
                'votes' => function ($query) {
                    $query->where('voted_at', '>=', now()->subMonth());
                }
            ])
            ->get();

        return view('server-listing::admin.votes.index', compact('servers'));
    }

    public function show($serverId)
    {
        $server = ServerListing::where('id', $serverId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $votes = ServerVote::where('server_id', $serverId)
            ->orderByDesc('voted_at')
            ->paginate(50);

        $statistics = [
            'total_votes' => ServerVote::where('server_id', $serverId)->count(),
            'monthly_votes' => ServerVote::where('server_id', $serverId)
                ->where('voted_at', '>=', now()->subMonth())
                ->count(),
            'daily_votes' => ServerVote::where('server_id', $serverId)
                ->whereDate('voted_at', now())
                ->count(),
            'success_rate' => ServerVote::where('server_id', $serverId)
                ->where('status', 'success')
                ->count() / max(ServerVote::where('server_id', $serverId)->count(), 1) * 100
        ];

        return view('server-listing::admin.votes.show', compact('server', 'votes', 'statistics'));
    }

    public function testVotifier($serverId)
    {
        $server = ServerListing::where('id', $serverId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$server->votifier_host || !$server->votifier_port || !$server->votifier_public_key) {
            return response()->json([
                'success' => false,
                'message' => 'Votifier configuration is incomplete'
            ]);
        }

        $votifierService = new VotifierService(
            $server->votifier_host,
            $server->votifier_port,
            $server->votifier_public_key
        );

        $result = $votifierService->testConnection();

        return response()->json($result);
    }

    public function resendVote($voteId)
    {
        $vote = ServerVote::findOrFail($voteId);
        $server = $vote->server;

        // Check if user owns the server
        if ($server->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$server->votifier_host || !$server->votifier_port || !$server->votifier_public_key) {
            return response()->json([
                'success' => false,
                'message' => 'Votifier configuration is incomplete'
            ]);
        }

        $votifierService = new VotifierService(
            $server->votifier_host,
            $server->votifier_port,
            $server->votifier_public_key
        );

        $result = $votifierService->sendVote(
            $vote->username,
            'MinecraftMP',
            $vote->ip_address,
            $vote->voted_at->timestamp
        );

        $vote->update([
            'reward_sent' => $result['success'],
            'votifier_response' => $result['response'],
            'status' => $result['success'] ? 'success' : 'failed'
        ]);

        return response()->json($result);
    }

    public function exportVotes($serverId, Request $request)
    {
        $server = ServerListing::where('id', $serverId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $votes = ServerVote::where('server_id', $serverId)
            ->when($request->start_date, function ($query, $date) {
                return $query->whereDate('voted_at', '>=', $date);
            })
            ->when($request->end_date, function ($query, $date) {
                return $query->whereDate('voted_at', '<=', $date);
            })
            ->orderByDesc('voted_at')
            ->get();

        $csv = "Username,IP Address,Voted At,Status,Reward Sent\n";

        foreach ($votes as $vote) {
            $csv .= sprintf(
                "%s,%s,%s,%s,%s\n",
                $vote->username,
                $vote->ip_address,
                $vote->voted_at->toDateTimeString(),
                $vote->status,
                $vote->reward_sent ? 'Yes' : 'No'
            );
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="votes-' . $server->slug . '.csv"'
        ]);
    }
}
