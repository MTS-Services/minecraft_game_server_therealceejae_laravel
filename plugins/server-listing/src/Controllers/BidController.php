<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Services\BidService;
use Azuriom\Plugin\Shop\Cart\Cart;
use Azuriom\Plugin\Shop\Models\Gateway;
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

        $data['bid'] = ServerBid::where([
            'server_listing_id' => $data['serverList']->id,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ])
            ->whereMonth('bidding_at', now()->month)
            ->whereYear('bidding_at', now()->year)
            ->first();
        return view('server-listing::user.bidding_info', $data);
    }
    public function placeBid(Request $request, $slug)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $server = ServerListing::where('slug', $slug)->firstOrFail();

        if (!biddingIsOpen()) {
            return back()->with('error', 'Bidding is closed');
        }

        $bid = ServerBid::create([
            'user_id' => Auth::id(),
            'server_listing_id' => $server->id,
            'amount' => $validated['amount'],
            'status' => 'pending',
            'bidding_at' => now(),
        ]);

        session()->flash('success', 'Bid placed successfully');
        return redirect()->back();
        // return to_route('server-listing.bids.payment', $bid);
    }
}
