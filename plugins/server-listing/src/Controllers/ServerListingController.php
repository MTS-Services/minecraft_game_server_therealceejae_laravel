<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;

class ServerListingController extends Controller
{
    public function details(string $slug)
    {
        return view('server-listing::details');
    }
}
