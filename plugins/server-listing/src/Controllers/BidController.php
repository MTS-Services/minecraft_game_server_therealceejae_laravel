<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Services\BidService;

class BidController extends Controller
{
    protected BidService $bidService;
    public function __construct(BidService $bidService)
    {
        $this->middleware(['auth:web', 'verified']);
        $this->bidService = $bidService;
    }
}