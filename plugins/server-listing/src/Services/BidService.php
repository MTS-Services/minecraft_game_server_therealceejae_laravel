<?php

namespace Azuriom\Plugin\ServerListing\Services;

use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\ServerListing\Models\ServerListing;

class BidService
{
    public function __construct()
    {
        //
    }

    public function getBids($orderBy = 'name', $order = 'asc')
    {
        return ServerListing::orderBy($orderBy, $order)->latest();
    }


    public function getAllBids($orderBy = 'amount', $order = 'asc')
    {
        return ServerBid::orderBy($orderBy, $order)->latest();
    }
}
