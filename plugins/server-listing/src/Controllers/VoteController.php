<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Azuriom\Plugin\ServerListing\Services\VotifierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{

    protected VotifierService $votifierService;

    public function __construct(VotifierService $votifierService)
    {
        $this->votifierService = $votifierService;
    }

    public function index($slug)
    {
        $serverDetail = ServerListing::where('slug', $slug)->firstOrFail();
        return view('server-listing::vote', compact('serverDetail'));
    }

    public function store(Request $request, $slug)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:16|regex:/^[a-zA-Z0-9_]+$/',
            'privacy_agreement' => 'required|accepted|boolean',
        ]);

        $serverDetail = ServerListing::where('slug', $slug)->firstOrFail();

        // 2. Check if Votifier details are available
        if (!$serverDetail->votifier_host || !$serverDetail->votifier_port || !$serverDetail->votifier_public_key) {
            session()->flash('error', 'This server does not have Votifier configured.');
            return redirect()->back();
        }

        // 3. Send the vote to the Minecraft server
        $voteSent = $this->votifierService->sendVote(
            $serverDetail->votifier_host,
            $serverDetail->votifier_port,
            $serverDetail->votifier_public_key,
            $request->input('username')
        );

        if (!$voteSent) {
            session()->flash('error', 'Failed to send the vote to the server. Please try again later.');
            return redirect()->back();
        }

        // 4. Store the vote in your database (only if the vote was successfully sent)
        ServerVote::create([
            'server_id' => $serverDetail->id,
            'user_id' => Auth::id() ? Auth::id() : null,
            'user_name' => $validated['username'],
            'ip_address' => $request->ip(),
            'voted_at' => now(),
        ]);

        session()->flash('success', 'You have successfully voted for this server. You should receive your reward shortly!');
        return redirect()->back();
    }
}
