<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Azuriom\Plugin\ServerListing\Models\ServerVoteReward;
use Azuriom\Plugin\ServerListing\Models\ServerVoteStatistic;
use Azuriom\Plugin\ServerListing\Services\VotifierService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{

    protected VotifierService $votifierService;

    public function showVotePage($server_Slug)
    {
        $server_ = ServerListing::where('slug', $server_Slug)->first();


        // Get vote statistics
        $totalVotes = ServerVote::where('server_id', $server_->id)->count();
        $monthlyVotes = ServerVote::where('server_id', $server_->id)
            ->where('voted_at', '>=', now()->subMonth())
            ->count();

        // Get top voters (if not hidden)
        $topVoters = null;
        if (!$server_->hide_voters) {
            $topVoters = ServerVote::getTopVoters($server_->id);
        }

        // Get recent votes
        $recentVotes = ServerVote::where('server_id', $server_->id)
            ->where('status', 'success')
            ->orderByDesc('voted_at')
            ->limit(10)
            ->get(['username', 'voted_at']);

        // Get vote rewards
        $rewards = ServerVoteReward::where('server_id', $server_->id)
            ->where('status', 1)
            ->get();



        return view('server-listing::user.vote', compact(
            'server_',
            'totalVotes',
            'monthlyVotes',
            'topVoters',
            'recentVotes',
            'rewards'
        ));
    }

    public function submitVote(Request $request, $server_Slug)
    {
        $server_ = ServerListing::where('slug', $server_Slug)->firstOrFail();


        $request->validate([
            'username' => 'required|string|min:3|max:16|regex:/^[a-zA-Z0-9_]+$/',
            // 'captcha' => 'required' // Assuming you have captcha setup
        ]);

        $username = $request->username;
        $ipAddress = $request->ip();

        // Check if user has already voted recently
        $existingVote = ServerVote::where('server_id', $server_->id)
            ->where(function ($query) use ($username, $ipAddress) {
                $query->where('username', $username)
                    ->orWhere('ip_address', $ipAddress);
            })
            ->where('next_vote_at', '>', now())
            ->first();

        if ($existingVote) {
            $timeLeft = $existingVote->next_vote_at->diffForHumans();
            // return response()->json([
            //     'success' => false,
            //     'message' => "You can vote again {$timeLeft}",
            //     'next_vote_at' => $existingVote->next_vote_at->toISOString()
            // ], 422);
            return redirect()->back()->with('error', "You can vote again {$timeLeft}")->with([
                'next_vote_at' => $existingVote->next_vote_at->toISOString()
            ]);
        }

        try {
            DB::beginTransaction();

            // Create vote record
            $vote = ServerVote::create([
                'server_id' => $server_->id,
                'username' => $username,
                'ip_address' => $ipAddress,
                'voted_at' => now(),
                'next_vote_at' => now()->addHours(12), // 12 hour cooldown
                'status' => 1 // Assuming 1 means success, 0 means pending
            ]);

            // Send to Votifier if configured
            $votifierResult = null;
            if ($server_->votifier_host && $server_->votifier_port && $server_->votifier_public_key) {
                // $this->votifierService = new VotifierService(
                //     $server_->votifier_host,
                //     $server_->votifier_port,
                //     $server_->votifier_public_key
                // );
                $this->votifierService = new VotifierService(
                    "50.20.250.112",
                    "20987",
                    "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjtOO/GHfDlZam/BNbUTRUlRYc9jlOZgkOSvrDtOiqkcA0INfwD4x1GLvtUTT4rRFtlqs93ePpk8mEgrwzGfThb0vCpGjzyo9SE/b9Puqdikv4ATTHlcHZxhxQWVRXu//jOB0/q+2jKT/9/m3p+3bz4wxJfkSsmfnbwqX6t97UpfR9qZnV0UqD0vX64pJf2CqdaJYYdgcKJGqlsFs12VwTImTq46l+QH7QBxY8SGyh7uQ9FArw8btgd9QFFVIPBAiZy92e5bss7hnPJtfaD1ryrU5WfZheTh68XTEmN+T1Nm6HGqL2Hnb/3xaEv8AgU7XSFc+DC+w/qJMlSLYtulauQIDAQAB",
                );

                $votifierResult = $this->votifierService->sendVote($username);

                $vote->update([
                    'reward_sent' => $votifierResult['success'],
                    'votifier_response' => $votifierResult['response'],
                    'status' => $votifierResult['success'] ? 1 : 0
                ]);
            } else {
                $vote->update(['status' => 1]);
            }

            // Update statistics
            ServerVoteStatistic::updateStats($server_->id);

            // Increment server vote count
            $server_->increment('total_votes');

            $allServers = ServerListing::latest()->get();
            foreach ($allServers as $server) {
                $server->update([
                    'server_rank' => $server->getRankByVotes(),
                ]);
            }

            DB::commit();

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Thank you for voting!',
            //     'votifier_sent' => $votifierResult ? $votifierResult['success'] : false,
            //     'next_vote_at' => $vote->next_vote_at->toISOString()
            // ]);

            return redirect()->back()->with('success', 'Thank you for voting! You can vote again in 12 hours')->with([
                'votifier_sent' => $votifierResult ? $votifierResult['success'] : false,
                'next_vote_at' => $vote->next_vote_at->toISOString()
            ]);

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Vote submission error: ' . $e->getMessage());

            // return response()->json([
            //     'success' => false,
            //     'message' => 'An error occurred while processing your vote. Please try again.'
            // ], 500);
            return redirect()->back()->with('error', 'An error occurred while processing your vote. Please try again.');
        }
    }

    public function checkVoteStatus(Request $request, $server_Slug)
    {
        $server_ = ServerListing::where('slug', $server_Slug)->firstOrFail();

        $request->validate([
            'username' => 'required|string|min:3|max:16'
        ]);

        $vote = ServerVote::where('server_id', $server_->id)
            ->where('username', $request->username)
            ->orderByDesc('voted_at')
            ->first();

        if (!$vote) {
            return response()->json([
                'can_vote' => true,
                'message' => 'You haven\'t voted yet. Vote now to support the server!'
            ]);
        }

        $canVote = $vote->canVoteAgain();

        return response()->json([
            'can_vote' => $canVote,
            'last_vote' => $vote->voted_at->toISOString(),
            'next_vote' => $vote->next_vote_at->toISOString(),
            'time_left' => $canVote ? null : $vote->next_vote_at->diffForHumans(),
            'total_votes' => ServerVote::where('server_id', $server_->id)
                ->where('username', $request->username)
                ->count()
        ]);
    }


    public function testVotifier($server_Slug)
    {
        $server_ = ServerListing::where('slug', $server_Slug)->firstOrFail();

        $votifierService = new VotifierService(
            $server_->votifier_host,
            $server_->votifier_port,
            $server_->votifier_public_key
        );

        // Test connection
        $connectionTest = $votifierService->testConnection();

        // Test encryption
        $encryptionTest = $votifierService->testEncryption();

        return response()->json([
            'connection' => $connectionTest,
            'encryption' => $encryptionTest,
            'key_preview' => substr($server_->votifier_public_key, 0, 100) . '...'
        ]);
    }
}
