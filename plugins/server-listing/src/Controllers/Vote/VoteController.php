<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Vote;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Models\User;
use Azuriom\Plugin\ServerListing\Models\Vote\Reward;
use Azuriom\Plugin\ServerListing\Models\Vote\Site;
use Azuriom\Plugin\ServerListing\Models\Vote\Vote;
use Azuriom\Plugin\Vote\Verification\VoteChecker;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VoteController extends Controller
{
    public function vote(Request $request, Server $server, Site $site)
    {
        $user = $request->user() ?? User::firstWhere('name', $request->input('user'));

        abort_if($user === null, 401);

        $nextVoteTime = $site->getNextVoteTime($user, $request->ip());

        if ($nextVoteTime !== null) {
            return response()->json([
                'message' => $this->formatTimeMessage($nextVoteTime),
            ], 422);
        }

        $voteChecker = app(VoteChecker::class);

        if ($site->has_verification && ! $voteChecker->verifyVote($site, $user, $request->ip())) {
            return response()->json(['status' => 'pending']);
        }

        // Check again because sometimes API can be really slow...
        $nextVoteTime = $site->getNextVoteTime($user, $request->ip());

        if ($nextVoteTime !== null) {
            return response()->json([
                'message' => $this->formatTimeMessage($nextVoteTime),
            ], 422);
        }

        $reward = $site->getRandomReward();

        if ($reward !== null) {
            $vote = $site->votes()->create([
                'user_id' => $user->id,
                'server_id' => $server->id,
                'reward_id' => $reward->id,
            ]);

            $reward->dispatch($vote, [$server]);
        }

        $next = $site->vote_reset_at !== null
            ? now()->next($site->vote_reset_at)
            : now()->addMinutes($site->vote_delay);
        Cache::put('server-listing.votes.site.'.$site->id.'.'.$request->ip(), $next, $next);

        return response()->json([
            'message' => trans('server-listing::messages.vote.success', [
                'reward' => $reward?->name ?? trans('messages.unknown'),
            ]),
        ]);
    }

    private function formatTimeMessage(Carbon $nextVoteTime)
    {
        $time = $nextVoteTime->diffForHumans([
            'parts' => 2,
            'join' => true,
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ]);

        return trans('server-listing::messages.vote.delay', ['time' => $time]);
    }
}
