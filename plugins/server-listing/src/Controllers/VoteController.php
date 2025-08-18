<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\ServerVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function index($slug)
    {
        $serverDetail = ServerListing::where('slug', $slug)->firstOrFail();
        return view('server-listing::vote', compact('serverDetail'));
    }

    public function store(Request $request, $slug)
    {
        $serverDetail = ServerListing::where('slug', $slug)->firstOrFail();

        ServerVote::create([
            'server_id' => $serverDetail->id,
            'user_id' => Auth::id() ? Auth::id() : null,
            'user_name' => $request->input('username'),
            'ip_address' => $request->ip(),
            'voted_at' => now(),
        ]);

        session()->flash('success', 'You have successfully voted for this server.');
        return redirect()->back(compact('serverDetail'));
    }
}
