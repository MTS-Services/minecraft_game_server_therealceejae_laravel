<?php
use Azuriom\Plugin\ServerListing\Models\Bid;
use Azuriom\Plugin\ServerListing\Models\ServerListing;

class BidService
{
    public function destroy(ServerListing $serverListing, Bid $bid)
    {
        $bid->delete();
    }
}