<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;

class ServerListingController extends Controller
{
    public function details()
    {
        return view('server-listing::details');
    }
}
