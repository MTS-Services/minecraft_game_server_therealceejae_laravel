<?php

namespace Azuriom\Plugin\ServerListing\Controllers;

use Azuriom\Http\Controllers\Controller;

class ServerListingHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        return view('server-listing::index');
    }
}
