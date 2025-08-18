<?php

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\Bid;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Requests\BidRequest;
use Azuriom\Plugin\ServerListing\Services\BidService;
use Illuminate\Http\Request;
use Throwable;

class BidController extends Controller
{
    protected BidService $bidService;
    public function __construct(public BidService $bidService)
    {
        $this->middleware(['auth:web', 'verified']);
    }

    public function store(ServerListing $serverListing, BidRequest $request)
    {
        try {
            $this->bidService->store($serverListing, $request->validated());
            return back()->with('success', 'Bid placed successfully');
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(ServerListing $serverListing, Bid $bid)
    {
        try {
            $this->bidService->destroy($serverListing, $bid);
            return back()->with('success', 'Bid removed successfully');
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}