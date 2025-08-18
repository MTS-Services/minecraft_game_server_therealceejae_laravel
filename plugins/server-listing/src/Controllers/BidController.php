<?php

use Azuriom\Http\Controllers\Controller;

class BidController extends Controller
{
    protected BidService $bidService;
    public function __construct(BidService $bidService)
    {
        $this->middleware(['auth:web', 'verified']);
        $this->bidService = $bidService;
    }
}