<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin\Vote;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the vote settings page.
     */
    public function show()
    {
        $commands = setting('server-listing.vote.commands');

        return view('server-listing::admin.vote.settings', [
            'topPlayersCount' => setting('server-listing.vote.top-players-count', 10),
            'displayRewards' => setting('server-listing.vote.display-rewards', true),
            'ipCompatibility' => setting('server-listing.vote.ipv4-v6-compatibility', true),
            'authRequired' => setting('server-listing.vote.auth-required', false),
            'commands' => $commands ? json_decode($commands) : [],
        ]);
    }

    /**
     * Update the settings.
     */
    public function save(Request $request)
    {
        $validated = $this->validate($request, [
            'top-players-count' => ['numeric', 'min:1'],
            'commands' => ['sometimes', 'nullable', 'array'],
        ]);

        $commands = $request->input('commands');

        Setting::updateSettings([
            'server-listing.vote.top-players-count' => $validated['top-players-count'],
            'server-listing.vote.display-rewards' => $request->has('display-rewards'),
            'server-listing.vote.ipv4-v6-compatibility' => $request->has('ipv4-v6-compatibility'),
            'server-listing.vote.auth-required' => $request->has('auth-required'),
            'server-listing.vote.commands' => is_array($commands) ? json_encode(array_filter($commands)) : null,
        ]);

        ActionLog::log('server-listing.vote.settings.updated');

        return to_route('server-listing.admin.vote.settings')
            ->with('success', trans('messages.status.success'));
    }
}
