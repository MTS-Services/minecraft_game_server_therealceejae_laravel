<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerListing;

class ServerListingController extends Controller
{
    public function details(string $slug)
    {
        $serverDetail = ServerListing::where('slug', $slug)->firstOrFail();
        $serverDetail->load('user');
        return view('server-listing::details', compact('serverDetail'));
    }
}
 