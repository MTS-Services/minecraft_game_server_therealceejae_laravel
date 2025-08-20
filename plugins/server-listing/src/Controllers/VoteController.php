<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\Vote\Site;
use Azuriom\Plugin\ServerListing\Models\Vote\Vote;
use Azuriom\Plugin\Vote\Verification\VoteChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class VoteController extends Controller
{
    /**
     * Display the vote page.
     */
    public function index($serverSlug)
    {

        $server = ServerListing::where('slug', $serverSlug)->first();
        $server->load(['user', 'serverTags', 'country']);

        $sites = $server->rewards()->with('sites')->get()->pluck('sites')->flatten()->unique('id');
        $rewards = $server->rewards()->enabled()->get();

        return view('server-listing::vote.index', [
            'server_' => $server,
            'sites' => $sites,
            'rewards' => $rewards,
            'votes' => Vote::getTopVoters(now()->startOfMonth()),
            'user' => Auth::user(),
            'ipv6' => setting('server-listing.vote.ipv4-v6-compatibility', true) ? 'true' : 'false',
        ]);
    }

    /**
     * Try to vote to the specified site.
     */
    public function vote(Request $request, ServerListing $server, Site $site)
    {
        if (setting('server-listing.vote.auth-required', false) && !Auth::check()) {
            return response()->json(['message' => trans('auth.required')], 401);
        }

        $user = Auth::user();
        $ip = $request->ip();

        if ($site->hasVoted($user, $ip)) {
            return response()->json(['message' => trans('server-listing::messages.vote.already')], 422);
        }

        $username = $this->validateVote($request, $user);

        if (!$site->has_verification) {
            Vote::createFor($site, $server, $user, $username, $ip);

            return response()->json(['message' => trans('server-listing::messages.vote.success')]);
        }

        $checker = app(VoteChecker::class);

        if (!$checker->canVote($site)) {
            return response()->json(['message' => trans('server-listing::messages.vote.checker-error')], 500);
        }

        Cache::put('votes.pending.' . $ip, $username, now()->addMinutes(5));

        return response()->json(['url' => $checker->getVerificationUrl($site, $user, $ip)]);
    }

    /**
     * This method is called when a user has voted on a website (if verification is enabled).
     */
    public function done(Request $request, $server_slug, $site_id)
    {
        $user = Auth::user();
        $ip = $request->ip();

        $server = ServerListing::where('slug', $server_slug)->firstOrFail();
        $server->load(['user', 'serverTags', 'country']);
        $site = Site::findOrFail($site_id);

        if ($site->hasVoted($user, $ip)) {
            return to_route('server-listing.vote.index', ['server' => $server->slug])->with('error', trans('server-listing::messages.vote.already'));
        }


        $username = Cache::pull('votes.pending.' . $ip, fn() => $this->validateVote($request, $user));

        Vote::createFor($site, $server, $user, $username, $ip);

        return to_route('server-listing.vote.index', ['server' => $server->slug])->with('success', trans('server-listing::messages.vote.success'));
    }

    public function submit(Request $request, $server_slug)
    {
        $validated = $this->validate($request, [
            'username' => 'required|string|max:32',
            'agree' => 'required|accepted',
        ]);
        $server = ServerListing::where('slug', $server_slug)->firstOrFail();
        $server->load(['user', 'serverTags', 'country']);

        $user = Auth::user();
        $ip = $request->ip();
        $username = $validated['username'];

        if ($user && $user->name !== $username) {
            return back()->with('error', 'Invalid username.');
        }

        $sites = $server->rewards()->with('sites')->get()->pluck('sites')->flatten()->unique('id')->where('has_verification', false);

        if ($sites->isEmpty()) {
            return back()->with('error', 'No voting sites available for this server.');
        }

        $votedCount = 0;

        foreach ($sites as $site) {
            if (!$site->hasVoted($user, $ip)) {
                Vote::createFor($site, $server, $user, $username, $ip);
                $votedCount++;
            }
        }

        if ($votedCount > 0) {
            return back()->with('success', 'Thank you for voting on ' . $votedCount . ' site(s)!');
        }

        return back()->with('error', 'You have already voted recently.');
    }

    public function verifyUser(User $user)
    {
        return response()->json(['status' => true, 'message' => 'ok']);
    }

    protected function validateVote(Request $request, ?User $user): string
    {
        if ($user) {
            return $user->name;
        }

        $validated = $this->validate($request, ['name' => 'required|string|max:32']);

        return $validated['name'];
    }
}
