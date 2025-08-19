<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\Bid;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Services\BidService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    protected BidService $bidService;
    public function __construct(BidService $bidService)
    {
        $this->middleware(['auth:web', 'verified']);
        $this->bidService = $bidService;
    }
    public function biddingInfo(string $slug)
    {
        $data['serverList'] = ServerListing::where('slug', $slug)->first();
        return view('server-listing::user.bidding_info', $data);
    }
    public function placeBid(Request $request, $slug)
    {
        $validated = $request->validate([
            'amount' => 'required',
        ]);
        $server = ServerListing::where('slug', $slug)->first();
        if (biddingIsOpen()) {
            DB::transaction(function () use ($validated, $server) {
                Bid::create([
                    'user_id' => Auth::id(),
                    'user_server_id' => $server->id,
                    'amount' => $validated['amount'],
                    'bidding_at' => now(),
                ]);
            });
            return back()->with('success', 'Bid placed successfully');
        }else {
            return back()->with('error', 'Bidding is closed');
        }
    }
}
