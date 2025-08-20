<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin\Vote;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\Vote\Reward;
use Azuriom\Plugin\ServerListing\Models\Vote\Site;
use Azuriom\Plugin\ServerListing\Requests\Vote\SiteRequest;
use Azuriom\Plugin\Vote\Verification\VoteChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('server-listing::admin.vote.sites.index', ['sites' => Site::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $checker = app(VoteChecker::class);

        return view('server-listing::admin.vote.sites.create', [
            'rewards' => Reward::all(),
            'sites' => $checker->getSites(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteRequest $request)
    {
        $site = Site::create(Arr::except($request->validated(), 'rewards'));

        $site->rewards()->sync($request->input('rewards', []));

        return to_route('server-listing.admin.vote.sites.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('server-listing::admin.vote.sites.edit', [
            'rewards' => Reward::all(),
            'site' => $site->load('rewards'),
            'sites' => app(VoteChecker::class)->getSites(),
        ]);
    }

    public function verificationForUrl(Request $request)
    {
        $voteUrl = $request->query('url');

        if ($voteUrl === null) {
            return response()->json(['message' => 'Invalid URL'], 422);
        }

        $checker = app(VoteChecker::class);

        $host = $checker->parseHostFromUrl($voteUrl);

        if ($host === null) {
            return response()->json(['message' => 'Invalid URL'], 422);
        }

        if (! $checker->hasVerificationForSite($host)) {
            return response()->json([
                'domain' => $host,
                'info' => trans('server-listing::admin.vote.sites.verifications.disabled'),
                'supported' => false,
            ]);
        }

        $verifier = $checker->getVerificationForSite($host);

        if (! $verifier->requireVerificationKey()) {
            return response()->json([
                'domain' => $host,
                'info' => trans('server-listing::admin.vote.sites.verifications.auto'),
                'supported' => true,
                'automatic' => true,
            ]);
        }

        $message = trans('server-listing::admin.vote.sites.verifications.input');

        if ($verifier->hasPingback()) {
            $message .= ' '.trans('server-listing::admin.vote.sites.verifications.pingback', [
                'url' => route('server-listing.api.vote.sites.pingback', $host),
            ]);
        }

        return response()->json([
            'domain' => $host,
            'info' => $message,
            'supported' => true,
            'automatic' => false,
            'label' => trans('server-listing::admin.vote.sites.verifications.'.$verifier->verificationTypeKey()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteRequest $request, Site $site)
    {
        $site->update(Arr::except($request->validated(), 'rewards'));

        $site->rewards()->sync($request->input('rewards', []));

        return to_route('server-listing.admin.vote.sites.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Site $site)
    {
        $site->delete();

        return to_route('server-listing.admin.vote.sites.index')
            ->with('success', trans('messages.status.success'));
    }
}
